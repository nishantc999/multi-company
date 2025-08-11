<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\UserActiveCompany;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($request->user()->companies);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'address'  => 'required|string',
            'industry' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $company = $request->user()->companies()->create($validator->validated());

        if (!UserActiveCompany::where('user_id', $request->user()->id)->exists()) {
            UserActiveCompany::create([
                'user_id'   => $request->user()->id,
                'company_id'=> $company->id
            ]);
        }

        return response()->json($company, 201);
    }

    public function update(Request $request, Company $company)
    {
        if ($company->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'address'  => 'required|string',
            'industry' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $company->update($validator->validated());

        return response()->json($company);
    }

    public function destroy(Request $request, Company $company)
    {
        if ($company->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $company->delete();

        UserActiveCompany::where('user_id', $request->user()->id)
            ->where('company_id', $company->id)
            ->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function switchActive(Request $request, Company $company)
    {
        if ($company->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        UserActiveCompany::updateOrCreate(
            ['user_id' => $request->user()->id],
            ['company_id' => $company->id]
        );

        return response()->json(['message' => 'Active company updated']);
    }

    // Blade index
    public function webIndex(Request $request)
    {
        $companies     = $request->user()->companies;
        $activeCompany = $request->user()->activeCompany();
        return view('companies.index', compact('companies', 'activeCompany'));
    }

    public function webStore(Request $request)
    {
        $this->store($request);
        return redirect()->route('companies.index')->with('status', 'Company created');
    }

    public function webSwitch(Request $request, Company $company)
    {
        $this->switchActive($request, $company);
        return redirect()->route('companies.index')->with('status', 'Active company switched');
    }
}
