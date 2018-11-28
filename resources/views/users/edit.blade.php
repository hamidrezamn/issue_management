@extends('layouts.app')
@section('header')
Add New Question
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">You are here : <a href="{{ route('users.index') }}">Users Management</a> > Update User : {{ $user->name }}</div>
                </div>
                <div class="card">
                    <div class="card-header">Update User : {{ $user->name }}</div>
                    <div class="card-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group">

                                    <strong>Name:</strong>

                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group">

                                    <strong>Email:</strong>

                                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group">

                                    <strong>Password:</strong>

                                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group">

                                    <strong>Confirm Password:</strong>

                                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group">

                                    <strong>Role:</strong>

                                    {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                                    <button type="submit" class="btn btn-primary">Submit</button>

                            </div>

                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection