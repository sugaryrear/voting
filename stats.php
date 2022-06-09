<?php
	include 'constants.php';
	include 'classes/class.database.php';

    $db = new Database(db_host, db_user, db_pass, db_data);

    if (!$db->connect())
    	exit;

	define("page_title", vote_title.' Statistics');
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'templates/head.php'; ?>
<body>

	<div class="container">
		<?php include 'templates/stats_page.php'; ?>

	 	<div class="col-md-6 col-md-offset-3 footer text-center">
			Copyright &copy; 20w22 Sugary.
		</div>
	</div>
</body>

<?php include 'templates/scripts.php'; ?>
<script type="text/javascript">

$(document).ready(function() {

	$('#graph').html("<img src='templates/graph.php?type=bars'>");

	$(document).on("click", "#chart", function(e) {
		var btn = $(this);
		e.preventDefault();

		$('#graph').fadeOut(function() {
			$('#graph').html("<img src='templates/graph.php?type="+btn.data("type")+"'>");
			$('#graph').fadeIn();
		});
	});
});

</script>
</html>
