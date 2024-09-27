<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Organisation;
use App\Models\University;
use App\Services\SeoService;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        SeoService::setPageMeta('organisations');
        $organisations = Organisation::withCount('users')
            ->when($request->get('search'), function ($query) use ($request){
            return $query->where('name', 'LIKE', '%' . $request->get('search') . '%');
        })->active()->sortable(['id' => 'asc'])->paginate(m_per_page());
        return view('organisations.index', compact('organisations'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return Organisation::where('name', 'LIKE', '%' . $request->get('q') . '%')
            ->get(['name AS text', 'id AS id'])->toArray();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getUniversitiesData(Request $request)
    {
        return University::where('name', 'LIKE', '%' . $request->get('q') . '%')
            ->get(['name AS text', 'id AS id'])->toArray();
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $organisation = Organisation::findOrFail($id);
        SeoService::setPageMeta('organisation', $organisation);
        return view('organisations.show', compact('organisation'));
    }
}
