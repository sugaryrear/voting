<?php
	if (count(get_included_files()) <= 1)
		exit;

	$baseUrl =  'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$baseUrl = substr($baseUrl, 0, strrpos($baseUrl, '/', -3)).'/callback.php';
?>

<div class="col-md-10 col-md-offset-1 box">
	<h2 class="text-center"><?php echo vote_title; ?> Admin</h2>
	<p class="text-center">Site List</p>
	<hr>

	<div class="panel panel-info text-info">
		<div class="panel-body">
			<i class="fa fa-info-circle fa-4x fa-fw pull-left" style="margin-top:3px;"></i>
			<small>
			<strong>Tip:</strong> In the URLs, using <strong>{sid}</strong> will be replaced by the site id, and using <strong>{incentive}</strong> will be replaced by a unique code.
			Also, on some toplists, they may require you to specify the get request in callback URL. So if your site isn't receiving a vote, try adding <strong>?postback=</strong> to the callback url on that toplist. Check the toplist's instructions to see how you should set your callback url.
			</small>
		</div>
	</div>

	<p class="text-right">
		<a href="stats.php" class="btn btn-primary btn-xs"><i class="fa fa-bar-chart-o"></i> Vote Stats</a>
		<a href="?action=add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Add Site</a>
	</p>

	<div class="panel panel-default">
		<div class="panel-heading">
			Callback URL: <strong><?php echo $baseUrl; ?></strong>
		</div>
		<table class="table table-hover table-striped">
			<tr>
				<td>Id</td>
				<td>Title</td>
				<td>Site Id</td>
				<td>URL</td>
				<td class="text-center">Votes</td>
				<td style="width:60px;"></td>
			</tr>
			<?php
				$sites = $db->getAllSites();

				foreach ($sites as $site) {
					$votes = $db->getVotesById($site['id']);

					echo '<tr>';

					echo '<td>'.$site['id'].'</td>';
					echo '<td><i class="fa fa-'.($site['active'] == 1 ? "eye" : "low-vision").' fa-fw"></i> '.$site['title'].'</td>';
					echo '<td>'.$site['site_id'].'</td>';

					if (strlen($site['url']) > 30) {
						echo '<td>'.substr($site['url'], 0, 30).'...</td>';
					} else
						echo '<td>'.$site['url'].'</td>';

					echo '<td class="text-center">'.number_format($votes).'</td>';

					echo '<td>';
					echo '<div class="btn-group">
						<a href="#" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog fa-fw"></i></a>
						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="?action=edit&id='.$site['id'].'"><i class="fa fa-pencil-square-o fa-fw"></i>  Edit</a></li>';

					if ($site['active'] == 1) {
						echo '<li><a href="?action=deactivate&id='.$site['id'].'"><i class="fa fa-low-vision fa-fw"></i> Deactivate</a></li>';
					} else {
						echo '<li><a href="?action=activate&id='.$site['id'].'"><i class="fa fa-eye fa-fw"></i> Activate</a></li>';
					}

					echo '<li><a href="?action=delete&id='.$site['id'].'"><i class="fa fa-times fa-fw"></i> Delete</a></li>';
					echo '</ul></div></td>';

					echo '</tr>';
				}
			?>
		</table>
	</div>

	<div class="text-center">
		<a href="index.php" class="btn btn-link">Return to Home</a>
		&bull; <a href="?action=logout" class="btn btn-link">Sign Out</a></div>
	</div>
</div>
