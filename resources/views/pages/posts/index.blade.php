@extends('layout.master')
@section('content')
<form class="form-group" method="post" action="{{ route('posts.store') 	}}" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="title">Title</label>
		<input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
		@error('title')<span style="color: red;font-style: italic;">{{ $message }}</span>@enderror
	</div>
	<div class="form-group">
		<label for="cat_id">Category</label>
		<select class="form-control" name="cat_id">
			<option value="">--Select Category--</option>
			@foreach($categories as $category)
				<option value="{{ $category->id }}">{{ $category->category }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="descripton">Poor Descripton</label>
		  <textarea id="descripton" name="descripton"></textarea>
		@error('descripton')<span style="color: red;font-style: italic;">{{ $message}}</span>@enderror

	</div>
	<div class="form-group">
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-lg">Post</button>
		</div>
	</div>
	</form>
@endsection

@push('scripts')
<script>
  $('#descripton').summernote();
</script>
@endpush
