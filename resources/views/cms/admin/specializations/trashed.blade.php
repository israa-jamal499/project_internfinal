@extends('cms.admin.parent')

@section('title','سلة المحزوفات')

@section('main-title','سلة المحزوفات')



@section('styles')
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.specializations.index') }}" class="btn btn-primary">Back To Index</a>

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
                                @forelse($specializations as $specialization)
                                    <tr>
                                        <td>{{ $specialization->id }}</td>
                                        <td>{{ $specialization->name }}</td>
                                        <td>{{ $specialization->college->name ?? '' }}</td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">

                                                <a href="{{ route('admin.specializations.restore', $specialization->id) }}"
                                                   class="btn btn-primary btn-sm" title="restore">
                                                    <i class="fas fa-undo"></i>
                                                </a>

                                                <form action="{{ route('admin.specializations.force', $specialization->id) }}"
                                                      method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="delete"
                                                            onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No trashed specializations found</td>
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
@endsection
