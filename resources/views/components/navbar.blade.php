<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
			<a class="navbar-brand" href="{{route('home')}}">Basic Recap</a>
			<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
				@if(auth()->check())
					@if(auth()->user()->hasRole('Users'))
						<li class="nav-item"><a class="nav-link" href="{{route('posts.index')}}">Add post</a></li>
						<li class="nav-item"><a href="{{route('posts.adminPosts')}}" class="nav-link">All posts</a></li>
				    @endif

					@if(auth()->user()->hasRole('Admin'))
						<li class="nav-item"><a class="nav-link" href="{{route('users.usersIndex')}}">Users</a></li>
						<li class="nav-item"><a href="{{route('categories.index')}}" class="nav-link">Category</a></li>
					@endif
						
					<li class="nav-item"><a class="nav-link" href="{{route('users.logout')}}">LogOut</a></li>
				@else
					<li class="nav-item"><a class="nav-link" href="{{route('users.create')}}">Login</a></li>
					<li class="nav-item"><a class="nav-link" href="{{route('users.index')}}">Register</a></li>
				@endif
			</ul>
		</div>
	</div>
</nav>
