<?php

namespace App\Http\Controllers\Cms\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Internship;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CertificateController extends Controller
{
    public function index()
    {
        $internships = Internship::with([
                'student',
                'company',
                'opportunity',
                'certificate',
            ])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('cms.admin.cirtificate.index', compact('internships'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'internships_id' => 'required|exists:internships,id',
            'issue_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon' => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $internship = Internship::with(['certificate', 'student'])->findOrFail($request->internships_id);

        if ($internship->status != 'مكتمل') {
            return response()->json([
                'icon' => 'error',
                'title' => 'لا يمكن إصدار شهادة لتدريب غير مكتمل',
            ], 400);
        }

        if ($internship->completed_hours < $internship->required_hours) {
            return response()->json([
                'icon' => 'error',
                'title' => 'لا يمكن إصدار الشهادة قبل اكتمال الساعات المطلوبة',
            ], 400);
        }

        if ($internship->certificate) {
            $certificate = $internship->certificate;
            $certificate->issue_date = $request->issue_date;
            $certificate->notes = $request->notes;
            $certificate->is_issued = true;
            $isSaved = $certificate->save();
        } else {
            $certificate = new Certificate();
            $certificate->certificate_number = 'CERT-' . now()->format('Ymd') . '-' . $internship->id;
            $certificate->issue_date = $request->issue_date;
            $certificate->notes = $request->notes;
            $certificate->is_issued = true;
            $certificate->internships_id = $internship->id;
            $isSaved = $certificate->save();
        }
        Notification::create([
    'title' => 'تم إصدار الشهادة',
    'body' => 'تم إصدار شهادة التدريب الخاصة بك بنجاح.',
    'type' => 'certificate',
    'link' => route('front.student.certificate'),
    'is_read' => false,
    'read_at' => null,
    'user_id' => $internship->student->user_id,
]);

        return response()->json([
            'icon' => $isSaved ? 'success' : 'error',
            'title' => $isSaved ? 'تم إصدار الشهادة بنجاح' : 'فشل إصدار الشهادة',
            'redirect' => route('admin.admin.certificates.index'),
        ], $isSaved ? 200 : 400);
    }

    public function show($id)
    {
        $internship = Internship::with([
                'student',
                'company',
                'opportunity',
                'certificate',
            ])
            ->findOrFail($id);

        return view('cms.admin.cirtificate.show', compact('internship'));
    }
}