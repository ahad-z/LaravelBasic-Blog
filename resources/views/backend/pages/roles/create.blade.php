@extends('backend.layouts.master')
@section('title')
	Create Role-Admin Pannel
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
						<li><span>All roles</span></li>
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
						<h4 class="header-title">Create Your Roles</h4>
						<div class="col-12 mt-5">
							<div class="card">
								<div class="card-body">
									<h4 class="header-title">Basic form</h4>
									<form action="" method="POST" class="creteRoleForm">
										<div class="form-group">
											<label for="role">Role</label>
											<input type="text" class="form-control" id="role"  placeholder="Enter role" name="role">
										</div>
										<div class="form-group">
											<label for="name">Permission</label>
											<div class="form-check">
												<input type="checkbox" class="form-check-input" name="" id="checkPermissionAll" >
												<label class="form-check-label" for="checkPermissionAll">All</label>
											</div>
										    <hr>
											@foreach($groups as $groupName => $permissions)
												<div class="row">
													<div class=" col-9">
														<div class="form-check">
															<input type="checkbox" class="form-check-input" onclick="checkPermissionByGroup('{{ $groupName }}', this)">
															<label class="form-check-label" for="checkPermission"
															>{{ ucfirst($groupName) }}</label>
														</div>
													</div>

													<div class="col-3">
														@foreach($permissions as $permission)
															<div class="form-check">
																<input type="checkbox" class="form-check-input {{ $groupName }}" name="permissions[{{ $permission->id }}]" id="permission{{ $permission->id }}" >
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

	<script>
		$(".creteRoleForm").submit(function(e){
			e.preventDefault();
			 let data = $(this).serialize();
			$.ajax({
				url :"{{ route('roles.store') }}" ,
				type:'POST',
				data:data,
				success:function(response){


					if(response.status){
						$('input[type=checkbox]').prop('checked', false);
						$("#role").val('');
						const Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.addEventListener('mouseenter', Swal.stopTimer)
								toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						})

						Toast.fire({
							icon: 'success',
							title: 'Role create successfully!'
						})
					}else{
						const Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.addEventListener('mouseenter', Swal.stopTimer)
								toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						})

						Toast.fire({
							icon: 'warning',
							title: response.message
						})
					}
				},
				error:function(error){
					console.log(error)
				}
			});
		});

		$("#checkPermissionAll").click(function (){
			if($(this).is(':checked')){
				$('input[type=checkbox]').prop('checked', true);
			}else{
				$('input[type=checkbox]').prop('checked', false);
			}
		});

		function checkPermissionByGroup(groupName, groupCheckbox){
			if($(groupCheckbox).is(':checked')) {
				$(`input.${groupName}`).prop('checked', true);
			} else {
				$(`input.${groupName}`).prop('checked', false);
			}

		}

	</script>
@endpush

