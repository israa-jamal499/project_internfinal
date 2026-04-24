<?php

namespace App\Http\Controllers\Cms\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::orderBy('id', 'desc')->paginate(10);
        return view('cms.admin.cities.index', compact('cities'));
    }

    public function create()
    {
        return view('cms.admin.cities.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|min:3|max:150',
            'street' => 'nullable|string|max:150',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $city = new City();
        $city->name = $request->name;
        $city->street = $request->street;
        $isSaved = $city->save();

        return response()->json([
            'icon'     => $isSaved ? 'success' : 'error',
            'title'    => $isSaved ? 'Created successfully' : 'Create failed',
            'redirect' => route('admin.cities.index'),
        ], $isSaved ? 200 : 400);
    }

    public function show(string $id)
    {
        $city = City::findOrFail($id);
        return view('cms.admin.cities.show', compact('city'));
    }

    public function edit(string $id)
    {
        $city = City::findOrFail($id);
        return view('cms.admin.cities.edit', compact('city'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|min:3|max:150',
            'street' => 'nullable|string|max:150',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $city = City::findOrFail($id);
        $city->name = $request->name;
        $city->street = $request->street;
        $isUpdated = $city->save();

        return response()->json([
            'icon'     => $isUpdated ? 'success' : 'error',
            'title'    => $isUpdated ? 'Updated successfully' : 'Update failed',
            'redirect' => route('admin.cities.index'),
        ], $isUpdated ? 200 : 400);
    }

    public function destroy(string $id)
    {
        $city = City::findOrFail($id);
        $isDeleted = $city->delete();

        return response()->json([
            'icon'  => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }

    public function trashed()
    {
        $cities = City::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('cms.admin.cities.trashed', compact('cities'));
    }

    public function restore($id)
    {
        City::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back()->with('success', 'Restored successfully');
    }

    public function force($id)
    {
        City::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->back()->with('success', 'Deleted permanently');
    }


}