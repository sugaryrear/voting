<?php
	if (count(get_included_files()) <= 1)
		exit;

	$site = $db->getSiteBy("id", cleanString($_GET['id']));
?>

<div class="col-md-4 col-md-offset-4 box">
	<h2 class="text-center"> Admin</h2>
	<p class="text-center">Edit: <?php echo ($site == null ? "<strong>Unknown</strong>" : '<strong>'.$site['title'].'</strong>'); ?></p>
	<hr>
	<?php
		if ($error != null)
			echo '<div class="alert alert-danger">'.$error.'</div>';
		if ($success != null)
			echo '<div class="alert alert-success"><i class="fa fa-check"></i> '.$success.'</div>';

		if ($site == null) {
			echo '<div class="alert alert-danger">No such vote site exists by that id</div>';
		} else { ?>

		<form action="admin.php?action=edit&amp;id=<?php echo $site['id']; ?>" method="post">
			<div class="form-group">
				<label>Site Title</label>
				<input type="text" class="form-control" name="title" value="<?php echo $site['title']; ?>">
			</div>
			<div class="form-group">
				<label>Vote Id</label>
				<input type="text" class="form-control" name="site_id" value="<?php echo $site['site_id']; ?>">
			</div>
			<div class="form-group">
				<label>Vote Link</label>
				<input type="text" class="form-control" name="url" value="<?php echo $site['url']; ?>">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
			</div>
			<div class="form-group text-center">
				<a href="admin.php">Return to Admin Index</a>
			</div>
		</form>

	<?php } ?>
</div>
