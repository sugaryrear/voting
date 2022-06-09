<?php
	require '../classes/phplot.php';
	include '../constants.php';
	include '../classes/class.database.php';

	$db = new Database(db_host, db_user, db_pass, db_data);

    if (!$db->connect())
    	exit;

	$plot = new PHPlot(920, 300);
	$plot->SetTransparentColor('white');
	$plot->SetTitle('Votes for '.date('Y').'');

	if (isset($_REQUEST['type'])) {
		$plot->setPlotType($_REQUEST['type']);
	}

	$stats = $db->getVoteStats();

	$data = array(
		array('Jan', 0),
		array('Feb', 0),
		array('Mar', 0),
		array('Apr', 0),
		array('May', 0),
		array('June', 0),
		array('July', 0),
		array('Aug', 0),
		array('Sep', 0),
		array('Oct', 0),
		array('Nov', 0),
		array('Dec', 0),
	 );

	foreach ($stats as $stat) {
		$monthId = $stat['month'];
		$data[$monthId - 1][1]= $stat['amount'];
	}

	$plot->SetDataValues($data);
	$plot->DrawGraph();
?>
