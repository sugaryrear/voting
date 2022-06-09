<?php
	if (count(get_included_files()) <= 1)
		exit;

	$site = $db->getSiteBy("id", cleanString($_GET['id']));
?>

<div class="col-md-4 col-md-offset-4 box text-center">
	<h2>Admin</h2>
	<p>Delete Site: <?php echo ($site == null ? "<strong>Unknown</strong>" : '<strong>'.$site['title'].'</strong>'); ?></p>
	<hr>
	<?php
		if ($site == null) {
			echo '<div class="alert alert-danger">No such vote site exists by that id</div>';
		} else {
	?>

	<h3>Are you sure?</h3>
	<p><small>This will permanently delete <?php echo $site['title']; ?>, and the information can not be recovered.</small></p>

	<a class="btn btn-link" href="?action=delete&amp;id=<?php echo $site['id']; ?>&amp;confirm=yes"><i class="fa fa-check"></i> Yes</a>
	<a class="btn btn-link" href="admin.php"><i class="fa fa-times"></i> No</a>
	<?php } ?>
</div>
