<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>YES Land Realty | <?php	echo isset($title) ? $title : "No Title Detected"; 
	?></title>
	<link rel="icon" type="image/png" href="<?php echo base_url("assets/images/logos/yeslogo.png");?>">
	<?php
		$css = root_url("pages/defaults/main_css.php");
		include($css);
		$pageCss = root_url("pages/defaults/page_css.php");
		include($pageCss);
	?>
</head>