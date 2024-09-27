<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Http\Requests\OrganisationRequest;
use App\Models\Group;
use App\Models\Organisation;
use App\Services\SeoService;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * GroupController constructor.
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
        $groups = Group::withCount('threads', 'groups', 'replies')->with('last_thread')
            ->when($request->get('status'), function ($q) use ($request) {
                return $q->where('status', $request->get('status'));
            })->when($request->get('search'), function ($q) use ($request){
                return $q->where('name', 'LIKE', '%' . $request->get('search') . '%');
            })->sortable(['id' => 'desc'])->whereNull('parent_id')->paginate(m_per_page());
        return view('dashboard.groups.index', compact('groups'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $groups = Group::whereNull('parent_id')->get();
        return view('dashboard.groups.create', compact('groups'));
    }


    /**
     * @param GroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GroupRequest $request)
    {
        $data = $request->all();
        Group::create($data);
        flash()->success('Group added');
        return redirect()->route('dashboard.groups.index');
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $group = Group::findOrFail($id);
        $groups = Group::whereNull('parent_id')->get();
        return view('dashboard.groups.edit', compact('group', 'groups'));
    }


    /**
     * @param $id
     * @param GroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, GroupRequest $request)
    {
        $group = Group::findOrFail($id);
        $group->update($request->all());
        flash()->success('Group updated');
        return redirect()->route('dashboard.groups.index');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->status = 'deleted';
        $group->save();
        flash()->success('Group deleted');
        return back();
    }
}
