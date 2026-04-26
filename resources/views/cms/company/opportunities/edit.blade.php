@extends('cms.company.temp')
@section('title', 'Edit Opportunity')
@section('main-title', 'تعديل الفرصة')

@section('content')
<div class="card p-4">
    <div id="error_alert" class="alert alert-danger" hidden>
        <ul id="error_messages_ul" class="mb-0"></ul>
    </div>

    <form id="create_form">
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label>عنوان الفرصة</label>
                <input type="text" id="title" class="form-control" value="{{ $opportunity->title }}">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>نوع التدريب</label>
                <select id="type" class="form-control">
                    <option value="حضوري" {{ $opportunity->type == 'حضوري' ? 'selected' : '' }}>حضوري</option>
                    <option value="عن بعد" {{ $opportunity->type == 'عن بعد' ? 'selected' : '' }}>عن بعد</option>
                    <option value="هجين" {{ $opportunity->type == 'هجين' ? 'selected' : '' }}>هجين</option>
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>عدد الساعات المطلوبة</label>
                <input type="number" id="required_hours" class="form-control" value="{{ $opportunity->required_hours }}">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>عدد المقاعد</label>
                <input type="number" id="seats" class="form-control" value="{{ $opportunity->seats }}">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>آخر موعد</label>
                <input type="date" id="deadline" class="form-control" value="{{ $opportunity->deadline }}">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>الحالة</label>
                <select id="status" class="form-control">
                    <option value="مفتوحة" {{ $opportunity->status == 'مفتوحة' ? 'selected' : '' }}>مفتوحة</option>
                    <option value="مغلقة" {{ $opportunity->status == 'مغلقة' ? 'selected' : '' }}>مغلقة</option>
                    <option value="مسودة" {{ $opportunity->status == 'مسودة' ? 'selected' : '' }}>مسودة</option>
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>المدينة</label>
                <select id="cities_id" class="form-control">
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ $opportunity->cities_id == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>التخصصات</label>
                <select id="specializations" class="form-control">
                    @foreach($specializations as $specialization)
                        <option value="{{ $specialization->id }}"
                            {{ $opportunity->specializations->contains($specialization->id) ? 'selected' : '' }}>
                            {{ $specialization->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>الوصف</label>
                <textarea id="description" class="form-control" rows="4">{{ $opportunity->description }}</textarea>
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>المتطلبات</label>
                <textarea id="requirements" class="form-control" rows="3">{{ $opportunity->requirements }}</textarea>
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>الفوائد</label>
                <textarea id="benefits" class="form-control" rows="3">{{ $opportunity->benefits }}</textarea>
            </div>
        </div>
    </form>

    <div class="mb-4">
        <button type="button" onclick="performUpdate()" class="btn btn-primary">تحديث</button>
        <a href="{{ route('opportunities.index') }}" class="btn btn-light">رجوع</a>
    </div>

    <hr>

    <div class="mt-4">
        <h5 class="mb-3">صورة الفرصة</h5>

        @if($opportunity->image)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $opportunity->image->path) }}" width="220" class="img-thumbnail">
            </div>

            <div class="mb-3">
                <button type="button" class="btn btn-danger"
                        onclick="confirmDestroy('{{ route('images.destroy', $opportunity->image->id) }}', this)">
                    حذف الصورة
                </button>
            </div>
        @endif

        {{-- <div class="form-group mb-3">
            <label>رفع صورة جديدة</label>
            <input type="file" id="image" class="form-control" accept="image/*">
        </div>

        <button type="button" onclick="uploadOpportunityImage()" class="btn btn-primary">
            رفع الصورة
        </button> --}}
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performUpdate() {
        let specializations = Array.from(document.getElementById('specializations').selectedOptions).map(option => option.value);

        let data = {
            title: document.getElementById('title').value,
            type: document.getElementById('type').value,
            required_hours: document.getElementById('required_hours').value,
            seats: document.getElementById('seats').value,
            deadline: document.getElementById('deadline').value,
            status: document.getElementById('status').value,
            cities_id: document.getElementById('cities_id').value,
            description: document.getElementById('description').value,
            requirements: document.getElementById('requirements').value,
            benefits: document.getElementById('benefits').value,
            specializations: specializations,
        };

       update('{{ route('opportunities.update', $opportunity->id) }}', data, '{{ route('opportunities.index') }}');
    }

    function uploadOpportunityImage() {
        let imageFile = document.getElementById('image').files[0];

        if (!imageFile) {
            alert('اختاري صورة أولاً');
            return;
        }

        let data = new FormData();
        data.append('image', imageFile);
        data.append('type', 'opportunity');
        data.append('id', '{{ $opportunity->id }}');

        storeRoute('{{ route('images.store') }}', data);
    }
</script>
@endsection
