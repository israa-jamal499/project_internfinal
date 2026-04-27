<?php

namespace App\Http\Controllers\Cms\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with(['user', 'city'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('cms.admin.company.index', compact('companies'));
    }

    public function create()
    {
        $cities = City::orderBy('name')->get();
        return view('cms.admin.company.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|max:20',
            'phone' => 'nullable|string|max:45',
            'website' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected,inactive',
            'address' => 'nullable|string|max:255',
            'field_name' => 'nullable|string|max:100',
            'city_id' => 'required|exists:cities,id',
        ]);

         if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'company';
        $user->status = 'active';
        $isUserSaved = $user->save();

        if (!$isUserSaved) {
            return response()->json([
                'icon' => 'error',
                'title' => 'Failed to create user',
            ], 400);
        }

        $company = new Company();
        $company->user_id = $user->id;
        $company->city_id = $request->city_id;
        $company->name = $request->name;
        $company->website = $request->website;
        $company->description = $request->description;
        $company->status = $request->status;
        $company->address = $request->address;
        $company->field_name = $request->field_name;
        $company->phone = $request->phone;
        $isSaved = $company->save();

        return response()->json([
            'icon' => $isSaved ? 'success' : 'error',
            'title' => $isSaved ? 'Company created successfully' : 'Create failed',
        ], $isSaved ? 200 : 400);
    }

    public function show($id)
    {
        $company = Company::with(['user', 'city'])->findOrFail($id);
        return view('cms.admin.company.show', compact('company'));
    }

    public function edit($id)
    {
        $company = Company::with('user')->findOrFail($id);
        $cities = City::orderBy('name')->get();

        return view('cms.admin.company.edit', compact('company', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::with('user')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:150',
            'email' => 'required|email|unique:users,email,' . $company->user_id,
            'phone' => 'nullable|string|max:45',
            'website' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected,inactive',
            'address' => 'nullable|string|max:255',
            'field_name' => 'nullable|string|max:100',
            'city_id' => 'required|exists:cities,id',
        ]);

         if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

        $company->user->email = $request->email;
        $company->user->save();

        $company->city_id = $request->city_id;
        $company->name = $request->name;
        $company->website = $request->website;
        $company->description = $request->description;
        $company->status = $request->status;
        $company->address = $request->address;
        $company->field_name = $request->field_name;
        $company->phone = $request->phone;

        $isUpdated = $company->save();

        return response()->json([
            'icon' => $isUpdated ? 'success' : 'error',
            'title' => $isUpdated ? 'Company updated successfully' : 'Update failed',
        ], $isUpdated ? 200 : 400);
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $isDeleted = $company->delete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }

    public function trashed()
    {
        $companies = Company::onlyTrashed()
            ->with(['user', 'city'])
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('cms.admin.company.trashed', compact('companies'));
    }

    public function restore($id)
    {
        $isRestored = Company::onlyTrashed()->findOrFail($id)->restore();

        return response()->json([
            'icon' => $isRestored ? 'success' : 'error',
            'title' => $isRestored ? 'Restored successfully' : 'Restore failed',
        ], $isRestored ? 200 : 400);
    }

    public function force($id)
    {
        $company = Company::onlyTrashed()->findOrFail($id);
        $isDeleted = $company->forceDelete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted permanently successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }

    public function forceAll()
    {
        $count = Company::onlyTrashed()->count();

        if ($count == 0) {
            return response()->json([
                'icon' => 'info',
                'title' => 'No trashed companies found',
            ], 200);
        }

        Company::onlyTrashed()->forceDelete();

        return response()->json([
            'icon' => 'success',
            'title' => 'All trashed companies deleted permanently',
        ], 200);
    }
}
