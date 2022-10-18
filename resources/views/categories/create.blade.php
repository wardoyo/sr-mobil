@extends('layouts.global')

@section('title')
	Create Category
@endsection

@section('content')
@if (session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
@endif
	<div class="col-md-8">
		<form action="{{ route('categories.store') }}" method="POST" role="form" class="bg-white shadow-sm p-3">

			@csrf

			<div class="form-group">
				<label for="name">Category Name</label>
				<input type="text" class="form-control" id="name" placeholder="Input Category Name" name="name" >
			</div>
			<br>
		
			<button type="submit" class="btn btn-primary" value="save">Submit</button>
		</form>
	</div>
@endsection