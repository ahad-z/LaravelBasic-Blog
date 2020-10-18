@extends('backend.layouts.master')
@section('title')
	Edit Role-Admin Pannel
@endsection
@push('styles')

@endpush
@section('admin-content')
	<div class="page-title-area">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="breadcrumbs-area clearfix">
					<h4 class="page-title pull-left">Roles</h4>
					<ul class="breadcrumbs pull-left">
						<li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
						<li><a href="{{ route('roles.index') }}">All Roles</a></li>
						<li><span>Edit roles</span></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-6 clearfix">
				@include('backend.layouts.partials.logout')
			</div>
		</div>
	</div>
	<!-- page title area end -->
	<div class="main-content-inner" >
		<div class="row">
			<div class="col-12 mt-5" >
				<div class="card" id="app">
					<div class="card-body">
						<h4 class="header-title">Edit Your Roles {{ $role->name }}</h4>
						<div class="col-12 mt-5">
							<div class="card">
								<div class="card-body">
									<h4 class="header-title">Editform</h4>
									<form action="{{ route('roles.update', $role->id) }}" method="POST">
										 <input type="hidden" name="_method" value="PUT">
										  <input type="hidden" name="_token" value="{{ csrf_token() }}">
										<div class="form-group">
											<label for="role">Role</label>
											<input type="text" class="form-control" id="role" value="{{ $role->name }}"  placeholder="Enter role" name="role">
										</div>
										<div class="form-group">
							
											<label for="name">Permission</label>
											<div class="form-check">
												<input type="checkbox" class="form-check-input all-checkbox" name="" id="checkPermissionAll">
												<label class="form-check-label" for="checkPermissionAll">All</label>
											</div>

										    <hr>
											@foreach($groups as $groupName => $permissions)
												<div class="row">
													<div class=" col-9">
													<div class="form-check">
															<input type="checkbox" class="form-check-input permission-group-checkbox" id="{{ $groupName }}-checkbox" data-group-name="{{ $groupName }}" onclick="checkPermissionByGroup('{{ $groupName }}', this)" {{ $role->permissions->where('group_name', $groupName)->count() === count($permissions) ? 'checked' : '' }}>
															<label class="form-check-label" for="checkPermission">{{ ucfirst($groupName) }}</label>
														</div>
													</div>
													<div class="col-3">
														@foreach($permissions as $permission)
															<div class="form-check">
																<input type="checkbox" {{ $role->hasPermissionTo($permission) ? 'checked' : '' }} class="form-check-input {{ $groupName }} permission-checkbox" data-group-name="{{ $groupName }}" name="permissions[{{ $permission->id }}]" id="permission{{ $permission->id }}" >
																<label class="form-check-label" for="permission{{ $permission->id }}">{{ ucfirst(explode('.', $permission['name'])[1]) }}</label>
															</div>
														@endforeach
													</div>
												</div>
												<hr>
											@endforeach
										</div>
										<button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	@include('backend.pages.roles.script')
@endpush

