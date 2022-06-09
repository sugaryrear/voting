<?php
	if ($_GET['site'] != 0 && (!isset($_GET['site']) || empty($_GET['site']))) {
		header("location: index.php");
		exit;
	}

	if (!is_int(filter_input(INPUT_GET, 'site', FILTER_VALIDATE_INT))) {
		header("location: index.php");
		exit;
	}

	include 'constants.php';
	include 'classes/class.database.php';

	if (!isset($_COOKIE['vote_user']) || empty($_COOKIE['vote_user']) || strlen($_COOKIE['vote_user']) < 3 || strlen($_COOKIE['vote_user']) > 15) {
		header("location: index.php");
		exit;
	}

	$db = new Database(db_host, db_user, db_pass, db_data);

	if (!$db->connect())
		exit;

	$siteId = cleanInt($_GET['site']);
	$site = $db->getSite($siteId);

	if ($site == null) {
		exit;
	}

	$username = preg_replace("/[^A-Za-z0-9_]/", '_', $_COOKIE["vote_user"]);
	$recent = $db->getMostRecentVote($siteId, $username, $_SERVER['REMOTE_ADDR']);

	$uid = $recent == null ? substr(md5(strtotime('now') + uniqid()), 0, 15) : $recent['uid'];

	$url = str_replace("{sid}", $site['site_id'], $site['url']);
	$url = str_replace("{incentive}", $uid, $url);

	if ($recent == null) {
		error_log(date('[Y-m-d H:i e]')." Started vote for $username, $siteId" . PHP_EOL, 3, "logs.txt");
		$db->startVote($siteId, $username, $_SERVER['REMOTE_ADDR'], $uid);
	} else {
		error_log(date('[Y-m-d H:i e]')." Vote found: ".json_encode($recent)."" . PHP_EOL, 3, "logs.txt");
	}

	header("location: ".$url);
	exit;
?>
