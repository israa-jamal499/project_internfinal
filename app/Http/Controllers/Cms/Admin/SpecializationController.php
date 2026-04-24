<?php

namespace App\Http\Controllers\Cms\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecializationController extends Controller
{
    public function index()
    {
        $specializations = Specialization::with('college')->orderBy('id', 'desc')->paginate(10);
        return view('cms.admin.specializations.index', compact('specializations'));
    }

    public function create()
    {
        $colleges = College::all();
        return view('cms.admin.specializations.create', compact('colleges'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'college_id' => 'required|exists:colleges,id',
            'name' => 'required|string|min:3|max:150',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon' => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $specialization = new Specialization();
        $specialization->college_id = $request->college_id;
        $specialization->name = $request->name;
        $isSaved = $specialization->save();

        return response()->json([
            'icon' => $isSaved ? 'success' : 'error',
            'title' => $isSaved ? 'Created successfully' : 'Create failed',
        ], $isSaved ? 200 : 400);
    }

    public function show($id)
    {
        $specialization = Specialization::with('college')->findOrFail($id);
        return view('cms.admin.specializations.show', compact('specialization'));
    }

   public function edit($id)
{
    $specialization = Specialization::findOrFail($id);
    $colleges = College::all();

    return view('cms.admin.specializations.edit', compact('specialization', 'colleges'));
}

    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'college_id' => 'required|exists:colleges,id',
        'name' => 'required|string|min:3|max:150',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'icon' => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

    $specialization = Specialization::findOrFail($id);
    $specialization->college_id = $request->college_id;
    $specialization->name = $request->name;
    $isUpdated = $specialization->save();

   return response()->json([
    'icon' => $isUpdated ? 'success' : 'error',
    'title' => $isUpdated ? 'Updated successfully' : 'Update failed',
    'redirect' => route('admin.specializations.index'),
], $isUpdated ? 200 : 400);
}
    public function destroy($id)
{
    $specialization = Specialization::findOrFail($id);
    $isDeleted = $specialization->delete();

    return response()->json([
        'icon' => $isDeleted ? 'success' : 'error',
        'title' => $isDeleted ? 'Deleted successfully' : 'Delete failed',
    ], $isDeleted ? 200 : 400);
}

public function trashed()
{
    $specializations = Specialization::onlyTrashed()
        ->with('college')
        ->orderBy('deleted_at', 'desc')
        ->get();

    return view('cms.admin.specializations.trashed', compact('specializations'));
}

public function restore($id)
{
    Specialization::onlyTrashed()->findOrFail($id)->restore();

    return redirect()->back()->with('success', 'Restored successfully');
}

public function force($id)
{
    Specialization::onlyTrashed()->findOrFail($id)->forceDelete();

    return redirect()->back()->with('success', 'Deleted permanently successfully');
}

public function forceAll()
{
    $count = Specialization::onlyTrashed()->count();

    if ($count == 0) {
        return response()->json([
            'icon' => 'error',
            'title' => 'No trashed records found',
        ], 404);
    }

    Specialization::onlyTrashed()->forceDelete();

    return response()->json([
        'icon' => 'success',
        'title' => 'All deleted permanently successfully',
    ], 200);
}


}
