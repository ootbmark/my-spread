<?php

namespace App\Http\Controllers\Auth;

use App\Models\Group;
use App\Models\Organisation;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    protected $redirectTo = '/';

    /**
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * _ Obtain the user information from provider.  Check if the user already exists in our
     * _ database by looking up their provider_id in the database.
     * _ If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * _ redirect them to the authenticated users homepage.
     * _ @param $provider
     * _ @return Response
     * _/**/
    public function handleProviderCallback($provider)
    {
        try{
            $user = Socialite::driver($provider)->user();
        }catch (\Exception $e)
        {
            return redirect()->route('register');
        }
        if (is_null($user->email)) {
            return redirect()->route('register');
        }
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }

    /**
     * _ If a user has registered before using social auth, return the user
     * _ else, create a new user object.
     * _ @param  $user Socialite user object
     * _ @param $provider Social auth provider
     * _ @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->orWhere('email', $user->email)->first();

        if ($authUser) {
            return $authUser;
        }

        $username = str_replace(' ', '_', $user->name);
        $count = User::where('username', 'LIKE', $username . '%')->count();

        if($count > 0){
            $username  .= "_$count";
        }
        $organisation = Organisation::where('short_name', 'MySpread')->first();
        $last_user = User::orderBy('id', 'desc')->first();
        if($last_user){
            $number = $last_user->number + 1;
        }else{
            $number =  1;
        }
        $db_user = User::create([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'username' => $username,
            'password' => '',
            'provider' => $provider,
            'provider_id' => $user->id,
            'email_verified_at' => now(),
            'number' => $number,
            'organisation_id' => $organisation->id ?? 1
        ]);
        if($user->avatar != ''){
            $file_service = new FileService();
            $image_name = time() . rand(1000000, 9999999) . '.jpg';
            $file_service->saveFileFromContent(file_get_contents($user->avatar), $image_name, 'users', $db_user);
        }
        $db_user->groups()->sync(Group::pluck('id')->toArray());
        try{
            Mail::send('emails.welcome', ['user' => $db_user], function ($m) use ($db_user){
                $m->to($db_user->email, $db_user->name)->subject('Welcome to My-Spread');
            });
            Mail::send('emails.new_user', ['user' => $db_user], function ($m) use ($db_user){
                $m->to(config('mail.notifications'))->subject('New user in forum: ' . $db_user->username);
            });
        }catch (\Exception $e){}

        return $db_user;

    }
}
