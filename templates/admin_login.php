<?php
	if (count(get_included_files()) <= 1)
		exit;
?>

<div class="col-md-4 col-md-offset-4 box">

<h2 class="text-center">ACP</h2>
<p class="text-center">Please login using the form below</p>

<hr>

<?php
	if ($error != null) {
		echo '<p class="text-danger text-center">'.$error.'</p>';
	}
?>

<form action="admin.php" method="post">
	<div class="form-group">
		<label>Username</label>
		<input type="text" name="username" class="form-control">
	</div>
	<div class="form-group">
		<label>Password</label>
		<input type="password" name="password" class="form-control">
	</div>
	<div class="checkbox">
		<label>
			<input type="checkbox" name="remember"> Remember Me
		</label>
    </div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary btn-block">Sign In</button>
	</div>
</form>

</div>
