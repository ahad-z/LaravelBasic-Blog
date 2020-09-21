@extends('layout.master')
@section('content')
<!-- Search Widget -->
<div class="card my-4">
	<h5 class="card-header">Search</h5>
	<div class="card-body">
		<div class="input-group">
			<input type="text" class="form-control" id="searchPost" placeholder="Type your keyword.......">
		</div>
	</div>
</div>
<table class="table">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Title</th>
			<th scope="col">Post Content</th>
			<th scope="col">Posted By</th>
			<th scope="col">Added Time</th>
			<th scope="col">status</th>
			<th scope="col">Acction</th>
		</tr>
	</thead>
	<tbody id="live-search">
		@forelse($posts as $post)
		<tr>
			<th scope="row">{{ $loop->iteration }}</th>
			<td>{{ $post->title }}</td>
			<td>
				<img style="height:100px;width: 100px;" class="card-img-top rounded-circle" src="{{ asset('upload/' . $post->files) }}" alt="Card image cap">
				{{ strip_tags($post->descripton) }}
			</td>
			<td>{{ $post->title }}</td>
			<td>{{ $post->created_at->diffForHumans() }}</td>
			<td>
				<input class="postStatus" type="checkbox" data-toggle="toggle" data-on="Approve" data-off="UnApprove" data-id="{{ $post->id }}" {{$post->status==1? 'checked' : ''}}>
			</td>
			<td>
				<form method="POST" action="{{ route('posts.destroy',$post->id) }}">
					@method('DELETE')
					@csrf
				   <button onclick="return confirm('Are u sure!')" href="" class="btn btn-danger btn-sm">Delete</button>
				</form>
			</td>
		</tr>
		@empty
		<tr>
			<td colspan="7" class="text-center">
				<h1>NO SHIT HERE</h1>
			</td>
		</tr>
		@endforelse
		<td colspan="7" class="text-right">
		<tr>{{ $posts->links() }}</tr>
	</td>
</tbody>
</table>
@endsection
@push('scripts')
<script>
	$('body').on('change', '.postStatus', function() {
	    var id = $(this).attr('data-id');
	    if (this.checked) {
	        var status = 1;
	     }else {
	        var status = 0;
	    }
	        $.ajax({
	            url         : `postStatus/${id}/${status}`,
	            type        : "GET",
	            dataType    : "JSON",
	            "beforeSend" : function(){

	            },
	            "success"    : function(data){
	            	if(data.status === true) {
						toastr.success('Post Approval successfully')
	            	}else{
	            		toastr.danger('Post not Approved')
	            	}
	            },
	            "error"         : function(){

	            }
	        });
	    });
</script>
<!--  for Search -->
<script>
	$('body').on('keyup','#searchPost', function(){
		let searchContent = $(this).val();
		fetch('{{ route("adminSearchPost") }}?searchContent=' +  searchContent).then(response => {
			return response.json()
		}).then(data => {
			$('#live-search').html('');
			if (data) {
				$('#live-search').append(data);
			}else{
				$('#live-search').append(`<tr>
					<td colspan="7" class="text-center">
						<div class="alert alert-danger"><h1>NO SHIT HERE FOR ${searchContent}</h1></div>
					</td>
				</tr>`);
			}
		})
	})
</script>
@endpush

