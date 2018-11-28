@extends('layouts.app')
@section('header')
Add New Question
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">You are here : <a href="/">All Questions List</a> > Add New Question</div>
                </div>
                <div class="card">
                    <div class="card-header">Add New Question</div>
                    <div class="card-body">
                        {!! Form::open(['url' => 'questions/apply', 'enctype' => "multipart/form-data"]) !!}
                            <div class="form-group">
                                {{ Form::label('title', 'Question Title : ') }}
                                {{ Form::text('title', null, ['class' => 'form-control']) }}
                                @if($errors->has('title'))
                                    <span style="color: red;">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('body', 'Question Body : ') }}
                                {{ Form::textarea('body', null, ['class' => 'form-control']) }}
                                @if($errors->has('body'))
                                    <span style="color: red;">{{ $errors->first('body') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('attachement', 'Attachement : ') }}
                                {{ Form::file('attachement') }}
                                @if($errors->has('attachement'))
                                    <span style="color: red;">{{ $errors->first('attachement') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection