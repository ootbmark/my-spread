<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThreadRequest;
use App\Models\File;
use App\Models\Group;
use App\Models\Thread;
use App\Models\User;
use App\Services\FileService;
use App\Services\SaveFiles\SaveFilesFromRequestService;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ThreadController extends Controller
{

    /** @var SaveFilesFromRequestService */
    private $filesSaver;

    /**
     * ThreadController constructor.
     *
     * @param SaveFilesFromRequestService $filesSaver
     */
    public function __construct(SaveFilesFromRequestService $filesSaver)
    {
        $this->filesSaver = $filesSaver;

        SeoService::setPageMeta('dashboard');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $threads = Thread::with('group')
            ->when($request->get('status'), function ($q) use ($request) {
                return $q->where('status', $request->get('status'));
            })->when($request->get('search'), function ($q) use ($request){
                return $q->where('subject', 'LIKE', '%' . $request->get('search') . '%')
                    ->orWhere('body', 'LIKE', '%' . $request->get('search') . '%');
            })->where('status', '!=', 'preview')
            ->sortable(['id' => 'desc'])->paginate(m_per_page());
        return view('dashboard.threads.index', compact('threads'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $thread = Thread::findOrFail($id);
        $users = User::all();
        $groups = Group::all();
        return view('dashboard.threads.edit', compact('thread', 'users', 'groups'));
    }


    /**
     * @param $id
     * @param ThreadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, ThreadRequest $request)
    {
        $thread = Thread::findOrFail($id);
        if($request->get('submit') == 'preview')
        {
            $preview = $thread->replicate();
            $preview->push();
            $preview->update($request->all());
            $preview->status = 'preview';
            $preview->source_id = $thread->id;
            $preview->save();

            $this->getFilesSaver()->save($request, $preview);

            return redirect()->route('discussions.edit.preview', $preview->id);
        }
        $data = $request->all();
        if($thread->status == 'parked' && $data['status'] == 'active')
        {
            $data['created_at'] = now();
        }
        $thread->update($data);
        $this->getFilesSaver()->save($request, $thread);

        flash()->success('Thread updated');
        return back();
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $thread = Thread::findOrFail($id);
        $thread->status = 'deleted';
        $thread->save();
        flash()->success('Discussion removed');
        return back();
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function close($id, Request $request)
    {
        $thread = Thread::findOrFail($id);
        $thread->is_closed = 1;
        $thread->save();
        if($thread->user->is_subscribed){
            Mail::send('emails.thread_closed',
                ['user' => $thread->user, 'thread' => $thread, 'reason' => $request->get('message')],
                function ($m) use ($thread){
                    $m->to($thread->user->email)->subject('Administrator has locked your discussion');
                });
        }
        flash()->success('Discussion locked');
        return back();
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function open($id)
    {
        $thread = Thread::findOrFail($id);
        $thread->is_closed = 0;
        $thread->save();
        flash()->success('Discussion unlocked');
        return back();
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function park($id, Request $request)
    {
        $thread = Thread::findOrFail($id);
        $thread->status = 'parked';
        $thread->save();
        if($thread->user->is_subscribed){
            Mail::send('emails.thread_parked',
                ['user' => $thread->user, 'thread' => $thread, 'reason' => $request->get('message')],
                function ($m) use ($thread){
                    $m->to($thread->user->email)->subject('Administrator has parked your discussion');
                });
        }
        flash()->success('Discussion parked');
        return back();
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unpark($id)
    {
        $thread = Thread::findOrFail($id);
        $thread->status = 'active';
        $thread->created_at = now();
        $thread->save();
        flash()->success('Discussion removed from park');
        return back();
    }

    private function getFilesSaver(): SaveFilesFromRequestService
    {
        return $this->filesSaver;
    }
}
