@extends('cms.admin.parent')

@section('title','القسم')
@section('main-title','القسم')


@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.colleges.create') }}" class="btn btn-primary">اضافة قسم جديد</a>
                        <a href="{{ route('admin.colleges.trashed') }}" class="btn btn-warning">سلة المحزوفات</a>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>اسم القسم</th>
                                <th class="text-center action-col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($colleges as $college)
                                <tr id="row-{{ $college->id }}">
                                    <td>{{ $college->id }}</td>
                                    <td>{{ $college->name }}</td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('admin.colleges.show',$college->id) }}" class="btn btn-info btn-sm" title="show">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.colleges.edit',$college->id) }}" class="btn btn-primary btn-sm" title="edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <button type="button" onclick="performDestroy({{ $college->id }}, this)"
                                                    class="btn btn-danger btn-sm" title="delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No colleges found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{ $colleges->links() }}
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function performDestroy(id, reference){
        confirmDestroy('/cms/admin/colleges/' + id, reference);
    }
</script>
@endsection
