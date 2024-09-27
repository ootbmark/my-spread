<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\SendContactEmailRequest;
use App\Models\Group;
use App\Models\Organisation;
use App\Models\University;
use App\Repositories\OrganisationRepository;
use App\Repositories\UserRepository;
use App\Services\FileService;
use App\Services\SeoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var OrganisationRepository
     */
    protected $organisationRepository;

    /**
     * ProfileController constructor.
     */
    public function __construct(UserRepository $userRepository, OrganisationRepository $organisationRepository)
    {
        SeoService::setPageMeta('profile');
        $this->userRepository = $userRepository;
        $this->organisationRepository = $organisationRepository;
    }


    /**
     * @return View
     */
    public function index(): View
    {
        $user = Auth::user();
        $favorites = $user->favorites()->active()->withCount('active_replies')->paginate(10);
        return view('profile.index', compact('favorites'));
    }


    /**
     * @return View
     */
    public function info(): View
    {
        $organisations = Organisation::where('status', Organisation::ACTIVE)->orderBy('type', 'desc')->orderBy('name')->get();
        $universities = University::where('status', University::ACTIVE)->orderBy('name')->get();
        return view('profile.info', compact('organisations', 'universities'));
    }


    /**
     * @return View
     */
    public function discussions(): View
    {
        $user = Auth::user();
        $threads = $user->threads()->active()->paginate(10);
        return view('profile.discussions', compact('threads'));
    }


    /**
     * @return View
     */
    public function replies(): View
    {
        $user = Auth::user();
        $replies = $user->replies()->active()->paginate(10);
        return view('profile.replies', compact('replies'));
    }


    /**
     * @param ProfileRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $old_email = $user->email;
        $send_alert = $request->get('email') != $user->email;
        $user->update($request->all());

        if ($send_alert) {
            Mail::send('emails.email_changed', ['user' => $user, 'old_email' => $old_email], function ($m) {
                $m->to(config('mail.notifications'))->subject('A user has changed their primary email');
            });
        }

        flash()->success('Profile updated!');
        return back();
    }


    /**
     * @return View
     */
    public function password(): View
    {
        return view('profile.password');
    }


    /**
     * @param PasswordRequest $request
     * @return RedirectResponse
     */
    public function passwordUpdate(PasswordRequest $request): RedirectResponse
    {
        if (!Hash::check($request->get('current_password'), Auth::user()->password)) {
            flash()->error('The password does not match.');
            return back();
        }
        $user = Auth::user();
        $user->update(['password' => Hash::make($request->get('password'))]);

        flash()->success('Password updated!');
        return back();
    }


    /**
     * @return View
     */
    public function notifications(): View
    {
        $groups = Group::all();
        $selected_groups = Auth::user()->groups()->pluck('id')->toArray();
        return view('profile.notifications', compact('groups', 'selected_groups'));
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function notificationsUpdate(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $data = $request->all();

        if (!isset($data['alert'])) {
            $data['alert'] = null;
        } else {
            if (count($data['alert']) > 1) {
                $data['alert'] = 2;
            } else {
                $data['alert'] = $data['alert'][0];
            }
        }
        if (isset($data['alert_to_personal'])) {
            if (count($data['alert_to_personal']) > 1) {
                $data['alert_to_personal'] = 2;
            } else {
                $data['alert_to_personal'] = $data['alert_to_personal'][0];
            }

        }
        $user->update($data);
        $user->groups()->sync($request->get('groups', []));

        flash()->success('Notification settings updated!');
        return back();
    }

    /**
     * @return View
     */
    public function invite(): View
    {
        return view('profile.invite');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function find(Request $request): View
    {
        return view('profile.find', [
            'organisations' => $this->organisationRepository->getOrderBy('name'),
            'users' => $this->userRepository->getOrderBy('first_name'),
            'searchedUsers' => $this->userRepository->getSearchedUsers($request)
        ]);
    }

    /**
     * @param SendContactEmailRequest $request
     * @param int $user_id
     * @return RedirectResponse
     */
    public function sendContactEmail(SendContactEmailRequest $request, int $user_id): RedirectResponse
    {
        $data = $request->validated();
        $user = $this->userRepository->findOrFail($user_id);
        Mail::send('emails.contact-user', ['userFirstName' => $user->first_name, 'text' => $data['message']], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('A My-SPREAD member wants to connect with you');
        });
        flash()->success('Your message has been successfully sent!');

        return back();
    }


    /**
     * @param InviteRequest $request
     * @return RedirectResponse
     */
    public function inviteSubmit(InviteRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $emails = $request->get('emails');
        $emails = array_filter($emails);
        $body = $request->get('message');
        foreach ($emails as $email) {
            Mail::send('emails.invite', ['user' => $user, 'body' => $body], function ($m) use ($email) {
                $m->to($email)->subject('Invite to My Spread');
            });
        }
        flash()->success('Invitation sent!');
        return back();
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function imageUpdate(Request $request): JsonResponse
    {
        $user = Auth::user();
        $file_service = new FileService();
        $file_service->saveCropImage($request->get('image'), $user, 'users');
        return response()->json(['status' => 'success'], 200);
    }


    /**
     * @return RedirectResponse
     */
    public function imageDelete(): RedirectResponse
    {
        $user = Auth::user();
        $user->image = null;
        $user->save();

        flash()->success('Avatar deleted');
        return back();
    }
}
