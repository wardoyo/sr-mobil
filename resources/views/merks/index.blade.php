@extends('layouts.global')

@section('title')
	List Merk
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
		<form action="{{ route('merks.index') }}">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Filter By Merk Name" value="{{Request::get('name')}}" name="name" id="">

				<div class="input-group-append">
					<input type="submit" value="Filter" class="btn btn-primary">
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-6">
		<ul class="nav nav-pills card-header-pills">
			<li class="nav-item">
				<a href="{{ route('merks.index') }}" class="nav-link active">Published</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('merks.trash') }}" class="nav-link">Trashed</a>
			</li>
		</ul>
	</div>
</div>
	<div class="row">
		<div class="col-md-12 text-right">
			<a href="{{ route('merks.create') }}" class="btn btn-primary">Create Merk</a>
		</div>
	</div>
	<br>

	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th><b>Name</b></th>
						<th><b>Category</b></th>
						<th><b>Image Banner</b></th>
						<th><b>Action</b></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($merks as $merk)
						
					<tr>
						<td> {{$merk->name}} </td>
						<td> {{$merk->category->name}} </td>
						<td> <img src="{{ asset('storage/'.$merk->image) }}" width="96px"> </td>
						<td>
							<a href="{{ route('merks.show', [$merk->id]) }}" class="btn btn-primary btn-sm">Detail</a>
							<a href="{{ route('merks.edit', [$merk->id]) }}" class="btn btn-info btn-sm">Edit</a>
							<form class="d-inline" method="POST" action="{{ route('merks.destroy', [$merk->id]) }}" onsubmit="return confirm('Move merk to trash?')">
								@csrf
								<input type="hidden" name="_method" value="DELETE">
								<input type="submit" value="Trash" class="btn btn-danger btn-sm">
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="10">
							{{$merks->appends(Request::all())->links()}}
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	
@endsection