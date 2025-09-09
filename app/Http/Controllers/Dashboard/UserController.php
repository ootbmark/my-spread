<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPasswordRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserStatusRequest;
use App\Models\Company;
use App\Models\Organisation;
use App\Models\Quiz;
use App\Models\University;
use App\Models\User;
use App\Services\SeoService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        SeoService::setPageMeta('dashboard');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $users = User::when($request->get('status'), function ($q) use ($request) {
            return $q->where('users.status', $request->get('status'));
        })
            ->when($request->get('organisation'), function ($query) use ($request) {
                return $query->join('organisations', 'users.organisation_id', '=', 'organisations.id')
                    ->where('organisations.name', 'LIKE', '%' . $request->get('organisation') . '%');
            })
            ->when($request->get('location'), function ($q) use ($request) {
                return $q->where('location', 'LIKE', '%' . $request->get('location') . '%');
                //            ->orWhere(DB::raw('concat(first_name," ",last_name)'), 'like', '%'. $request->get('search') .'%');
            })->when(
                $request->get('not_verified') == 1,
                function ($q) {
                    return $q->whereNull('email_verified_at');
                },
                function ($q) {
                    return $q->whereNotNull('email_verified_at');
                }
            )
            ->sortable(['id' => 'desc'])
            ->paginate(m_per_page());

        return view('dashboard.users.index', compact('users'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $organisations = Organisation::where('status', Organisation::ACTIVE)->orderBy('type', 'desc')->orderBy('name')->get();
        $universities = University::where('status', University::ACTIVE)->orderBy('name')->get();
        $quizes = Quiz::all();
        $selected_quizes = $user->allowed_quizes()->pluck('quizes.id')->toArray();
        $companies = Company::all();
        $selected_companies = $user->companies()->pluck('companies.id')->toArray();

        return view('dashboard.users.edit', compact(
            'user',
            'organisations',
            'universities',
            'quizes',
            'selected_quizes',
            'companies',
            'selected_companies',
        ));
    }


    /**
     * @param $id
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, UserRequest $request)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        $user->allowed_quizes()->sync($request->get('allowed_workshops', []));
        $user->companies()->sync($request->get('allowed_companies', []));

        flash()->success('User updated');
        return back();
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'deleted';
        $user->save();
        flash()->success('User deleted');
        return back();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function message(Request $request)
    {
        $data = $request->all();
        $user = User::find($request->get('id'));
        Mail::send('emails.message', ['body' => $data['message'], 'user' => $user], function ($m) use ($data, $user) {
            $m->to($user->email)->subject($data['subject']);
        });
        flash()->success('Message sent!');
        return back();
    }


    /**
     * @param $id
     * @param UserStatusRequest $request
     */
    public function status($id, UserStatusRequest $request)
    {
        $user = User::findOrFail($id);
        $user->status = $request->get('status');
        $user->save();
        if ($user->is_subscribed && $request->get('message')) {
            Mail::send(
                'emails.user_status',
                ['body' => $request->get('message'), 'user' => $user],
                function ($m) use ($user) {
                    $m->to($user->email)->subject('Administrator has changed your status to ' . $user->status);
                }
            );
        }

        flash()->success('Status changed!');
        return back();
    }

    /**
     * @param $id
     */
    public function verify(int $id)
    {
        $user = User::findOrFail($id);
        $user->markEmailAsVerified();
        event(new Verified($user));

        flash()->success('User verified!');
        return back();
    }


    /**
     * @param $id
     * @param UserPasswordRequest $request
     */
    public function password($id, UserPasswordRequest $request)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make($request->get('password'));
        $user->save();
        flash()->success('Password changed!');
        return back();
    }
}
