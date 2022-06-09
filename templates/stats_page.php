<?php
	if (count(get_included_files()) <= 1)
		exit;

	$baseUrl =  'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$baseUrl = substr($baseUrl, 0, strrpos($baseUrl, '/', -3)).'/callback.php';
?>

<div class="col-md-10 col-md-offset-1 box">
	<h2 class="text-center"><?php echo vote_title; ?> Statistcs</h2>
	<p class="text-center">Per month vote stats</p>
	<hr>
	<a href="#" class="btn btn-sm btn-primary" id="chart" data-type="bars"><i class="fa fa-bar-chart-o"></i> Bar Chart</a>
	<a href="#" class="btn btn-sm btn-primary" id="chart" data-type="linepoints"><i class="fa fa-line-chart"></i> Line Chart</a>
	<a href="#" class="btn btn-sm btn-primary" id="chart" data-type="area"><i class="fa fa-area-chart"></i> Area Chart</a>

	<div id="graph" style="min-height:330px;"></div>
	<div class="text-center"><a href="index.php" class="btn btn-link">Return Home</a></div>
</div>
