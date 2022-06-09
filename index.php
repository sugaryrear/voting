<?php
	include 'constants.php';
	include 'classes/class.database.php';

    $db = new Database(db_host, db_user, db_pass, db_data);

    if (!$db->connect())
    	exit;
?>
<!DOCTYPE html>
<html lang="en">
	<?php include 'templates/head.php'; ?>
<body>
	<div class="container">
        <div class="col-md-8 col-md-offset-2 box text-center">

        	<h3>Vote for <?php echo vote_title; ?>!</h3>
        	<p>Help our community by voting on the sites below!<br>
        		You will be rewarded per vote!</p>

        	<p id="error" class="text-danger"></p>
        	<div id="step"></div>
        	<hr>
        	<div id="stats"></div>
			<div class="row">
				<div class="col-xs-12">
					<hr>
					<a href="stats.php" target="_blank">View Graphs</a> &bull; <a href="admin.php" target="_blank">Admin</a>
				</div>
			</div>
		</div>
	 	<?php include 'templates/footer.php'; ?>
	</div>
</body>
<?php include 'templates/scripts.php'; ?>
</html>
