@extends('cms.admin.parent')

@section('title','اضافة دولة')
@section('main-title','اضافة دولة')


@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">اضافة دولة جديدة</h3>
    </div>

    <form>
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">اسم الدولة</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter city name">
                </div>

                <div class="form-group col-md-6">
                    <label for="street">الشارع</label>
                    <input type="text" class="form-control" id="street" name="street" placeholder="Enter street">
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="button" onclick="performStore()" class="btn btn-primary">Store</button>
            <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">Go Back</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function performStore(){
        let formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('street', document.getElementById('street').value);

        store('/cms/admin/cities', formData);
    }
</script>
@endsection
