@extends('layouts.app')
@section('header')
Add New Question
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">You are here : <a href="{{ route('users.index') }}">Users Management</a> > Show User : {{ $user->name }}</div>
                </div>
                <div class="card">
                    <div class="card-header">User : {{ $user->name }}</div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group">

                                    <strong>Name:</strong>

                                    {{ $user->name }}

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group">

                                    <strong>Email:</strong>

                                    {{ $user->email }}

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group">

                                    <strong>Roles:</strong>

                                    @if(!empty($user->roles))

                                        @foreach($user->roles as $v)

                                            <label class="label label-success">{{ $v->display_name }}</label>

                                        @endforeach

                                    @endif

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection