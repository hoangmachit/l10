@extends('layouts.app')
@section('breadcrumb')
    <h4 class="m-0">Edit User</h4>
@endsection
@section('content')
    <!-- general form elements -->
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h2 class="card-title">Edit User</h2>
                <div class="card-tools">
                    <a class="btn btn-success" href="{{ route('admin.users.index') }}"><i class="fa fa-angle-double-left"></i> Back
                        To User List</a>
                </div>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['admin.users.update', $user->id]]) !!}
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {!! Form::text('name', null, [
                                    'value' => '{{ old('name') }}',
                                    'placeholder' => 'Name',
                                    'class' => 'form-control',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Email:</strong>
                                {!! Form::text('email', null, [
                                    'value' => '{{ old('email') }}',
                                    'placeholder' => 'Email',
                                    'class' => 'form-control',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Password:</strong>
                                {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Confirm Password:</strong>
                                {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password', 'class' => 'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('confirm-password') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Role:</strong>
                            {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control', 'multiple']) !!}
                            <span class="text-danger">{{ $errors->first('roles') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.card -->
    </div>
@endsection
