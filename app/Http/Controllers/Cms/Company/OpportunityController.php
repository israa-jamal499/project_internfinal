<?php

namespace App\Http\Controllers\Cms\Company;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Models\City;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OpportunityController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;

        $opportunities = Opportunity::with(['city', 'specializations'])
            ->where('companies_id', $company->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('cms.company.opportunities.index', compact('opportunities'));
    }

    public function create()
    {
        $cities = City::orderBy('name')->get();
        $specializations = Specialization::orderBy('name')->get();

        return view('cms.company.opportunities.create', compact('cities', 'specializations'));
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
            'specializations' => 'nullable|array',
            'specializations.*' => 'exists:specializations,id',
        ]);

          if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

        $company = auth::user()->company;

        $opportunity = new Opportunity();
        $opportunity->title = $request->title;
        $opportunity->description = $request->description;
        $opportunity->type = $request->type;
        $opportunity->required_hours = $request->required_hours;
        $opportunity->seats = $request->seats;
        $opportunity->filled_seats = 0;
        $opportunity->deadline = $request->deadline;
        $opportunity->status = $request->status;
        $opportunity->requirements = $request->requirements;
        $opportunity->benefits = $request->benefits;
        $opportunity->cities_id = $request->cities_id;
        $opportunity->companies_id = $company->id;
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
        $company = Auth::user()->company;

        $opportunity = Opportunity::with(['city', 'specializations'])
            ->where('companies_id', $company->id)
            ->findOrFail($id);

        return view('cms.company.opportunities.show', compact('opportunity'));
    }

    public function edit($id)
    {
        $company = Auth::user()->company;

        $opportunity = Opportunity::with('specializations')
            ->where('companies_id', $company->id)
            ->findOrFail($id);

        $cities = City::orderBy('name')->get();
        $specializations = Specialization::orderBy('name')->get();

        return view('cms.company.opportunities.edit', compact('opportunity', 'cities', 'specializations'));
    }

    public function update(Request $request, $id)
    {
        $company = Auth::user()->company;

        $opportunity = Opportunity::where('companies_id', $company->id)->findOrFail($id);

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
        $opportunity->deadline = $request->deadline;
        $opportunity->status = $request->status;
        $opportunity->requirements = $request->requirements;
        $opportunity->benefits = $request->benefits;
        $opportunity->cities_id = $request->cities_id;
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
        $company = Auth::user()->company;

        $opportunity = Opportunity::where('companies_id', $company->id)->findOrFail($id);
        $isDeleted = $opportunity->delete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }

    public function trashed()
    {
        $company = Auth::user()->company;

        $opportunities = Opportunity::onlyTrashed()
            ->with(['city', 'specializations'])
            ->where('companies_id', $company->id)
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('cms.company.opportunities.trashed', compact('opportunities'));
    }

    public function restore($id)
    {
        $company = Auth::user()->company;

        $isRestored = Opportunity::onlyTrashed()
            ->where('companies_id', $company->id)
            ->findOrFail($id)
            ->restore();

        return response()->json([
            'icon' => $isRestored ? 'success' : 'error',
            'title' => $isRestored ? 'Restored successfully' : 'Restore failed',
        ], $isRestored ? 200 : 400);
    }

    public function force($id)
    {
        $company = Auth::user()->company;

        $opportunity = Opportunity::onlyTrashed()
            ->where('companies_id', $company->id)
            ->findOrFail($id);

        $isDeleted = $opportunity->forceDelete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted permanently successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }

    public function forceAll()
    {
        $company = Auth::user()->company;

        $count = Opportunity::onlyTrashed()
            ->where('companies_id', $company->id)
            ->count();

        if ($count == 0) {
            return response()->json([
                'icon' => 'info',
                'title' => 'No trashed opportunities found',
            ], 200);
        }

        Opportunity::onlyTrashed()
            ->where('companies_id', $company->id)
            ->forceDelete();

        return response()->json([
            'icon' => 'success',
            'title' => 'All trashed opportunities deleted permanently',
        ], 200);
    }
}
