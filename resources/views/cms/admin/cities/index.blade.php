@extends('cms.admin.parent')

@section('title','الدولة')
@section('main-title','الدولة')


@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.cities.create') }}" class="btn btn-primary">اضافة دولة جديدة</a>
                        <a href="{{ route('admin.cities.trashed') }}" class="btn btn-warning">سلة المحزوفات</a>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">ID</th>
                                    <th>اسم الدولة</th>
                                    <th>الشارع</th>
                                    <th class="text-center action-col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cities as $city)
                                    <tr>
                                        <td>{{ $city->id }}</td>
                                        <td>{{ $city->name }}</td>
                                        <td>{{ $city->street }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('admin.cities.show',$city->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.cities.edit',$city->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <button type="button" onclick="performDestroy({{ $city->id }})" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{ $cities->links() }}
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function performDestroy(id){
        confirmDestroy('/cms/admin/cities/' + id);
    }
</script>
@endsection
