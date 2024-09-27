<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Http\Requests\ShareRequest;
use App\Http\Requests\ThreadRequest;
use App\Keyword;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\File;
use App\Models\Group;
use App\Models\Organisation;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\Services\FileService;
use App\Services\SaveFiles\SaveFilesFromRequestService;
use App\Services\SeoService;
use App\Services\ShareService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DiscussionController extends Controller
{

    /** @var SaveFilesFromRequestService */
    private $filesSaver;

    public function __construct(SaveFilesFromRequestService $filesSaver)
    {
        $this->filesSaver = $filesSaver;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if ($request->get('sort') === 'replies_count') {
            $request->merge(['sort' => 'active_replies_count']);
        }

        SeoService::setPageMeta('discussions');
        $threads = Thread::withCount('active_replies')
            ->with('group', 'user', 'replies')
            ->when($request->get('search'), function ($query) use ($request) {
                if (count(explode(' and ', $request->get('search'))) > 1 || count(explode(' AND ', $request->get('search'))) > 1) {
                    $array = explode(' and ', $request->get('search'));
                    $array_second = explode(' AND ', $request->get('search'));
                    $result = [];
                    if (count($array) > 1 && count($array_second) > 1) {
                        $result = array_merge($array, $array_second);
                    } else {
                        if (count($array) > 1) {
                            $result = $array;
                        }
                        if (count($array_second) > 1) {
                            $result = $array_second;
                        }
                    }
                    return $query->where(function ($q) use ($request, $result) {
                        foreach ($result as $item) {
                            $q->where('subject', 'LIKE', '%' . $item . '%');
                        }
                        return $q;
                    });
                } elseif (count(explode(' or ', $request->get('search'))) > 1 || count(explode(' OR ', $request->get('search'))) > 1) {
                    $array = explode(' or ', $request->get('search'));
                    $array_second = explode(' OR ', $request->get('search'));
                    $result = [];
                    if (count($array) > 1 && count($array_second) > 1) {
                        $result = array_merge($array, $array_second);
                    } else {
                        if (count($array) > 1) {
                            $result = $array;
                        }
                        if (count($array_second) > 1) {
                            $result = $array_second;
                        }
                    }
                    return $query->where(function ($q) use ($request, $result) {
                        foreach ($result as $item) {
                            $q->orWhere('subject', 'LIKE', '%' . $item . '%');
                        }
                        return $q;
                    });
                }
                return $query->where('subject', 'LIKE', '%' . $request->get('search') . '%');
            })->active()
            ->when($request->get('unanswered'), function ($q) {
                return $q->doesnthave('active_replies');
            })
            ->sortable(['id' => 'desc'])
            ->paginate(m_per_page());

        return view('discussions.index', compact('threads'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $thread = Thread::findOrFail($id);
        SeoService::setPageMeta('discussion', $thread);
        $users = User::active()->get();
        $categories = Category::all();
        $replies = $thread->replies()->with(['replies' => function ($q) {
            return $q->active();
        }, 'user', 'replies.user'])
            ->whereNull('parent_id')->active()
            ->orderby('id', 'desc')->get();
        $related_threads = Thread::where('id', '!=', $id)
            ->active()->where('group_id', $thread->group_id)
            ->take(5)->get();
        $reply = Reply::find(\request()->get('reply_id'));
        return view('discussions.show', compact(
            'thread',
            'users',
            'categories',
            'replies',
            'related_threads',
            'reply'
        ));
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return Thread::when($request->get('q'), function ($query) use ($request) {
            if (count(explode(' and ', $request->get('q'))) > 1 || count(explode(' AND ', $request->get('q'))) > 1) {
                $array = explode(' and ', $request->get('q'));
                $array_second = explode(' AND ', $request->get('q'));
                $result = [];
                if (count($array) > 1 && count($array_second) > 1) {
                    $result = array_merge($array, $array_second);
                } else {
                    if (count($array) > 1) {
                        $result = $array;
                    }
                    if (count($array_second) > 1) {
                        $result = $array_second;
                    }
                }
                return $query->where(function ($q) use ($request, $result) {
                    foreach ($result as $item) {
                        $q->where('subject', 'LIKE', '%' . $item . '%');
                    }
                    return $q;
                });
            } elseif (count(explode(' or ', $request->get('q'))) > 1 || count(explode(' OR ', $request->get('q'))) > 1) {
                $array = explode(' or ', $request->get('q'));
                $array_second = explode(' OR ', $request->get('q'));
                $result = [];
                if (count($array) > 1 && count($array_second) > 1) {
                    $result = array_merge($array, $array_second);
                } else {
                    if (count($array) > 1) {
                        $result = $array;
                    }
                    if (count($array_second) > 1) {
                        $result = $array_second;
                    }
                }
                return $query->where(function ($q) use ($request, $result) {
                    foreach ($result as $item) {
                        $q->orWhere('subject', 'LIKE', '%' . $item . '%');
                    }
                    return $q;
                });
            }
            return $query->where('subject', 'LIKE', '%' . $request->get('q') . '%');
        })->get(['subject AS text', 'id AS id'])->toArray();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function check(Request $request)
    {
        SeoService::setPageMeta('create_discussion');
        $threads = [];
        if ($request->get('search')) {
            $threads = Thread::withCount('replies')->with('group', 'user')
                ->where('subject', 'LIKE', '%' . $request->get('search') . '%')
                ->active()
                ->sortable(['id' => 'desc'])
                ->paginate(m_per_page());
            session()->put('discussion_subject', $request->get('search'));
        }

        return view('discussions.check', compact('threads'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        if (\auth()->user()->status == 'new' && \auth()->user()->threads()->count() > 0) {
            flash()->warning("You've already posted your discussion..
            Please wait until your account is verified to add new discussions");
            return redirect()->route('discussions.index');
        }
        SeoService::setPageMeta('create_discussion');
        $groups = Group::active()->get();
        $users = User::active()->get();
        $thread = Thread::find(\request()->get('thread_id'));
        $subject = session()->get('discussion_subject');
        session()->forget('discussion_subject');
        return view('discussions.create', compact('groups', 'users', 'thread', 'subject'));
    }


    /**
     * @param ThreadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ThreadRequest $request)
    {
        $data = $request->all();
        if (Auth::user()->role != 'admin') {
            $data['user_id'] = Auth::id();
        }

        $data['status'] = 'new';
        if ($request->get('submit') == 'preview') {
            $data['status'] = 'preview';
        }
        $data['activity_date'] = now();
        $data['body'] = m_nofollow($data['body']);
        $thread = Thread::create($data);
        $this->getFilesSaver()->save($request, $thread);
        if ($thread->status == 'preview') {
            return redirect()->route('discussions.preview', $thread->id);
        }

        $share_service = new ShareService();
        $share_service->linkedin($thread);

        $subject = 'A new discussion has been posted on My-Spread';
        Mail::send('emails.new_thread', ['thread' => $thread], function ($m) use ($subject) {
            $m->to(config('mail.notifications'))->subject($subject);
        });
        flash()->success('Thanks. You have added a new discussion to My-Spread');
        return redirect()->route('discussions.show', $thread->id);
    }


    /**
     * @param $id
     * @param ReplyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reply($id, ReplyRequest $request)
    {
        $thread = Thread::findOrFail($id);
        $data = $request->all();
        $data['thread_id'] = $id;
        $data['group_id'] = $thread->group_id;
        if (Auth::user()->role != 'admin') {
            $data['user_id'] = Auth::id();
        }

        $data['status'] = 'new';
        if ($request->get('submit') == 'preview') {
            $data['status'] = 'preview';
        }
        $data['body'] = m_nofollow($data['body']);
        $reply = Reply::create($data);
        $this->getFilesSaver()->save($request, $reply);
        if ($reply->status == 'preview') {
            return redirect()->route('reply.preview', $reply->id);
        }
        $activity_date = now();
        $thread->activity_date = $activity_date;
        $thread->save();

        $subject = 'New response in forum from an ' . ucfirst($reply->user->status) . ' User';
        Mail::send('emails.new_reply', ['reply' => $reply], function ($m) use ($subject) {
            $m->to(config('mail.notifications'))->subject($subject);
        });
        flash()->success('Thanks. You have added a new response to My-Spread');
        return redirect()->route('discussions.show', $thread->id);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function preview($id)
    {
        $thread = Thread::where('status', 'preview')->whereNull('source_id')->findOrFail($id);
        $isEdit = false;
        SeoService::setPageMeta('discussion', $thread);
        return view('discussions.preview', compact('thread', 'isEdit'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editPreview($id)
    {
        $thread = Thread::where('status', 'preview')->whereNotNull('source_id')->findOrFail($id);
        $isEdit = true;
        SeoService::setPageMeta('discussion', $thread);
        return view('discussions.preview', compact('thread', 'isEdit'));
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function previewSave($id)
    {
        $thread = Thread::where('status', 'preview')->whereNull('source_id')->findOrFail($id);
        $status = 'new';

        $thread->status = $status;
        $thread->save();
        $subject = 'A new discussion has been posted on My-Spread';
        Mail::send('emails.new_thread', ['thread' => $thread], function ($m) use ($subject) {
            $m->to(config('mail.notifications'))->subject($subject);
        });
        flash()->success('Thanks. You have added a new discussion to My-Spread');
        return redirect()->route('discussions.show', $thread->id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editPreviewUpdate($id)
    {
        $previewThread = Thread::where('status', 'preview')->whereNotNull('source_id')->findOrFail($id);
        $sourceThread = $previewThread->source;
        $sourceThread->update([
            'subject' => $previewThread->subject,
            'body' => $previewThread->body,
            'location' => $previewThread->location,
            'group_id' => $previewThread->group_id,
            'user_id' => $previewThread->user_id,
        ]);

        if ($previewThread->files->isNotEmpty()) {
            $sourceThread->files()->delete();
            foreach ($previewThread->files as $file) {
                $file->resource_id = $sourceThread->id;
                $file->save();
            }
        }

        $previewThread->delete();

        flash()->success('Discussions updated');

        return redirect()->route('discussions.show', $sourceThread->id);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function replyPreview($id)
    {
        $reply = Reply::where('status', 'preview')->whereNull('source_id')->findOrFail($id);
        $isEdit = false;
        SeoService::setPageMeta('discussion', $reply->thread);
        return view('discussions.preview_reply', compact('reply', 'isEdit'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editReplyPreview($id)
    {
        $reply = Reply::where('status', 'preview')->whereNotNull('source_id')->findOrFail($id);
        $isEdit = true;
        SeoService::setPageMeta('discussion', $reply->thread);
        return view('discussions.preview_reply', compact('reply', 'isEdit'));
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function replyPreviewSave($id)
    {
        $reply = Reply::where('status', 'preview')->whereNull('source_id')->findOrFail($id);
        $status = 'new';

        $reply->status = $status;
        $reply->save();
        $thread = $reply->thread;
        $activity_date = now();
        $thread->activity_date = $activity_date;
        $thread->save();
        $subject = 'New response in forum from an ' . ucfirst($reply->user->status) . ' User';
        Mail::send('emails.new_reply', ['reply' => $reply], function ($m) use ($subject) {
            $m->to(config('mail.notifications'))->subject($subject);
        });
        flash()->success('Thanks. You have added a new response to My-Spread');
        return redirect()->route('discussions.show', $thread->id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editReplyPreviewUpdate($id)
    {
        $previewReply = Reply::where('status', 'preview')->whereNotNull('source_id')->findOrFail($id);
        $sourceReply = $previewReply->source;
        $sourceReply->update([
            'body' => $previewReply->body,
            'location' => $previewReply->location,
            'category_id' => $previewReply->category_id,
            'user_id' => $previewReply->user_id,
        ]);

        if ($previewReply->files->isNotEmpty()) {
            $sourceReply->files()->delete();
            foreach ($previewReply->files as $file) {
                $file->resource_id = $sourceReply->id;
                $file->save();
            }
        }

        $previewReply->delete();

        flash()->success('Reply updated');

        return redirect()->route('discussions.show', $sourceReply->thread->id);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function favorite($id)
    {
        $user = \auth()->user();

        if ($user->favorites->contains($id)) {
            $user->favorites()->detach($id);
        } else {
            $user->favorites()->attach($id);
        }
        return back();
    }


    /**
     * @param $id
     * @param ShareRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function share($id, ShareRequest $request)
    {
        $threadQuery = Thread::query();
        if ($request->has('send_responses')) {
            $threadQuery->with(['active_replies' => function ($q) {
                $q->with('user');
                $q->orderBy('created_at', 'desc');
                $q->take(5);
            }]);
        }
        $thread = $threadQuery->findOrFail($id);

        $friendEmails = preg_replace('/[ ]/', '', $request->get('emails'));
        $friends = explode(';',  $friendEmails);
        foreach ($friends as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $user = \Illuminate\Foundation\Auth\User::where('email', $email)->first();
                if ($user) {
                    $friendName = $user->username;
                } else {
                    $friendName = '';
                }
                Mail::send(
                    'emails.share',
                    ['data' => $request->all(), 'thread' => $thread, 'friendName' => $friendName],
                    function ($m) use ($email) {
                        $m->to($email)->subject('My-Spread Discussion');
                    }
                );
            }
        }

        return response()->json(['success']);
    }

    private function getFilesSaver(): SaveFilesFromRequestService
    {
        return $this->filesSaver;
    }
}
