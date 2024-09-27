<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        SeoService::setPageMeta('user', $user);
        $replies = Reply::with('thread')->where('user_id', $id)->active()->groupBy('thread_id')->get();
        $threads = Thread::where('user_id', $id)->active()->get();
        return view('users.show', compact('user', 'replies', 'threads'));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getData(Request $request): array
    {
        return User::where(DB::raw('concat(first_name," ",last_name)'), 'like', '%'. $request->get('q') .'%')
            ->select(DB::raw('concat(first_name," ",last_name) AS text, id'))->get()->toArray();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getDataPaginated(Request $request)
    {
        $page = $request->get('page');
        $resultCount = 25;

        $offset = ($page - 1) * $resultCount;

        $users = User::query()
            ->where(DB::raw('CONCAT(first_name," ",last_name)'), 'like', '%' . $request->get('term') . '%')
            ->select(DB::raw('CONCAT(first_name," ",last_name) AS text, id, first_name, last_name'))
            ->skip($offset)
            ->take($resultCount)
            ->get(['id', 'text']);

        $count = User::where(DB::raw('concat(first_name," ",last_name)'), 'like', '%' . $request->get('term') . '%')->count();
        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;

        $results = [
            "results" => $users,
            "pagination" => [
                "more" => $morePages,
            ]
        ];

        return response()->json($results);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getDataByIds(Request $request)
    {
        $users = $request->get('user_ids');

        $users = User::query()
            ->findMany($users, ['id', 'first_name', 'last_name']);

        return response()->json($users);
    }
}
