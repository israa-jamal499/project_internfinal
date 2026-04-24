@extends('cms.admin.parent')

@section('title','اضافة تخصص')

@section('main-title','اضافة تخصص')

{{-- @section('sub-title','Create Specialization') --}}

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">اضافة تخصص جديد</h3>
    </div>

    <form>
        @csrf
        <div class="card-body">
            <div class="row">

                {{-- اختيار الكلية --}}
                <div class="form-group col-md-6">
                    <label>القسم</label>
                    <select class="form-control" id="college_id" name="college_id">
                        <option value="">نحديد القسم</option>
                        @foreach ($colleges as $college)
                            <option value="{{ $college->id }}">
                                {{ $college->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- اسم التخصص --}}
                <div class="form-group col-md-6">
                    <label>اسم التخصص</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="ادخل اسم التخصص">
                </div>

            </div>
        </div>

        <div class="card-footer">
            <button type="button" onclick="performStore()" class="btn btn-primary">Store</button>
            <a href="{{ route('admin.specializations.index') }}" class="btn btn-secondary">Go Back</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function performStore(){
        let formData = new FormData();

        formData.append('name', document.getElementById('name').value);
        formData.append('college_id', document.getElementById('college_id').value);

        store('/cms/admin/specializations', formData);
    }
</script>
@endsection
