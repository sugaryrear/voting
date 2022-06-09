<?php
	if ($_SERVER['REQUEST_METHOD'] != "POST" 
			|| !isset($_POST['url']) 
			|| $_POST['url'] != $_SERVER['HTTP_REFERER']) {
		exit;
	}
?>

<form class="vote">
	<div class="input-group">
    	<input class="form-control" name="username" id="username" placeholder="Username">
    	<span class="input-group-btn">
      		<button type="submit" class="btn btn-success btn-block">Continue <i class="fa fa-arrow-circle-right"></i></button>
    	</span>
  	</div>
</form>