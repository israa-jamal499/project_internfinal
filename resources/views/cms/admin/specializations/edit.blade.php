@extends('cms.admin.parent')

@section('title','Edit Specialization')

@section('main-title','Edit Specialization')

@section('sub-title','Edit Specialization')

@section('styles')
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Specialization</h3>
    </div>

    <form>
        @csrf
        <div class="card-body">
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>College</label>
                        <select class="form-control" id="college_id" name="college_id">
                            @foreach ($colleges as $college)
                                <option value="{{ $college->id }}"
                                    {{ $specialization->college_id == $college->id ? 'selected' : '' }}>
                                    {{ $college->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="name">Specialization Name</label>
                    <input type="text" class="form-control" id="name"
                           value="{{ $specialization->name }}" name="name"
                           placeholder="Enter Specialization Name">
                </div>

            </div>
        </div>

        <div class="card-footer">
            <button type="button" onclick="performUpdate({{ $specialization->id }})" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.specializations.index') }}" class="btn btn-secondary">Go Back</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function performUpdate(id){
        let formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('college_id', document.getElementById('college_id').value);
        formData.append('_method', 'PUT');

        storeRoute('/cms/admin/specializations/' + id, formData);
    }
</script>
@endsection
