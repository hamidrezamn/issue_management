@extends('layouts.app')
@section('header')
All Questions List
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(Session::has('error'))
                    <p class="alert alert-danger">{!! Session::get('error') !!}</p>
                    @foreach($errors->all() as $error)
                        <p>{!! $error !!}</p>
                    @endforeach
                @endif
                <div class="card">
                    <div class="card-header">You are here : All Questions List</div>
                    <div class="card-body">
                        <a href="{{ url('questions/create') }}" class="btn btn-success">Create New Question</a>
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Question Title</th>
                                <th>Question Status</th>
                                <th>Question Owner</th>
                                <th>Creation Time</th>
                                <th style="width: 18%;"></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($questions as $key => $value)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            <a href="{{ url('questions/view') . '/' . $value->id }}">{{ $value->title }}</a>
                                        </td>
                                        <td>
                                            <?php $status = $value->status; ?>
                                            @if($status == 1)
                                                <span class="text-danger">Open</span>
                                            @else
                                                <span class="text-success">Answered</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $value->user->name }}
                                        </td>
                                        <td>
                                            {{ $value->created_at }}
                                        </td>
                                        <td class="operations">
                                            <a class="btn btn-success" href="{{ url('questions/view') . '/' . $value->id }}">View</a>
                                            <a class="btn btn-success" href="{{ url('questions/update') . '/' . $value->id }}">Update</a>
                                            {!! Form::open(['url' => 'questions/delete']) !!}
                                                {{ Form::hidden('_delete', $value->id) }}
                                                {{ Form::submit('Delete', ['class' => 'btn btn-success']) }}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection