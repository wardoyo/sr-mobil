@extends('layouts.global')

@section('title')
Create Merk
@endsection

@section('footer-scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<script>
	ClassicEditor
	.create( document.querySelector( '#specification' ) )
	.catch( error => {
		console.error( error );
	} );
</script>
@endsection

@section('content')
@if (session('status'))
<div class="alert alert-success">
	{{session('status')}}
</div>
@endif

<div class="col-md-8">
	<form action="{{ route('merks.store') }}" method="POST" class="bg-white shadow-sm p-3" enctype="multipart/form-data" role="form">
		@csrf

		<div class="form-group">
			<label for="">Merk Name</label>
			<input type="text" class="form-control" id="" placeholder="Input Merk Name" name="name">
		</div>
		<div class="form-group">
			<label>Image</label>
			<input type="file" class="form-control" name="image" >
		</div>
		<div class="form-group">
			<label>Category</label>
			<select name="category" class="form-control">

				@foreach ($categories as $category)
				<option value=" {{$category->id}} ">{{$category->name}}</option>
				@endforeach

			</select>
		</div>

		<div class="form-group">
			<label>Spesification</label>
			<textarea id="specification" name="specification" class="form-control" cols="30" rows="20">
				
			</textarea>
		</div>
		<button type="submit" class="btn btn-primary" value="save">Submit</button>
	</form>
</div>
@endsection