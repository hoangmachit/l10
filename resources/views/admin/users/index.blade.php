@extends('layouts.app')
@section('page-title')
    <h4 class="m-0">Users Management</h4>
@endsection
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Users Management</h2>
                <div class="card-tools">
                    @can('user-create')
                        <a class="btn btn-success" href="{{ route('admin.users.create') }}"><i class="fas fa-plus-square"></i> Add
                            User</a>
                    @endcan
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <tr class="bg-blue text-center">
                        <th width="50px">No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th width="150px">Action</th>
                    </tr>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td class="text-center">{{ ++$key }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td class="text-center">
                                @can('user-edit')
                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                                @endcan
                                @can('user-delete')
                                    <form action="{{ route('admin.users.destroy',[$user->id]) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                    <button class="btn btn-sm btn-danger delete_confirm" type="submit">Delete</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="float-left">
                    <div class="dataTables_info">
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                    </div>
                </div>
                <div class="float-right">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('.delete_confirm').click(function(event) {
                var form = $(this).closest("form");
                event.preventDefault();
                swal.fire({
                        title: 'Are you sure you want to delete this record?',
                        text: "If you delete this, it will be gone forever.",
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        showDenyButton: true,
                        denyButtonText: 'Cancel',
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        } else if (result.isDenied) {
                            Swal.fire('Your record is safe', '', 'info')
                        }

                    });
            });
        });
    </script>
@endsection
