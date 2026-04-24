@extends('cms.admin.parent')

@section('title','سلة المحزوفات')
@section('main-title','سلة المحزوفات')


@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <a href="{{ route('admin.colleges.index') }}" class="btn btn-primary">Back To Index</a>

                        <form id="delete-all-form" action="{{ route('admin.colleges.forceAll') }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDeleteAll()" class="btn btn-danger">حزف الكل</button>
                        </form>
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
                                <tr>
                                    <td>{{ $college->id }}</td>
                                    <td>{{ $college->name }}</td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('admin.colleges.restore', $college->id) }}"
                                               class="btn btn-primary btn-sm" title="restore">
                                                <i class="fas fa-undo"></i>
                                            </a>

                                            <form action="{{ route('admin.colleges.force', $college->id) }}"
                                                  method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No trashed colleges found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function confirmDeleteAll() {
        Swal.fire({
            title: 'Are you sure?',
            text: "All trashed colleges will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete all',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-all-form').submit();
            }
        });
    }
</script>
@endsection
