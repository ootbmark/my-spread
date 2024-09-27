<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Quiz;
use Freshbitsweb\Laratables\Laratables;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::paginate(20);

        if(request()->ajax()){
            $companies = Company::all();
            return response()->json(['status' => 'success', 'companies' => $companies], 200);
        }

        return view('dashboard.companies.index', [
            'companies' => $companies,
        ]);
    }


    /**
     * @return array
     */
    public function dataTable()
    {
        return Laratables::recordsOf(Company::class, function ($query) {
            return $query->select('*');
        });
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $quizes = Quiz::whereNull('company_id')->pluck('title', 'id')->toArray();
        $selected_quizes = [];
        $selected_users = [];
        return view('dashboard.companies.create', compact('quizes', 'selected_quizes', 'selected_users'));
    }


    /**
     * @param CompanyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CompanyRequest $request)
    {
        $data = $request->only([
            'name'
        ]);

        $company = Company::create($data);

        $quizes  = Quiz::whereIn('id', $request->get('quizes', []))->get();

        $users = $request->get('users', []);
        $company->users()->sync($users);

        foreach ($quizes as $quiz){
            $quiz->update(['company_id' => $company->id]);
        }

        flash()->success(__('Company created!'));

        return redirect()->route('companies.index');
    }


    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $company = Company::find($id);
        $quizes = Quiz::where(function ($q) use ($id) {
            $q->orWhereNull('company_id');
            $q->orWhere('company_id', $id);
        })->pluck('title', 'id')->toArray();
        $selected_quizes = $company->quizes()->pluck('quizes.id')->toArray();
        $selected_users = $company->users()->pluck('id');

        return view('dashboard.companies.edit', compact('quizes', 'company', 'selected_quizes', 'selected_users'));
    }


    /**
     * @param CompanyRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CompanyRequest $request, int $id)
    {
        $data = $request->only([
            'name',
        ]);

        $company = Company::find($id);

        $company->update($data);

        Quiz::where('company_id', $company->id)->update(['company_id' => null]);
        $quizes  = Quiz::whereIn('id', $request->get('quizes', []))->get();

        $users = $request->get('users', []);
        $company->users()->sync($users);

        foreach ($quizes as $quiz){
            $quiz->update(['company_id' => $company->id]);
        }

        flash()->success(__('Company updated!'));

        return redirect()->route('companies.index');
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $company = Company::find($id);

        Quiz::where('company_id', $company->id)->update(['company_id' => null]);
        $company->destroy($id);

        flash()->success(__('Company deleted!'));

        return redirect()->route('companies.index');
    }
}
