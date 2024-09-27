<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganisationRequest;
use App\Models\Organisation;
use App\Services\FileService;
use App\Services\SeoService;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    /**
     * OrganisationController constructor.
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
        $organisations = Organisation::withCount(['users' => function ($q) {
            $q->active();
        }])
            ->when($request->get('status'), function ($q) use ($request) {
            return $q->where('status', $request->get('status'));
        })->when($request->get('search'), function ($q) use ($request){
                return $q->where('name', 'LIKE', '%' . $request->get('search') . '%');
            })->sortable(['id' => 'desc'])->paginate(m_per_page());
        return view('dashboard.organisations.index', compact('organisations'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.organisations.create');
    }


    /**
     * @param OrganisationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(OrganisationRequest $request)
    {
        $data = $request->all();
        $data['status'] = 'active';
        $organisation = Organisation::create($data);
        if($request->file('logo')){
            $service = new FileService();
            $service->saveImage($request->file('logo'), $organisation, 'organisations', 'logo');
        }
        flash()->success('Organisation added');
        return redirect()->route('dashboard.organisations.index');
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $organisation = Organisation::findOrFail($id);
        return view('dashboard.organisations.edit', compact('organisation'));
    }


    /**
     * @param $id
     * @param OrganisationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, OrganisationRequest $request)
    {
        $organisation = Organisation::findOrFail($id);
        $organisation->update($request->all());
        if($request->file('logo')){
            $service = new FileService();
            $service->saveImage($request->file('logo'), $organisation, 'organisations', 'logo');
        }
        flash()->success('Organisation updated');
        return redirect()->route('dashboard.organisations.index');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $organisation = Organisation::findOrFail($id);
        $organisation->status = 'deleted';
        $organisation->save();
        flash()->success('Organisation deleted');
        return back();
    }
}
