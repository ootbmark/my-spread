<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganisationRequest;
use App\Http\Requests\ReplyRequest;
use App\Models\Category;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\Services\SaveFiles\SaveFilesFromRequestService;
use App\Services\SeoService;
use Illuminate\Http\Request;

class ReplyController extends Controller
{

    /** @var SaveFilesFromRequestService */
    private $filesSaver;

    /**
     * ReplyController constructor.
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
        $replies = Reply::with('thread')
            ->when($request->get('status'), function ($q) use ($request) {
                return $q->where('status', $request->get('status'));
            })->when($request->get('search'), function ($q) use ($request){
                return $q->where('body', 'LIKE', '%' . $request->get('search') . '%');
            })->where('status', '!=', 'preview')
            ->sortable(['id' => 'desc'])->paginate(m_per_page());
        return view('dashboard.replies.index', compact('replies'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $reply = Reply::findOrFail($id);
        $users = User::all();
        $categories = Category::all();
        return view('dashboard.replies.edit', compact('reply', 'users', 'categories'));
    }


    /**
     * @param $id
     * @param ReplyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, ReplyRequest $request)
    {
        $reply = Reply::findOrFail($id);
        if($request->get('submit') == 'preview')
        {
            $preview = $reply->replicate();
            $preview->push();
            $preview->update($request->all());
            $preview->status = 'preview';
            $preview->source_id = $reply->id;
            $preview->save();

            $this->getFilesSaver()->save($request, $preview);

            return redirect()->route('reply.edit.preview', $preview->id);
        }
        $data = $request->all();
        if($reply->status == 'parked' && $data['status'] == 'active')
        {
            $data['created_at'] = now();
        }
        $reply->update($data);

        $this->getFilesSaver()->save($request, $reply);

        flash()->success('Reply updated');
        return back();
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function park($id)
    {
        $reply = Reply::findOrFail($id);
        $reply->status = 'parked';
        $reply->save();
        flash()->success('Reply parked');
        return back();
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unpark($id)
    {
        $reply = Reply::findOrFail($id);
        $reply->status = 'active';
        $reply->created_at = now();
        $reply->save();
        flash()->success('Reply removed from park');
        return back();
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $reply = Reply::findOrFail($id);
        $reply->status = 'deleted';
        $reply->save();
        flash()->success('Reply deleted');
        return back();
    }

    private function getFilesSaver(): SaveFilesFromRequestService
    {
        return $this->filesSaver;
    }
}
