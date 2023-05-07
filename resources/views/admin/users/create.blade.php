@extends('layouts.app')
@section('breadcrumb')
    <h4 class="m-0">Create New User</h4>
@endsection
@section('content')
    <!-- general form elements -->
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h2 class="card-title">Create New User</h2>
                <div class="card-tools">
                    <a class="btn btn-success" href="{{ route('admin.users.index') }}"><i class="fa fa-angle-double-left"></i>
                        Back
                        To User List</a>
                </div>
            </div>

            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin.users.store') }}" role="form" method="POST">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <input type="text" class="form-control" placeholder="Name"
                                        value="{{ old('name') }}" name="name">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    <input type="text" class="form-control" placeholder="Email"
                                        value="{{ old('email') }}" name="email">
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Password:</strong>
                                    <input type="password" class="form-control" placeholder="Password" value=""
                                        name="password">
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Confirm Password:</strong>
                                    <input type="password" class="form-control" placeholder="Confirm Password"
                                        value="" name="confirm-password">
                                    <span class="text-danger">{{ $errors->first('confirm-password') }}</span>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Role:</strong>
                                <select name="roles" class="form-control" id="roles" multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">
                                            {{ $role }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('roles') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
@endsection
