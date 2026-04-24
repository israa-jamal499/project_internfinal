<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Image;
use App\Models\Opportunity;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'type' => 'required|string|in:student,company,opportunity',
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        if ($request->type == 'student') {
            $model = Student::findOrFail($request->id);
        } elseif ($request->type == 'company') {
            $model = Company::findOrFail($request->id);
        } else {
            $model = Opportunity::findOrFail($request->id);
        }

        if ($request->hasFile('image')) {
            if ($model->image && $model->image->path && Storage::disk('public')->exists($model->image->path)) {
                Storage::disk('public')->delete($model->image->path);
            }

            $path = $request->file('image')->store('images', 'public');

            if ($model->image) {
                $model->image()->update([
                    'path' => $path,
                ]);
            } else {
                $model->image()->create([
                    'path' => $path,
                ]);
            }

            return response()->json([
                'icon' => 'success',
                'title' => 'تم رفع الصورة بنجاح',
            ], 200);
        }

        return response()->json([
            'icon' => 'error',
            'title' => 'فشل رفع الصورة',
        ], 400);
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        if ($image->path && Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        $isDeleted = $image->delete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }
}
