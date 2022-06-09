<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	define("vote_title", "Sugary");

	define("db_host", "localhost");
	define("db_user", "root");
	define("db_pass", "");
	define("db_data", "vote");

	define("admin_user", "admin");
	define("admin_pass", "admin");

	function getPage() {
		return basename($_SERVER['PHP_SELF']);
	}

	function formatName($string) {
		return ucwords(str_replace("_", " ", $string));
	}

	function cleanString($string) {
		return preg_replace("/[^A-Za-z0-9_]/", ' ', $string);
	}

	function cleanInt($string) {
		return preg_replace("/[^0-9]/", ' ', $string);
	}

	function clearCookies() {
		setcookie("username", '', time() - 1000);
		setcookie("password", '', time() - 1000);
		setcookie("ip_address", '', time() - 1000);
	}

	function setCookies($username, $password, $ip_address, $time) {
		setcookie("username", $username, $time);
		setcookie("password", $password, $time);
		setcookie("ip_address", $ip_address, $time);
	}

	function isValidIp($address) {
		$parts = explode(".", $address);

		if (count($parts) != 4) {
			return false;
		}

		foreach ($parts as $part) {
			if (!is_numeric($part) || cleanInt($part) == "" || $part < 0 || $part > 255)
				return false;
		}
		return true;
	}

	function formatSeconds($secondsLeft) {
		$minuteInSeconds = 60;
		$hourInSeconds = $minuteInSeconds * 60;
		$dayInSeconds = $hourInSeconds * 24;
		$days = floor($secondsLeft / $dayInSeconds);
		$secondsLeft = $secondsLeft % $dayInSeconds;
		$hours = floor($secondsLeft / $hourInSeconds);
		$secondsLeft = $secondsLeft % $hourInSeconds;
		$minutes= floor($secondsLeft / $minuteInSeconds);
		$seconds = $secondsLeft % $minuteInSeconds;

		$timeComponents = array();

		if ($days > 0)
		$timeComponents[] = $days . "d";
		if ($hours > 0)
		$timeComponents[] = $hours . "h";
		if ($minutes > 0)
		$timeComponents[] = $minutes . "m";
		if ($days == 0 && $hours == 0 && $minutes == 0 && $seconds > 0)
		$timeComponents[] = $seconds . "s";

		if (count($timeComponents) > 0) {
			$formattedTimeRemaining = implode(" ", $timeComponents);
			$formattedTimeRemaining = trim($formattedTimeRemaining);
		} else {
			$formattedTimeRemaining = "No time remaining.";
		}

		return $formattedTimeRemaining;
	}
?>
