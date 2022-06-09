<?php
	if (count(get_included_files()) <= 1)
		exit;

	$title = defined("page_title") ? page_title : vote_title;
?>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/stylesheet.css">
	<link rel="icon" type="image/png" href="assets/img/favicon.png">
</head>
