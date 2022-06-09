<?php
	include 'constants.php';
	include 'classes/class.database.php';

	$db = new Database(db_host, db_user, db_pass, db_data);

	if (!$db->connect()) {
		exit;
	}

	foreach ($_REQUEST as $key => $value) {
		$result = preg_match('/^[a-zA-Z0-9_]+$/', $value, $data);

		if ($result === false || $result == 0) {
			continue;
		}

		$uid = cleanString($value);
		$vote = $db->getVoteByUid($uid);

		if ($vote == null) {
			error_log(date('[Y-m-d H:i e]'). " Could not locate vote with key $value" . PHP_EOL, 3, "logs.txt");
			continue;
		}

		$db->insertVote($uid);

		error_log(date('[Y-m-d H:i e]'). " Completed vote with key $value" . PHP_EOL, 3, "logs.txt");
	}

?>
