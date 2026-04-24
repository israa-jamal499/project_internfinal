@extends('cms.admin.temp')
@section('title', 'Edit Internship')
@section('main-title', 'تعديل تدريب')

@section('content')
<div class="card p-4">

    <div id="error_alert" class="alert alert-danger" hidden>
        <ul id="error_messages_ul" class="mb-0"></ul>
    </div>

    <form id="update_form">
        <div class="row">

            <div class="form-group col-md-6 mb-3">
                <label>الطالب</label>
                <select id="students_id" class="form-control">
                    <option value="">اختر الطالب</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ $internship->students_id == $student->id ? 'selected' : '' }}>
                            {{ $student->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>الشركة</label>
                <select id="companies_id" class="form-control">
                    <option value="">اختر الشركة</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ $internship->companies_id == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>المشرف</label>
                <select id="supervisors_id" class="form-control">
                    <option value="">اختر المشرف</option>
                    @foreach($supervisors as $supervisor)
                        <option value="{{ $supervisor->id }}" {{ $internship->supervisors_id == $supervisor->id ? 'selected' : '' }}>
                            {{ $supervisor->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>الفرصة</label>
                <select id="opportunities_id" class="form-control">
                    <option value="">اختر الفرصة</option>
                    @foreach($opportunities as $opportunity)
                        <option value="{{ $opportunity->id }}" {{ $internship->opportunities_id == $opportunity->id ? 'selected' : '' }}>
                            {{ $opportunity->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="form-group col-md-6 mb-3">
                <label>رقم الطلب</label>
                <input type="number" id="applications_id" class="form-control" value="{{ $internship->applications_id }}" placeholder="اختياري">
            </div> --}}

            <div class="form-group col-md-6 mb-3">
                <label>الحالة</label>
                <select id="status" class="form-control">
                    <option value="قيد التدريب" {{ $internship->status == 'قيد التدريب' ? 'selected' : '' }}>قيد التدريب</option>
                    <option value="مكتمل" {{ $internship->status == 'مكتمل' ? 'selected' : '' }}>مكتمل</option>
                    <option value="متوقف" {{ $internship->status == 'متوقف' ? 'selected' : '' }}>متوقف</option>
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>تاريخ البداية</label>
                <input type="date" id="start_date" class="form-control" value="{{ $internship->start_date }}">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>تاريخ النهاية</label>
                <input type="date" id="end_date" class="form-control" value="{{ $internship->end_date }}">
            </div>

            <div class="form-group col-md-4 mb-3">
                <label>الساعات المطلوبة</label>
                <input type="number" id="required_hours" class="form-control" min="0" value="{{ $internship->required_hours }}">
            </div>

            <div class="form-group col-md-4 mb-3">
                <label>الساعات المنجزة</label>
                <input type="number" id="completed_hours" class="form-control" min="0" value="{{ $internship->completed_hours }}">
            </div>

            <div class="form-group col-md-4 mb-3">
                <label>إجمالي الساعات</label>
                <input type="number" id="total_hours" class="form-control" min="0" value="{{ $internship->total_hours }}">
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>الملاحظات</label>
                <input type="text" id="notes" class="form-control" value="{{ $internship->notes }}" placeholder="ملاحظات مختصرة">
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>المهام</label>
                <textarea id="tasks" class="form-control" rows="4" placeholder="اكتب المهام هنا">{{ $internship->tasks }}</textarea>
            </div>

        </div>

        <div class="mt-3">
            <button type="button" onclick="performUpdate()" class="btn btn-primary">تعديل</button>

            <a href="{{ route('admin.internships.index') }}" class="btn btn-light">رجوع</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function performUpdate() {
        let data = {
            students_id: document.getElementById('students_id').value,
            companies_id: document.getElementById('companies_id').value,
            supervisors_id: document.getElementById('supervisors_id').value,
            opportunities_id: document.getElementById('opportunities_id').value,
            // applications_id: document.getElementById('applications_id').value,
            status: document.getElementById('status').value,
            start_date: document.getElementById('start_date').value,
            end_date: document.getElementById('end_date').value,
            required_hours: document.getElementById('required_hours').value,
            completed_hours: document.getElementById('completed_hours').value,
            total_hours: document.getElementById('total_hours').value,
            notes: document.getElementById('notes').value,
            tasks: document.getElementById('tasks').value,
        };

        updateRoute('/cms/admin/internships/{{ $internship->id }}', data);
    }
</script>
@endsection
