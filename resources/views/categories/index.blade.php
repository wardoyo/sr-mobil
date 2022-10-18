@extends('layouts.global')

@section('title')
	Category List
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
		<form action="{{ route('categories.index') }}">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Filter By Category Name" value=" {{Request::get('name')}} " name="name">

				<div class="input-group-append">
					<input type="submit" value="Filter" class="btn btn-primary">
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-6">
		<ul class="nav nav-pills card-header-pills">
			<li class="nav-item">
				<a href="{{ route('categories.index') }}" class="nav-link active">Published</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('categories.trash') }}" class="nav-link">Trashed</a>
			</li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12 text-right">
		<a href=" {{ route('categories.create') }} " class="btn btn-primary">Create Category</a>
	</div>
</div>
<br>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th><b>Name</b></th>
						<th><b>Actions</b></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($categories as $category)
					<tr>
						<td> {{$category->name}} </td>
						<td>
							<a href="{{ route('categories.edit', [$category->id]) }}" class="btn btn-info btn-sm">Edit</a>
							<a href="{{ route('categories.show', [$category->id]) }}" class="btn btn-primary btn-sm">Detail</a>
							<form action="{{ route('categories.destroy', [$category->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Move category to trash?')">
								@csrf
								<input type="hidden" name="_method" value="DELETE">
								<input type="submit" class="btn btn-danger btn-sm" value="Trash">
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection