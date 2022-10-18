@extends('layouts.global')

@section('title')
	Detail Merk {{$merk->name}}
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<label><b>Merk name</b></label><br>
					{{$merk->name}}
					<br><br>
					<label><b>Category</b></label><br>
					{{$merk->category->name}}
					<br><br>
					<label><b>Dashboard image</b></label><br>
					<img src="{{ asset('storage/'.$merk->image) }}" width="120px" class="">
					<br><br>
					{!! $merk->specification !!}
				</div>
			</div>
		</div>
		
	</div>
@endsection