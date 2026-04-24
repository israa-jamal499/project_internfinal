@extends('cms.admin.parent')

@section('title','تعديل القسم')
@section('main-title','تعديل القسم')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">تعديل القسم</h3>
    </div>

    <form>
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">اسم القسم</label>
                <input type="text" class="form-control" id="name"
                       value="{{ $college->name }}" name="name"
                       placeholder="Enter College Name">
            </div>
        </div>

        <div class="card-footer">
            <button type="button" onclick="performUpdate({{ $college->id }})" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.colleges.index') }}" class="btn btn-secondary">Go Back</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function performUpdate(id){
        let formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('_method', 'PUT');

        storeRoute('/cms/admin/colleges/' + id, formData);
    }
</script>
@endsection
