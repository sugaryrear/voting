<?php
	if (count(get_included_files()) <= 1)
		exit;

	$error = null;
	$success = null;

	if (isset($_GET['action']) && $_GET['action'] == "logout") {
			clearCookies();
			header("location: admin.php");
	} else if (isset($_GET['action']) && $_GET['action'] == "add") {
		if (isset($_POST['title']) && isset($_POST['site_id']) && isset($_POST['url'])) {
			$title = $_POST['title'];
			$site_id = $_POST['site_id'];
			$url = filter_var($_POST['url'], FILTER_SANITIZE_URL);

			if (strlen($title) < 3 || strlen($title) > 25) {
				$error = "Title must be between 3 and 25 characters.";
			} else if (strlen($site_id) < 1 || strlen($site_id) > 25) {
				$error = "Site id must be between 1 and 25 characters.";
			} else if (!filter_var($url, FILTER_VALIDATE_URL)) {
				$error = "Please specify a valid vote url.";
			} else {
				$db->insert("sites", array(
					'title' => $title,
					'site_id' => $site_id,
					'url' => $url
				));
				header("location: admin.php");
				exit;
			}
		}
	} else if (isset($_GET['action']) && isset($_GET['id'])) {
		$site = $db->getSiteBy("id", cleanString($_GET['id']));

		if ($site == null) {
			header("location: admin.php");
			exit;
		}

		if ($_GET['action'] == "delete" && isset($_GET['confirm']) && $_GET['confirm'] == "yes") {
			$db->deleteSite($site['id']);
			header("location: admin.php");
			exit;
		}

		if ($_GET['action'] == "deactivate") {
			$db->setActive($site['id'], 0);
			header("location: admin.php");
			exit;
		}

		if ($_GET['action'] == "activate") {
			$db->setActive($site['id'], 1);
			header("location: admin.php");
			exit;
		}

		if ($_GET['action'] == "edit") {
			if (isset($_POST['title']) && isset($_POST['site_id']) && isset($_POST['url'])) {
				$title = $_POST['title'];
				$site_id = $_POST['site_id'];
				$url = filter_var($_POST['url'], FILTER_SANITIZE_URL);

				if (strlen($title) < 3 || strlen($title) > 25) {
					$error = "Title must be between 3 and 25 characters.";
				} else if (strlen($site_id) < 1 || strlen($site_id) > 25) {
					$error = "Site id must be between 1 and 25 characters.";
				} else if (!filter_var($url, FILTER_VALIDATE_URL)) {
					$error = "Please specify a valid vote url.";
				} else {
					$db->updateSite($site['id'], $title, $site_id, $url);
					$success = "Your changes have been saved!";
				}
			}
		}
	}

?>
