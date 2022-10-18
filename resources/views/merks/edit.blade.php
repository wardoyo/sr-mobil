@extends('layouts.global')

@section('title')
	Edit Merk {{$merk->name}}
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
		<form action="{{ route('merks.update', [$merk->id]) }}" method="POST" class="bg-white shadow-sm p-3" enctype="multipart/form-data" role="form">
			@csrf
			<input type="hidden" name="_method" value="PUT" id="">
			<div class="form-group">
				<label for="">Merk Name</label>
				<input type="text" class="form-control" id="" placeholder="Input Merk Name" name="name" value=" {{$merk->name}} ">
			</div>
			<div class="form-group">
				<label>Dashboard Image</label><br>
				<small class="text-muted">Current Dashboard Image</small><br>
				@if ($merk->image)
					<img src="{{ asset('storage/'.$merk->image) }}" width="96px"><br><br>
				@endif
				<input type="file" class="form-control" name="image" >
				<small class="text-muted">Empty if you won't change the image</small>
			</div>
			<div class="form-group">
				<label>Category</label>
				<select name="category" class="form-control">

					@foreach ($categories as $category)
					<option value=" {{$category->id}} " {{$category->id == $merk->category_id ? 'selected' : ''}} >{{$category->name}}</option>
					@endforeach

				</select>
			</div>

			<div class="form-group">
			<label>Spesification</label>
			<textarea id="specification" name="specification" class="form-control" cols="30" rows="20">
				{{$merk->specification}}
			</textarea>
		</div>

			<button type="submit" class="btn btn-primary" value="save">Submit</button>
		</form>
	</div>
@endsection