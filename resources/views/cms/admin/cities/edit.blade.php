@extends('cms.admin.parent')

@section('title','تعديل الدولة')
@section('main-title','تعديل الدولة')


@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit City</h3>
    </div>

    <form>
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">اسم الدولة</label>
                    <input type="text" class="form-control" id="name" value="{{ $city->name }}" name="name" placeholder="Enter city name">
                </div>

                <div class="form-group col-md-6">
                    <label for="street">الشارع</label>
                    <input type="text" class="form-control" id="street" value="{{ $city->street }}" name="street" placeholder="Enter street">
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="button" onclick="performUpdate({{ $city->id }})" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">Go Back</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function performUpdate(id){
        let formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('street', document.getElementById('street').value);
        formData.append('_method', 'PUT');

        storeRoute('/cms/admin/cities/' + id, formData);
    }
</script>
@endsection
