<?php
	if (count(get_included_files()) <= 1)
		exit;
?>

<div class="col-md-4 col-md-offset-4 box">
	<h2 class="text-center">Admin</h2>
	<p class="text-center">Add New Site</p>
	<hr>
	<?php
		if ($error != null)
			echo '<div class="alert alert-danger">'.$error.'</div>';
		if ($success != null)
			echo '<div class="alert alert-success"><i class="fa fa-check"></i> '.$success.'</div>';
	?>
	<form action="admin.php?action=add" method="post">
		<div class="form-group">
			<label>Site Title</label>
			<input type="text" class="form-control" name="title">
		</div>
		<div class="form-group">
			<label>Vote Id</label>
			<input type="text" class="form-control" name="site_id">
		</div>
		<div class="form-group">
			<label>Vote Link</label>
			<input type="text" class="form-control" name="url">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
		</div>
		<div class="form-group text-center">
			<a href="admin.php">Return to Admin Index</a>
		</div>
	</form>
</div>
