@extends('cms.admin.parent')

@section('title','اضافة تخصص')

@section('main-title','اضافة تخصص')

@section('styles')
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.specializations.create') }}" class="btn btn-primary">اضافة تخصص جديد</a>
                        <a href="{{ route('admin.specializations.trashed') }}" class="btn btn-warning">
   سلة المحزوفات
</a>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">ID</th>
                                    <th>اسم التخصص</th>
                                    <th>اسم القسم</th>
                                    <th class="text-center action-col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($specializations as $specialization)
                                    <tr>
                                        <td>{{ $specialization->id }}</td>
                                        <td>{{ $specialization->name }}</td>
                                        <td>{{ $specialization->college->name ?? '' }}</td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">

                                                <a href="{{ route('admin.specializations.show', $specialization->id) }}" class="btn btn-info btn-sm" title="show">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.specializations.edit', $specialization->id) }}" class="btn btn-primary btn-sm" title="edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="#" method="POST">
                                                    <button type="button" onclick="performDestroy({{ $specialization->id }})" class="btn btn-danger btn-sm" title="delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        {{ $specializations->links() }}
    </div>
</section>
@endsection

@section('scripts')
<script>
    function performDestroy(id){
        confirmDestroy('/cms/admin/specializations/' + id);
    }
</script>
@endsection
