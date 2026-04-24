@extends('cms.admin.parent')

@section('title','Show City')
@section('main-title','Show City')


@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Show City</h3>
    </div>

    <form>
        <div class="card-body">
            <div class="form-group">
                <label for="name">اسم الدولة</label>
                <input type="text" class="form-control" id="name" disabled value="{{ $city->name }}">
            </div>

            <div class="form-group">
                <label for="street">الشارع</label>
                <input type="text" class="form-control" id="street" disabled value="{{ $city->street }}">
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('admin.cities.index') }}" class="btn btn-primary">Go To Index</a>
        </div>
    </form>
</div>
@endsection
