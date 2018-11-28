@extends('layouts.app')
@section('header')
Update Question : {{ $model->title }}
@endsection
@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">You are here : <a href="/">All Questions List</a> > Update Question : {{ $model->title }}</div>
				</div>
				<div class="card">
					<div class="card-header">Update Question : {{ $model->title }}</div>
					<div class="card-body">
						{!! Form::model($model, ['route' => ['questions.update', $model->id]]) !!}
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