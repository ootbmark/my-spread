<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Setting;
use App\Models\Thread;
use App\Models\User;
use App\Services\ShareService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
class HomeController extends Controller
{
    const MESSAGE_REGISTERED = <<<MSG
Congratulations, you have successfully submitted your application. Would you please check your email inbox for a verification link and click on it? (This is an anti-spam measure). Depending on your email provider, You might find this verification email in the junk/bulk/notifications folder.
Once your email address is verified, your account will be activated by a forum moderator, and you will receive a welcome email - this usually is very quick - but could take a day or two.
You can immediately submit ONE discussion before your account is activated, but it will not go live until your account is activated.
MSG;

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        if ($request->has('registered')) {
            flash()->success(nl2br(self::MESSAGE_REGISTERED));

            return redirect()->route('home');
        }

        $share_service = new ShareService();
        $share_service->linkedin(Thread::first());
        $users_count = number_format(User::active()->count(), 0, '.', ',');
        $threads_count = number_format(Thread::active()->count(), 0, '.', ',');
        $replies_count = number_format(Reply::active()->count(), 0, '.', ',');
        $settings = Setting::pluck('value', 'key')->toArray();
        $recent_threads = Thread::withCount('active_replies')->orderBy('activity_date', 'desc')
            ->active()->take(12)->get();
        $novice_threads = Thread::withCount('active_replies')->orderBy('id', 'desc')
            ->whereHas('group', function ($q){
                return $q->where('type', 'novice');
            })->active()->take(4)->get();
        $latest_members = User::with('organisation')->active()->orderBy('id', 'desc')->take(5)->get();

        return view('home', compact('users_count', 'threads_count', 'replies_count',
            'recent_threads', 'novice_threads', 'latest_members', 'settings'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function home(Request $request)
    {
        if ($request->has('registered')) {
            flash()->success(nl2br(self::MESSAGE_REGISTERED));

            return redirect()->route('home');
        }

        $share_service = new ShareService();
        $share_service->linkedin(Thread::first());
        $users_count = User::active()->count();
        $threads_count = Thread::active()->count();
        $replies_count = Reply::active()->count();
        $settings = Setting::pluck('value', 'key')->toArray();
        $recent_threads = Thread::withCount('active_replies')->orderBy('activity_date', 'desc')
            ->active()->take(12)->get();
        $novice_threads = Thread::withCount('active_replies')->orderBy('id', 'desc')
            ->whereHas('group', function ($q){
                return $q->where('type', 'novice');
            })->active()->take(4)->get();
        $latest_members = User::with('organisation')->active()->orderBy('id', 'desc')->take(5)->get();

        return view('home_new', compact('users_count', 'threads_count', 'replies_count',
            'recent_threads', 'novice_threads', 'latest_members', 'settings'));
    }

    /**
     * @param Request $request
     */
    public function activity(Request $request)
    {
       Activity::create([
          'user_id' => Auth::id(),
          'ip' => $_SERVER['REMOTE_ADDR'],
          'url' => $request->get('url'),
       ]);

       $setting = Setting::where('key', 'activity_yearly')->first();

       $setting->value += 1;
       $setting->save();

       return response()->json(['status' => 'success'], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function linkedin(Request $request)
    {
        $config = config('services.linkedin');

        $access_token = $config['token'];

        $link = 'https://my-spread.com';
        $linkedin_id = $config['id'];
        $body = new \stdClass();
        $body->content = new \stdClass();
        $body->content->contentEntities[0] = new \stdClass();
        $body->text = new \stdClass();
        $body->content->contentEntities[0]->thumbnails[0] = new \stdClass();
        $body->content->contentEntities[0]->entityLocation = $link;
        $body->content->contentEntities[0]->thumbnails[0]->resolvedUrl = "https://my-spread.com/image/map3.png";
        $body->content->title = 'My Spread Forum';
        $body->owner = 'urn:li:person:'.$linkedin_id;
        $body->text->text = 'Welcome to My-Spread, the Worlds Premier Drilling Forum';
        $body_json = json_encode($body, true);

        try {
            $client = new Client(['base_uri' => 'https://api.linkedin.com']);
            $response = $client->request('POST', '/v2/shares', [
                'headers' => [
                    "Authorization" => "Bearer " . $access_token,
                    "Content-Type"  => "application/json",
                    "x-li-format"   => "json"
                ],
                'body' => $body_json,
            ]);

            if ($response->getStatusCode() !== 201) {
                dd( 'Error: '. $response->getLastBody()->errors[0]->message);
            }

            dd('Post is shared on LinkedIn successfully.') ;
        } catch(\Exception $e) {
            dd($e->getMessage(). ' for link '. $link);
        }
//        try {
//            $client = new Client(['base_uri' => 'https://api.linkedin.com']);
//            $response = $client->request('GET', '/v2/me', [
//                'headers' => [
//                    "Authorization" => "Bearer " . $access_token,
//                ],
//            ]);
//            $data = json_decode($response->getBody()->getContents(), true);
//            $linkedin_profile_id = $data['id']; // store this id somewhere
//            dd($linkedin_profile_id);
//        } catch(\Exception $e) {
//            echo $e->getMessage();
//        }
        dd('ok');
        if($request->get('code')){
            try {
                $client = new Client(['base_uri' => 'https://www.linkedin.com']);
                $response = $client->request('POST', '/oauth/v2/accessToken', [
                    'form_params' => [
                        "grant_type" => "authorization_code",
                        "code" => $request->get('code'),
                        "redirect_uri" => $config['redirect_code'],
                        "client_id" => $config['client_id'],
                        "client_secret" => $config['client_secret'],
                    ],
                ]);
                $data = json_decode($response->getBody()->getContents(), true);
                $access_token = $data['access_token'];
                dd($access_token);
            } catch(\Exception $e) {
                echo $e->getMessage();
            }

        }else{
            if(count($request->all())){
                dd($request->all());
            }
            return redirect('https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=' .
                $config['client_id'] . '&redirect_uri=' . $config['redirect_code'] . '&scope=' . $config['scopes']);
        }

    }
}
