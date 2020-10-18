@extends('backend.layouts.master')
@section('title')
	All roles -Admin Pannel
@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
	<style>
		div.dataTables_wrapper div.dataTables_length select {
			width: 76px;
			margin: 0 10px;
		}

		/* datatable-primary */

		.datatable-primary thead {
			background: #4336fb;
			color: #fff;
		}

		.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
			border: none;
			background: transparent;
		}

		.dataTables_wrapper .dataTables_paginate .paginate_button {
			padding: 0;
			border: none;
			margin-top: 20px;
		}

		table.dataTable.no-footer {
			border-bottom: 1px solid rgba(120, 130, 140, 0.13) !important;
		}

		table.dataTable thead th,
		table.dataTable thead td {
			border-bottom-color: transparent;
		}

		.datatable-primary .dataTables_paginate .page-item.active .page-link,
		.datatable-primary .dataTables_paginate .page-item .page-link:hover {
			background-color: #4336fb;
			border-color: #4336fb;
			color: #fff;
		}

		.datatable-primary .dataTables_paginate .page-link {
			color: #4336fb;
			border: 1px solid #4336fb;
		}

		.datatable-primary .dataTables_paginate .paginate_button.disabled,
		.datatable-primary .dataTables_paginate .paginate_button.disabled:hover,
		.datatable-primary .dataTables_paginate .paginate_button.disabled:active {
			color: #4336fb!important;
			border: none;
		}

		.datatable-primary .dataTables_paginate .page-item.disabled .page-link {
			color: #9f98f7;
			background-color: #f9f9f9;
			border-color: #c9c6f5;
		}

	</style>
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
	<div class="main-content-inner">
		<!-- Dark table start -->
		<div class="col-12 mt-5">
			<div class="card">
				<div class="card-body">
					<h4 class="header-title">Roles List</h4>
					<a style="float: right; " href="{{ route('roles.create') }}" class="btn btn-primary text-white mb-2" >Create Role</a>
					<div class="data-tables datatable-dark">
						<table id="dataTable3" class="text-center">
							<thead class="text-capitalize">
							<tr>
								<th>Sl</th>
								<th>Role Name</th>
								<th width="350px">Permissions</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							@foreach($roles as $role)
							<tr>
								<td>{{ $loop->iteration  }}</td>
								<td>{{ucfirst($role->name)  }}</td>
								<td>
									@foreach($role->permissions as $permission)
										<span class="badge badge-info mr-2" style="font-size:12px;">
											 {{ucfirst($permission->name)}}
										</span>
								    @endforeach
								</td>
								<td>
									<div class="btn btn-group">
										<a href="{{ route('roles.edit',$role->id ) }}" class="btn btn-success" >Edit</a>
										<button onclick="document.getElementById('deleteRole{{ $role->id }}').submit()" class="btn btn-danger">Delete</button>
										<form method="post" action="{{ route('roles.destroy', $role->id) }}" id="deleteRole{{ $role->id }}">
											@method('DELETE')
											@csrf
										</form>
									</div>
								</td>
							</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- Dark table end -->
	</div>
@endsection

@push('scripts')
<!-- Start datatable js -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
	<script>
		/*================================
   datatable active
   ==================================*/
		if ($('#dataTable').length) {
			$('#dataTable').DataTable({
				responsive: true
			});
		}
		if ($('#dataTable2').length) {
			$('#dataTable2').DataTable({
				responsive: true
			});
		}
		if ($('#dataTable3').length) {
			$('#dataTable3').DataTable({
				responsive: true
			});
		}
	
	</script>
@endpush
