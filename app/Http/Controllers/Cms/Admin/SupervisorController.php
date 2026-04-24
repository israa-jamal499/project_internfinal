<?php

namespace App\Http\Controllers\Cms\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\College;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SupervisorController extends Controller
{
    public function index()
    {
        $supervisors = Supervisor::with(['user', 'college', 'city'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('cms.admin.supervisors.index', compact('supervisors'));
    }

    public function create()
    {
        $cities = City::orderBy('name')->get();
        $colleges = College::orderBy('name')->get();

        return view('cms.admin.supervisors.create', compact('cities', 'colleges'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|min:3|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|max:20',
            'phone' => 'nullable|string|max:45',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'city_id' => 'nullable|exists:cities,id',
            'college_id' => 'nullable|exists:colleges,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'supervisor';
        $user->status = $request->status;
        $isUserSaved = $user->save();

        if (!$isUserSaved) {
            return response()->json([
                'icon' => 'error',
                'title' => 'Failed to create user',
            ], 400);
        }

        $supervisor = new Supervisor();
        $supervisor->full_name = $request->full_name;
        $supervisor->phone = $request->phone;
        $supervisor->notes = $request->notes;
        $supervisor->status = $request->status;
        $supervisor->user_id = $user->id;
        $supervisor->city_id = $request->city_id;
        $supervisor->college_id = $request->college_id;
        $isSaved = $supervisor->save();

        return response()->json([
            'icon' => $isSaved ? 'success' : 'error',
            'title' => $isSaved ? 'Supervisor created successfully' : 'Create failed',
        ], $isSaved ? 200 : 400);
    }

    public function show($id)
    {
        $supervisor = Supervisor::with(['user', 'college', 'city'])->findOrFail($id);
        return view('cms.admin.supervisors.show', compact('supervisor'));
    }

    public function edit($id)
    {
        $supervisor = Supervisor::with('user')->findOrFail($id);
        $cities = City::orderBy('name')->get();
        $colleges = College::orderBy('name')->get();

        return view('cms.admin.supervisors.edit', compact('supervisor', 'cities', 'colleges'));
    }

    public function update(Request $request, $id)
    {
        $supervisor = Supervisor::with('user')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|min:3|max:150',
            'email' => 'required|email|unique:users,email,' . $supervisor->user_id,
            'phone' => 'nullable|string|max:45',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'city_id' => 'nullable|exists:cities,id',
            'college_id' => 'nullable|exists:colleges,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $supervisor->user->email = $request->email;
        $supervisor->user->status = $request->status;
        $supervisor->user->save();

        $supervisor->full_name = $request->full_name;
        $supervisor->phone = $request->phone;
        $supervisor->notes = $request->notes;
        $supervisor->status = $request->status;
        $supervisor->city_id = $request->city_id;
        $supervisor->college_id = $request->college_id;

        $isUpdated = $supervisor->save();

        return response()->json([
            'icon' => $isUpdated ? 'success' : 'error',
            'title' => $isUpdated ? 'Supervisor updated successfully' : 'Update failed',
        ], $isUpdated ? 200 : 400);
    }

    public function destroy($id)
    {
        $supervisor = Supervisor::findOrFail($id);
        $isDeleted = $supervisor->delete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }


}