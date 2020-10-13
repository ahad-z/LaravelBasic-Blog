@extends('layout.master')
@section('content')
	<table class="table table-responsive">
		<thead>
			<tr>
				<th>#ID</th>
				<th>File Path</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@forelse($files as $file)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $file->filepath }}</td>
					<td>
						@if($file->status == 'pending')
							<div class="badge badge-warning">{{ ucfirst($file->status) }}</div>
						@elseif($file->status == 'completed')
							<div class="badge badge-success">{{ ucfirst($file->status) }}</div>
						@elseif($file->status == 'running')
							<div class="badge badge-info">{{ ucfirst($file->status) }}</div>
						@elseif($file->status == 'failed')
							<div class="badge badge-danger">{{ ucfirst($file->status) }}</div>
						@endif
					</td>
					<td>
						<a href="{{ route('import.start', $file->id) }}">Import</a>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="5">
						<h5 class="alert alert-danger" style="text-align: center;">There is no record</h5>
					</td>
				</tr>
			@endforelse
		</tbody>
	</table>
@endsection

@push('scripts')
	<script>

	</script>
@endpush

