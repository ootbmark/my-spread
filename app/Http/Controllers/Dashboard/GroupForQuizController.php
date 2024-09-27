<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupForQuiz\CreateGroupRequest;
use App\Http\Requests\GroupForQuiz\UpdateGroupRequest;
use App\Models\GroupForQuiz;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class GroupForQuizController extends Controller
{
    public function index()
    {
        $groups = GroupForQuiz::paginate(20);

        return view('dashboard.group_for_quiz.index', [
            'groups' => $groups,
        ]);
    }


    /**
     * @return array
     */
    public function dataTable()
    {
        return Laratables::recordsOf(GroupForQuiz::class, function ($query) {
            return $query->select('*');
        });
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.group_for_quiz.create');
    }


    /**
     * @param CreateGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateGroupRequest $request)
    {
        $data = $request->only([
            'name'
        ]);

        GroupForQuiz::create($data);

        flash()->success(__('Group created!'));

        return redirect()->route('groups-for-quiz.index');
    }


    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $group = GroupForQuiz::find($id);

        return view('dashboard.group_for_quiz.edit', [
            'group' => $group,
        ]);
    }


    /**
     * @param UpdateGroupRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateGroupRequest $request, int $id)
    {
        $data = $request->only([
            'name',
        ]);

        $group = GroupForQuiz::find($id);

        $group->update($data);


        flash()->success(__('Group updated!'));

        return redirect()->route('groups-for-quiz.index');
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $group = GroupForQuiz::find($id);

        $group->destroy($id);

        flash()->success(__('Group deleted!'));

        return redirect()->route('groups-for-quiz.index');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addNewGroup(Request $request)
    {
        $data = $request->only([
            'name',
            'lesson_id'
        ]);

        GroupForQuiz::create($data);

        return response()->json([
            'success' => true
        ]);
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function retrieveAll()
    {
        return GroupForQuiz::all()->pluck('name', 'id');
    }



}
