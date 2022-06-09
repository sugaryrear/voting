<?php
	include '../constants.php';
	include '../classes/class.database.php';

    $db = new Database(db_host, db_user, db_pass, db_data);

    if (!$db->connect())
    	exit;

    $votm = $db->getVotm();
    $votes = $db->getVotes();
?>

<div class="row">
	<div class="col-xs-6">
		<h5>Votes for <?php echo date("F"); ?></h5>
		<h3 style="margin-top:10px;"><?php echo number_format($votes['votes']); ?></h3>
	</div>
    <div class="col-xs-6">
    	<h5>Top Voter for <?php echo date("F"); ?></h5>
		<h3 style="margin-top:10px;"><?php echo str_replace("_", " ", $votm['username']); ?></h3>
    </div>
</div>
