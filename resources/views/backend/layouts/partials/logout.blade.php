<div class="user-profile pull-right">
	<img class="avatar user-thumb" src="{{ asset('backend/assets/images/author/avatar.png')}}" alt="avatar">
	<h4 class="user-name dropdown-toggle" data-toggle="dropdown">
		@if(auth()->check())
		 <span style="font-weight: bold;">{{ auth()->user()->name}}</span>
		@endif

		<i class="fa fa-angle-down"></i></h4>
	<div class="dropdown-menu">
		<a class="dropdown-item" href="{{route('users.logout')}}">Log Out</a>
	</div>
</div>
