<nav class="main-header navbar navbar-expand navbar-red navbar-light">
	<ul class="navbar-nav text-white">
		<li class="nav-item text-white">
			<a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
		<?php
			$homeUrl = base_url("pages/display/dashboard.php");
		?>
			<a href="<?php echo $homeUrl;?>" class="nav-link text-white">Home</a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
		<?php
			$logoutUrl = base_url("action/logout.php");
		?>
			<a href="<?php echo $logoutUrl; ?>" class="nav-link text-white">Logout</a>
		</li>
	</ul>
</nav>