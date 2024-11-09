<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
     /**
     * List all employees
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employees = Employee::with('company')->get();
            return DataTables::of($employees)
                ->addColumn('company', function ($employee) {
                    return $employee->company->name ?? '';
                })
                ->addColumn('action', function ($employee) {
                    return '<a href="/employees/' . $employee->id . '" class="action-button">View</a>
                            <button class="delete-btn" data-id="' . $employee->id . '">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('employees.index');
    }

     /**
     * create employee view page
     *
     * 
     *
     * @return Response
     */
    public function create()
    {
        $companies = Company::get();
          
        return view('employees.create',compact('companies'));
    }

    /** 
     * Store a new employee.
     *
     * @param  EmployeeRequest  $request
     * 
     */
    public function store(EmployeeRequest $request)
    {
        $input = $request->validated();
        Employee::create(['first_name' => $input['first_name'],
                        'last_name'  => $input['last_name'],
                        'company_id' => $input['company'],
                        'email'      => $input['email'],
                        'phone'      => $input['phone'],
                    ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully');
    }

     /**
     * Display the specified employee
     *
     * @param  int  $id
     *
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        $companies = Company::all(); 

        return view('employees.show', compact('employee','companies'));
    }

   /**
     * update the specified employee
     *
     * @param  int  $id
     * 
     */
    public function update(EmployeeRequest $request, $id)
    {
        $input = $request->validated();
        $employee = Employee::findOrFail($id);
        $employee->update(['first_name' => $input['first_name'],
                        'last_name'  => $input['last_name'],
                        'company_id' => $input['company'],
                        'email'      => $input['email'],
                        'phone'      => $input['phone'],
                    ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully');
    }

    /**
     * Delete employee
     *
     * @param  int Id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');
    }
}
