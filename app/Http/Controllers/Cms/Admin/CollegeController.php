<?php

namespace App\Http\Controllers\Cms\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollegeController extends Controller
{
    public function index()
    {
        $colleges = College::orderBy('id', 'desc')->paginate(10);
        return view('cms.admin.colleges.index', compact('colleges'));
    }

    public function create()
    {
        return view('cms.admin.colleges.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:150|unique:colleges,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon' => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $college = new College();
        $college->name = $request->name;
        $isSaved = $college->save();

        return response()->json([
            'icon' => $isSaved ? 'success' : 'error',
            'title' => $isSaved ? 'Created successfully' : 'Create failed',
            'redirect' => route('admin.colleges.index'),
        ], $isSaved ? 200 : 400);
    }

    public function show($id)
    {
        $college = College::findOrFail($id);
        return view('cms.admin.colleges.show', compact('college'));
    }

    public function edit($id)
    {
        $college = College::findOrFail($id);
        return view('cms.admin.colleges.edit', compact('college'));
    }

    public function update(Request $request, $id)
    {
        $college = College::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:150|unique:colleges,name,' . $college->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon' => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $college->name = $request->name;
        $isUpdated = $college->save();

        return response()->json([
            'icon' => $isUpdated ? 'success' : 'error',
            'title' => $isUpdated ? 'Updated successfully' : 'Update failed',
            'redirect' => route('admin.colleges.index'),
        ], $isUpdated ? 200 : 400);
    }

    public function destroy($id)
    {
        $college = College::findOrFail($id);
        $isDeleted = $college->delete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }

    public function trashed()
    {
        $colleges = College::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('cms.admin.colleges.trashed', compact('colleges'));
    }

    public function restore($id)
    {
        College::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back()->with('success', 'Restored successfully');
    }

    public function force($id)
    {
        College::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->back()->with('success', 'Deleted permanently');
    }

    public function forceAll()
    {
        College::onlyTrashed()->forceDelete();
        return redirect()->back()->with('success', 'All deleted permanently');
    }
}
