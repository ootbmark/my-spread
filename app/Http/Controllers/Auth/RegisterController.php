<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Models\Group;
use App\Models\Organisation;
use App\Models\University;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Services\FileService;
use App\Services\SeoService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        SeoService::setPageMeta('register');
        $organisations = Organisation::where('status', Organisation::ACTIVE)->orderBy('type', 'desc')->orderBy('name')->get();
        $universities = University::where('status', University::ACTIVE)->orderBy('name')->get();
        return view('auth.register', compact('universities', 'organisations'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users', 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email_confirmation' => ['required', 'string', 'same:email'],
            'personal_email' => ['nullable', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'string', 'same:password'],
            'reg_source' => ['required', 'string', 'max:255'],
            'why_spread' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'linkedin_url' => ['nullable', 'string', 'url', 'max:255'],
            'organisation_id' => ['required'],
            'organisation_name' => ['required_if:organisation_id,new'],
            'organisation_email' => ['nullable', 'email', 'max:255'],
            #'image' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ];

        $organisation = Organisation::find(request()->get('organisation_id'));
        if ($organisation && $organisation->type == 'student') {
            $rules['university_id'] = ['required'];
            $rules['university'] = ['required_if:university_id,new'];
        }

        if (request()->get('reg_source') == 'Others') {
            $rules['other_reg_source'] = ['required', 'string', 'max:255'];
        }

        $messages = [
            'password_confirmation.same' => 'The password confirmation does not match.',
            'email_confirmation.same' => 'The email confirmation does not match.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if ($data['organisation_id'] == 'new') {
            $organisation = Organisation::where('name', $data['organisation_name'])->first();
            if ($organisation === null) {
                $organisation = Organisation::create([
                    'name' => $data['organisation_name'],
                    'short_name' => $data['organisation_name'],
                    'email' => $data['organisation_email'],
                ]);
            }
            $data['organisation_id'] = $organisation->id;
        }

        if ($data['university_id'] == 'new') {
            $university = University::where('name', $data['university'])->first();
            if ($university === null) {
                $university = University::create([
                    'name' => $data['university'],
                ]);
            }
            $data['university_id'] = $university->id;
        }

        if ($data['reg_source'] == 'Others') {
            $data['reg_source'] = $data['other_reg_source'];
        }
        $last_user = User::orderBy('id', 'desc')->first();
        if ($last_user) {
            $number = $last_user->number + 1;
        } else {
            $number =  1;
        }
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'organisation_id' => $data['organisation_id'],
            'email' => $data['email'],
            'username' => $data['username'],
            'personal_email' => $data['personal_email'] ?? null,
            'address' => $data['address'] ?? null,
            'why_spread' => $data['why_spread'],
            'location' => $data['location'],
            'job_title' => $data['job_title'],
            'university_id' => $data['university_id'],
            'reg_source' => $data['reg_source'] ?? null,
            'linkedin_url' => $data['linkedin_url'] ?? null,
            'password' => Hash::make($data['password']),
            'number' => $number,
            'is_subscribed' => $data['is_subscribed'] ?? 0,
        ]);
        $user->groups()->sync(Group::pluck('id')->toArray());
        if (isset($data['image'])) {
            $service = new FileService();
            $service->saveImage($data['image'], $user, 'users');
        }

        flash()->success(nl2br(HomeController::MESSAGE_REGISTERED));
        return $user;
    }
}
