<?php

namespace App\Http\Controllers\Cms\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Models\Company;
use App\Models\City;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OpportunityController extends Controller
{
    public function index()
    {
        $opportunities = Opportunity::with(['company', 'city', 'specializations'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('cms.admin.opportunity.index', compact('opportunities'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $specializations = Specialization::orderBy('name')->get();

        return view('cms.admin.opportunity.create', compact('companies', 'cities', 'specializations'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'type' => 'required|in:حضوري,عن بعد,هجين',
            'required_hours' => 'required|integer',
            'seats' => 'required|integer',
            'deadline' => 'required|date',
            'status' => 'required|in:مفتوحة,مغلقة,مسودة',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'cities_id' => 'required|exists:cities,id',
            'companies_id' => 'required|exists:companies,id',
            'specializations' => 'nullable|array',
            'specializations.*' => 'exists:specializations,id',
        ]);

         if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

        $opportunity = new Opportunity();
        $opportunity->title = $request->title;
        $opportunity->description = $request->description;
        $opportunity->type = $request->type;
        $opportunity->required_hours = $request->required_hours;
        $opportunity->seats = $request->seats;
        $opportunity->filled_seats = $request->filled_seats ?? 0;
        $opportunity->deadline = $request->deadline;
        $opportunity->status = $request->status;
        $opportunity->requirements = $request->requirements;
        $opportunity->benefits = $request->benefits;
        $opportunity->cities_id = $request->cities_id;
        $opportunity->companies_id = $request->companies_id;
        $isSaved = $opportunity->save();

        if ($isSaved && $request->specializations) {
            $opportunity->specializations()->sync($request->specializations);
        }

        return response()->json([
            'icon' => $isSaved ? 'success' : 'error',
            'title' => $isSaved ? 'Opportunity created successfully' : 'Create failed',
        ], $isSaved ? 200 : 400);
    }

    public function show($id)
    {
        $opportunity = Opportunity::with(['company', 'city', 'specializations'])->findOrFail($id);
        return view('cms.admin.opportunity.show', compact('opportunity'));
    }

    public function edit($id)
    {
        $opportunity = Opportunity::with('specializations')->findOrFail($id);
        $companies = Company::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $specializations = Specialization::orderBy('name')->get();

        return view('cms.admin.opportunity.edit', compact('opportunity', 'companies', 'cities', 'specializations'));
    }

    public function update(Request $request, $id)
    {
        $opportunity = Opportunity::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'type' => 'required|in:حضوري,عن بعد,هجين',
            'required_hours' => 'required|integer',
            'seats' => 'required|integer',
            'deadline' => 'required|date',
            'status' => 'required|in:مفتوحة,مغلقة,مسودة',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'cities_id' => 'required|exists:cities,id',
            'companies_id' => 'required|exists:companies,id',
            'specializations' => 'nullable|array',
            'specializations.*' => 'exists:specializations,id',
        ]);

         if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

        $opportunity->title = $request->title;
        $opportunity->description = $request->description;
        $opportunity->type = $request->type;
        $opportunity->required_hours = $request->required_hours;
        $opportunity->seats = $request->seats;
        $opportunity->filled_seats = $request->filled_seats ?? $opportunity->filled_seats;
        $opportunity->deadline = $request->deadline;
        $opportunity->status = $request->status;
        $opportunity->requirements = $request->requirements;
        $opportunity->benefits = $request->benefits;
        $opportunity->cities_id = $request->cities_id;
        $opportunity->companies_id = $request->companies_id;
        $isUpdated = $opportunity->save();

        if ($request->specializations) {
            $opportunity->specializations()->sync($request->specializations);
        } else {
            $opportunity->specializations()->sync([]);
        }

        return response()->json([
            'icon' => $isUpdated ? 'success' : 'error',
            'title' => $isUpdated ? 'Opportunity updated successfully' : 'Update failed',
        ], $isUpdated ? 200 : 400);
    }

    public function destroy($id)
    {
        $opportunity = Opportunity::findOrFail($id);
        $isDeleted = $opportunity->delete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }

    public function trashed()
    {
        $opportunities = Opportunity::onlyTrashed()
            ->with(['company', 'city', 'specializations'])
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('cms.admin.opportunity.trashed', compact('opportunities'));
    }

    public function restore($id)
    {
        $isRestored = Opportunity::onlyTrashed()->findOrFail($id)->restore();

        return response()->json([
            'icon' => $isRestored ? 'success' : 'error',
            'title' => $isRestored ? 'Restored successfully' : 'Restore failed',
        ], $isRestored ? 200 : 400);
    }

    public function force($id)
    {
        $opportunity = Opportunity::onlyTrashed()->findOrFail($id);
        $isDeleted = $opportunity->forceDelete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted permanently successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }

    public function forceAll()
    {
        $count = Opportunity::onlyTrashed()->count();

        if ($count == 0) {
            return response()->json([
                'icon' => 'info',
                'title' => 'No trashed opportunities found',
            ], 200);
        }

        Opportunity::onlyTrashed()->forceDelete();

        return response()->json([
            'icon' => 'success',
            'title' => 'All trashed opportunities deleted permanently',
        ], 200);
    }
}
