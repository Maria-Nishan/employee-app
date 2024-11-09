<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * List all companies
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $companies = Company::get();
            return DataTables::of($companies)
                ->addColumn('action', function($company) {
                    return '<a href="/companies/' . $company->id . '">View</a>';
                })
                ->rawColumns(['action']) 
                ->make(true);
        }

        return view('companies.index');
    }

    /**
     * create company page view
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function create()
    {
        return view('companies.create');
    }

    /** 
     * Store a new company.
     *
     * @param  CompanyRequest  $request
     * @return Response
     */
    public function store(CompanyRequest $request)
    {
        $input = $request->validated();
        if ($request->hasFile('logo')) {
            $input['logo'] = $request->file('logo')->store('company_logos', 'public');
        }
        
        Company::create($input);

        return redirect()->route('companies.index')->with('success', 'Company created successfully');
    }

    /**
     * Display the specified company
     *
     * @param  int  $id
     * 
     */
    public function show($id)
    {
        $company = Company::findOrFail($id);

        return view('companies.show', compact('company'));
    }

    /**
     * update the specified company
     *
     * @param  int  $id
     * 
     */
    public function update(CompanyRequest $request, $id)
    {
        $input = $request->validated();
        $company = Company::findOrFail($id);

        if ($request->hasFile('logo')) {
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }
    
            $input['logo'] = $request->file('logo')->store('company_logos', 'public');
        }

        $company->update($input);
        
        return redirect()->route('companies.index')->with('success', 'Company updated successfully');
    }

    /**
     * Delete company
     *
     * @param  int Id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully');
    }
}
