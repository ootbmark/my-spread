<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Thread;
use App\Services\SeoService;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        SeoService::setPageMeta('groups');
        $groups = Group::withCount('threads', 'replies', 'groups')->with('last_thread', 'groups')
            ->whereNull('parent_id')
            ->when($request->get('search'), function ($query) use ($request){
            return $query->where('name', 'LIKE', '%' . $request->get('search') . '%');
            })->active()
            ->sortable()
            ->paginate(m_per_page());
        $general_group_id = Group::GENERAL_ID;

        return view('groups.index', compact('groups', 'general_group_id'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return Group::where('name', 'LIKE', '%' . $request->get('q') . '%')
            ->get(['name AS text', 'id AS id'])->toArray();
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function discussions($id, Request $request)
    {
        SeoService::setPageMeta('discussions');
        $group = Group::findOrFail($id);
        $threads = Thread::where('group_id', $group->id)->withCount('replies')
            ->with('group', 'user', 'replies')
            ->when($request->get('search'), function ($query) use ($request){
                return $query->where('subject', 'LIKE', '%' . $request->get('search') . '%');
            })->active()
            ->sortable(['id' => 'desc'])
            ->paginate(m_per_page());
        return view('groups.discussions', compact('group', 'threads'));
    }
}
