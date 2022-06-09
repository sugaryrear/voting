<?php
	if ($_SERVER['REQUEST_METHOD'] != "POST"
			|| !isset($_POST['url'])
			|| $_POST['url'] != $_SERVER['HTTP_REFERER']) {
		exit;
	}

	include '../../constants.php';
	include '../../classes/class.database.php';

	$db = new Database(db_host, db_user, db_pass, db_data);

	if (!$db->connect())
		exit;

	if (!isset($_COOKIE['vote_user'])) {
		exit;
	}

	$username = filter_var($_COOKIE["vote_user"], FILTER_SANITIZE_STRING);
	$username = preg_replace("/[^A-Za-z0-9_]/", '_', $username);
	
	$sites = $db->getSites();

	if ($sites == null) {
		echo '<div class="alert alert-danger">There are no sites to vote on!</div>';
		exit;
	}

	foreach ($sites as $site) {
		if ($site['active'] == false) {
			continue;
		}

		$url = str_replace("{sid}", $site['site_id'], $site['url']);
		$url = str_replace("{incentive}", str_replace(" ", "_", $username), $url);

		$vote = $db->getVote($site['id'], $username, $_SERVER['REMOTE_ADDR']);

		if ($vote == null) {
			echo '<a class="btn btn-default site" target="_blank" href="vote.php?site='.$site['id'].'">'.$site['title'].'</a>';
		} else {
			$time = time(true) - strtotime($vote['callback_date']);
			$timeDiff = 43200 - $time;

			echo '<a class="btn btn-success site" target="_blank" href="#"><i class="fa fa-check"></i> '.formatSeconds($timeDiff).'</a>';
		}
	}
?>

<hr style="border-color:transparent;">
Voting as <strong><?php echo str_replace("_", " ", $username); ?></strong>
