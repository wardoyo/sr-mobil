@extends('layouts.global')

@section('title')
	Detail Category
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<label><b>Category name</b></label><br>
					{{$category->name}}
				</div>
			</div>
		</div>
		
	</div>
@endsection