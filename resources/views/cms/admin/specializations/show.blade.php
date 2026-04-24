@extends('cms.admin.parent')

@section('title','Show Specialization')

@section('main-title','Show Specialization')

@section('styles')
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Show Specialization</h3>
    </div>

    <form>
        <div class="card-body">
            <div class="form-group">
                <label for="name">اسم التخصص</label>
                <input type="text" class="form-control" id="name" disabled value="{{ $specialization->name }}" name="name">
            </div>

            <div class="form-group">
                <label for="college_name">اسم القسم</label>
                <input type="text" class="form-control" id="college_name" disabled value="{{ $specialization->college->name ?? '' }}" name="college_name">
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('admin.specializations.index') }}" class="btn btn-primary">Go To Index</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
@endsection
