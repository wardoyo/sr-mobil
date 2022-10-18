@extends('layouts.global')

@section('title')
	Create Merk
@endsection

@section('content')
	@if (session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif

	<div class="col-md-8">
		<form action="{{ route('cars.store') }}" method="POST" class="bg-white shadow-sm p-3" role="form">
			@csrf
			
			<div class="form-group">
				<label for="">Car Name</label>
				<input type="text" class="form-control" id="" placeholder="Input Merk Name" name="name">
			</div>
			<div class="form-group">
				<label>Merk</label>
				<select name="merk" class="form-control">

					@foreach ($merks as $merk)
					<option value=" {{$merk->id}} ">{{$merk->name}}</option>
					@endforeach

				</select>
			</div>
			<div class="form-group">
				<label>Price</label>
				<input type="text" name="price" class="form-control" placeholder="Input Price">
			</div>
			<button type="submit" class="btn btn-primary" value="save">Submit</button>
		</form>
	</div>
@endsection