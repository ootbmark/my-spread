<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UniversityRequest;
use App\Models\University;
use App\Services\FileService;
use App\Services\SeoService;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    /**
     * UniversityController constructor.
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
        $universities = University::withCount('users')
            ->when($request->get('status'), function ($q) use ($request) {
                return $q->where('status', $request->get('status'));
            })->when($request->get('search'), function ($q) use ($request) {
                return $q->where('name', 'LIKE', '%' . $request->get('search') . '%');
            })->sortable(['id' => 'desc'])->paginate(m_per_page());
        return view('dashboard.universities.index', compact('universities'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.universities.create');
    }


    /**
     * @param UniversityRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UniversityRequest $request)
    {
        $data = $request->all();
        $data['status'] = University::ACTIVE;
        University::create($data);
        flash()->success('University added');
        return redirect()->route('dashboard.universities.index');
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $university = University::findOrFail($id);
        return view('dashboard.universities.edit', compact('university'));
    }


    /**
     * @param $id
     * @param UniversityRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, UniversityRequest $request)
    {
        $university = University::findOrFail($id);
        $university->update($request->all());
        flash()->success('University updated');
        return redirect()->route('dashboard.universities.index');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $university = University::findOrFail($id);
        $university->status = University::DELETED;
        $university->save();
        flash()->success('University deleted');
        return back();
    }
}
