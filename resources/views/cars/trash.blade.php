@extends('layouts.global')

@section('title')
	Cars List
@endsection

@section('content')

@if (session('status'))
	<div class="col-md-12">
		<div class="alert alert-warning">
			{{ session('status') }}
		</div>
	</div>
@endif
	<div class="row">
		<div class="col-md-6">
			<form action="{{ route('cars.index') }}">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Filter By Car Name" name="name" value="{{Request::get('name')}}">

					<div class="input-group-append">
						<input type="submit" value="Filter" class="btn btn-primary">
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-6">
			<ul class="nav nav-pills card-header-pills">
				<li class="nav-item">
					<a href="{{ route('cars.index') }}" class="nav-link">Published</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('cars.trash') }}" class="nav-link active">Trashed</a>
				</li>
			</ul>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th><b>Name</b></th>
						<th><b>Merk</b></th>
						<th><b>Price</b></th>
						<th><b>Action</b></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($cars as $car)
					<tr>
						<td> {{$car->name}} </td>
						<td> {{$car->merk->name}} </td>
						<td> {{$car->price}} </td>
						<td>
							<a href="{{ route('cars.restore', [$car->id]) }}" class="btn btn-success">Restore</a>
							<form action="{{ route('cars.delete-permanent', [$car->id]) }}" class="d-inline" method="POST" onsubmit="return confirm('Permanently delete this car?')">
								@csrf
								<input type="hidden" name="_method" value="DELETE" id="">
								<input type="submit" value="Delete" class="btn btn-danger">
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>		
	</div>
@endsection