<div class="row">
	<div class="col-md-12 mt-5">
		<?php if ($this->session->flashdata('success')) { ?>
			<div class="alert alert-success col-md-12">
				<?php echo $this->session->flashdata('success'); ?>
			</div>
		<?php } ?>
	</div>
	<div class="col-md-12  mt-5">
		<h1 class="text-center">Posts</h1>
		<button type="button" class="btn btn-primary mb-5 showModal">
			Create new Post
		</button>
	</div>
	<div class="col-12">
		<table id="table" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>No</th>
					<th>Title</th>
					<th>Description</th>
					<th>Content</th>
					<th>Status</th>
					<th>Option</th>

				</tr>
			</thead>
			<tbody>
			</tbody>
			<tfoot>
				<tr>
					<th>No</th>
					<th>Title</th>
					<th>Description</th>
					<th>Content</th>
					<th>Status</th>
					<th>City</th>

				</tr>
			</tfoot>
		</table>
	</div>
</div>

<div class="modal fade" id="modalProject" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style="padding:35px 50px;">
				<!-- title -->
				<h3 class="title_header">Thêm project</h3>
			</div>
			<div class="modal-body" style="padding:40px 50px;">
			
				<form action="" method="POST" id="form">
					<input type="hidden" name="id">
					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" name="title" id="title" class="form-control" placeholder="Title">
						
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<input type="text" name="description" id="description" class="form-control" placeholder="Description">
						
					</div>
					<div class="form-group">
						<label for="content">Content</label>
						<textarea name="content" id="content" class="form-control" placeholder="Content"></textarea>
						
					</div>
					<div class="form-group">
						<label for="is_status">Status</label>
						<select style="height:35px" name="is_status" id="is_status" class="form-control select">
							<option value="" selected>option</option>
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
						
					</div>
					<div class="form-group mt-5">
					<button type="submit" id="submit" class="btn btn-primary">Save Post</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>

