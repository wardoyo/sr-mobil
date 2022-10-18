@extends('layouts.global')

@section('title')
	Detail Merk {{$car->name}}
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<label><b>Car name</b></label><br>
					{{$car->name}}
					<br><br>
					<label><b>Merk</b></label><br>
					{{$car->merk->name}}
					<br><br>
					<label><b>Price</b></label><br>
					{{$car->price}}
					<br><br>
				</div>
			</div>
		</div>
		
	</div>
@endsection