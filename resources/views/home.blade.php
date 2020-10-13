@extends('layout.master')
@section('content')
 <div class="container">
		<div class="row">
			<!-- Blog Entries Column -->
			<div class="col-md-8">

				<h1 class="my-4">
					<p class="lead" style="text-align: center;"><b>All Nice Post Here!</b></p>
				</h1>

				<!-- Blog Post -->
				<div id="live-search">
					@forelse($posts as $post)
				<div class="card mb-4" id="post{{ $post->id }}">
					<img class="card-img-top img-fluid" src="{{ asset('upload/' . $post->files) }}" alt="Card image cap">
					<div class="card-body">
						<h2 class="card-title">{{ $post->title }}</h2>
						<p class="card-text" id="shortContent{{ $post->id }}">{{ Str::limit(strip_tags($post->descripton), 100) }}</p>
						<p class="card-text" id="fullContent{{ $post->id }}" style="display: none;">{{ strip_tags($post->descripton) }}</p>
						<button data-post-id="{{ $post->id }}" class="more btn btn-primary">Read More &rarr;</button>
						<button data-post-id="{{ $post->id }}" class="commentBtn btn btn-primary"><i class="fa fa-edit" aria-hidden="true"></i><span style="margin-left: 5px;">{{ $post->comments->count() }}</span></button>
					</div>
					<div class="card-footer text-muted">
						Posted on {{ $post->created_at->diffForHumans() .' | '. $post->created_at->format('F d, Y') }} by
						<a href="#">{{ $post->user->name }}</a>
						<small style="color: green">{{ $post->Category->category }}</small>
					</div>
					<!-- For Comment -->
					<div class="card-body" id="commentBtn{{ $post->id }}" style="display: none;">
						<form action="{{ route('comments.store') }}"  method="POST">
							@csrf
							@if(auth()->check())
								<input type="hidden" name="post_id" value="{{ $post->id }}">
								<input type="hidden" name="user_id" value="{{ auth()->id() }}">
							@endif
							<textarea rows="4" class="form-control mb-2" name="content" spellcheck="false"></textarea>
							@if(auth()->check())
									<button class="btn btn-primary btn-sm mr-2" type="submit">Add Reply</button>
							 @else
									<a class="btn btn-primary btn-sm mr-2" href="{{ route('users.create') }}">Add Reply</a>
							 @endif
						</form>
					</div>
					<!-- All comment show! -->
					<div id="commentsShow{{ $post->id }}" style="display: none;">
						@foreach($post->comments as $comment)
							<div class="card-header d-flex justify-content-between">
								<div class="mr-2 text-dark">
									{{ $comment->user->name  }}
									<div class="text-xs text-muted"> {{ $comment->created_at->diffForHumans() }}</div>
								</div>
							</div>
							<div class="card-body">
								{{ $comment->content }}
							</div>
						@endforeach
					</div>
				</div>
			@empty
				<h4 class="alert alert-danger" style="text-align: center;">No posts yet!</h4>
					@endforelse
		</div>
				<!-- Pagination -->
				<ul class="pagination justify-content-center mb-4">
				 <li class="page-item">
					{{ $posts->links() }}
					</li>
				</ul>
			</div>

			<!-- Sidebar Widgets Column -->
			<div class="col-md-4">
				<!-- Search Widget -->
				<div class="card my-4">
					<h5 class="card-header">Search</h5>
					<div class="card-body">
						<div class="input-group">
							<input type="text" class="form-control" id="searchPost" placeholder="Type your keyword.......">
						</div>
					</div>
				</div>
				<!-- Categories Widget -->
	           <div class="card my-4">
					<h5 class="card-header">Categories</h5>
					<div class="card-body">
						<div class="row">
						@foreach($categories as $category)
							<div class="col-lg-6">
								<ul class="list-unstyled mb-0">
									<li>
										<a style="text-decoration: none;" href="{{ route('home') }}?cat_id={{ $category->id }}">{{ $category->category }}<span> ({{ $category->posts->count() }})</span></a>
									</li>
								</ul>
							</div>
						 @endforeach
						</div>
					</div>
				</div>
				<!-- Side Widget -->
				<div class="card my-4">
					<h5 class="card-header">Side Widget</h5>
					<div class="card-body">
						You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
					</div>
				</div>
				<div class="card my-4">
					<h5 class="card-header">Post Archive</h5>
					<div class="card-body">
						@foreach($posts as $post)
						<div class="row">
							<div class="col-lg-8">
								<ul class="list-unstyled mb-0">
                                    <li><a style="text-decoration: none; cursor: pointer;" href="{{ route('home') }}?created_at={{ $post->created_at }} ">{{ $post->created_at->format('F d, Y') }}</a></li>
								</ul>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>

		</div>
		<!-- /.row -->

	</div>
	<!-- /.container -->
	<!-- Footer -->
	<footer class="py-5 bg-dark">
		<div class="container">
			<p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
		</div>
		<!-- /.container -->
		<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>
	</footer>
@endsection
@push('styles')
<style>
	html {
  scroll-behavior: smooth;
}
#myBtn {
	  display: none;
	  position: fixed;
	  bottom: 20px;
	  right: 30px;
	  z-index: 99;
	  font-size: 18px;
	  border: none;
	  outline: none;
	  background-color: F;
	  color: #282923;
	  cursor: pointer;
	  padding: 15px;
	  border-radius: 4px;
}

#myBtn:hover {
  background-color: #555;
}
</style>
@endpush
@push('scripts')
<!-- Script for content show and hide ,comment show,replay button show and scrol top -->
<script>
$( ".more" ).click(function() {
	let postID = $(this).attr('data-post-id');
	$( "#shortContent" + postID ).toggle();
	$( "#fullContent" + postID ).toggle();
	$( "#commentsShow" + postID ).toggle();
});

$( ".commentBtn" ).click(function() {
	let postID = $(this).attr('data-post-id');
	$( "#commentBtn" + postID ).toggle();

});
var mybutton = document.getElementById("myBtn");
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
  if (document.body.scrollTop > 20|| document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>
<!-- Script for live search based on post title -->
<script>
	$('body').on('keyup','#searchPost', function(){
		let searchContent = $(this).val();
		/*fetch('{{ route("searchPost") }}?searchContent=' +  searchContent).then(response => {
			return response.json()
		}).then(data => {
			$('#live-search').html('');
			if (data) {
				$('#live-search').append(data);
			}else{
				$('#live-search').append(`<h4 class="alert alert-danger" style="text-align: center;">No posts for "${searchContent}"!</h4>`);
			}
		})*/

		$.ajax({
						url         : '{{ route("searchPost") }}',
						type        : "GET",
						data        : {
							searchContent
						},
						"beforeSend" : function(){

						},
						"success"    : function(data){
							$('#live-search').html('');
				            if (data) {
					            $('#live-search').append(data);
				            }else{
					            $('#live-search').append(`<h4 class="alert alert-danger" style="text-align: center;">No posts for "${searchContent}"!</h4>`);
				            }
						},
						"error" : function(){

						}
				});

	});
</script>
@endpush
