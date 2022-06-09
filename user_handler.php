<?php
	if (count(get_included_files()) <= 1)
		exit;

	$loggedIn = false;
	$error = null;

	if (isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['ip_address'])) {
		if ($_COOKIE['username'] != admin_user || !password_verify(admin_pass, $_COOKIE['password'])) {
			clearCookies();
			header("location:admin.php");
			exit;
		}
		if ($_COOKIE['ip_address'] != $_SERVER['REMOTE_ADDR']) {
			clearCookies();
			header("location:admin.php");
			exit;
		}
		$loggedIn = true;
	}

	if (!$loggedIn && isset($_POST['username']) && isset($_POST['password'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		if ($username != admin_user) {
			$error = "Invalid Username.";
		} else if ($password != admin_pass) {
			$error = "Invalid Password.";
		} else {
			$time = strtotime('+3 days');

			if (isset($_POST['remember']) && $_POST['remember'] == "on") {
				$time = strtotime('+30 days');
			}

			$hash = password_hash(admin_pass, PASSWORD_BCRYPT);

			setcookie("username", admin_user, $time, '');
			setcookie("password", $hash, $time, '');
			setcookie("ip_address", $_SERVER['REMOTE_ADDR'], $time, '');
			header("location:admin.php");
			exit;
		}
	}

?>
