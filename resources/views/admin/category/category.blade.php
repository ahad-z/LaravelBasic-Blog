<div class="modal fade" id="addcategory">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Category</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-group" method="POST" action="{{route('categories.store')}}">
					@csrf
					<div class="form-group">
						<label for="category">Category Name</label>
						<input type="text" class="form-control" id="category" name="category" required="">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
