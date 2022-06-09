<?php
	include 'constants.php';
	include 'classes/class.database.php';
	include 'user_handler.php';

	define("page_title", vote_title.' Admin');

    $db = new Database(db_host, db_user, db_pass, db_data);
    if (!$db->connect())
    	exit;

	include 'admin_process.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'templates/head.php'; ?>
<body>

	<div class="container">
		<?php
			if (!$loggedIn) {
				include 'templates/admin_login.php';
			} else {
				if (isset($_GET['action'])) {
					$action = cleanString($_GET['action']);
					if ($action == "edit" && isset($_GET['id'])) {
						include 'templates/edit_site.php';
					} else if ($action == "add") {
						include 'templates/add_site.php';
					} else if ($action == "delete" && isset($_GET['id'])) {
						include 'templates/delete_site.php';
					}
				} else {
					include 'templates/site_list.php';
				}
			}
			include 'templates/footer.php';
		?>
	</div>
</body>
<?php include 'templates/scripts.php'; ?>
</html>
