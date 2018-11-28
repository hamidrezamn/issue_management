@extends('layouts.app')
@section('header')
Update Question : {{ $model->title }}
@endsection
@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">You are here : <a href="/">All Questions List</a> > View Question</div>
				</div>
				Question : {{ $model->title }}
				<div class="card">
					<div class="card-header">{{ $model->user->name }}</div>
					<div class="card-body">
						{{ $model->body }}
					</div>
				</div>
				@if (count($answers) > 0)
					Answers :
				@endif
				@foreach ($answers as $key => $value)
					<div class="card">
						<div class="card-header">{{ $value->user->name }}</div>
						<div class="card-body">
							<pre>{{ $value->body }}</pre>
						</div>
					</div>
				@endforeach
				<div class="card">
					<div class="card-header">New Answer :</div>
					<div class="card-body">
						{!! Form::open(['url' => 'questions/createAnswer']) !!}
							{{ Form::hidden('q_id', $model->id) }}
                            <div class="form-group">
                                {{ Form::label('body', 'Type Your Answer : ') }}
                                {{ Form::textarea('body', null, ['class' => 'form-control']) }}
                                @if($errors->has('body'))
                                    <span style="color: red;">{{ $errors->first('body') }}</span>
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