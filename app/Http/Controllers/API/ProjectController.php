<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Project;

class ProjectController extends Controller
{
  public function index(Request $request)
{
    $company = $request->user()->activeCompany();
    if (!$company) {
        return response()->json(['message' => 'No active company selected'], 400);
    }
    return response()->json($company->projects);
}

public function store(Request $request)
{
    $company = $request->user()->activeCompany();
    if (!$company) {
        return response()->json(['message' => 'No active company selected'], 400);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $project = $company->projects()->create($validator->validated());
    return response()->json($project, 201);
}

public function update(Request $request, Project $project)
{
    $company = $request->user()->activeCompany();
    if (!$company || $project->company_id !== $company->id) {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $project->update($validator->validated());
    return response()->json($project);
}

public function destroy(Request $request, Project $project)
{
    $company = $request->user()->activeCompany();
    if (!$company || $project->company_id !== $company->id) {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $project->delete();
    return response()->json(['message' => 'Deleted']);
}
}
