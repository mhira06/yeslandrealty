<?php
	$rootFolder = $_SERVER['DOCUMENT_ROOT']."/ylr_portal";
	include($rootFolder."/classes/functions.php");
	$function = new Functions();
	$title = "Login";
	$action = $function->get("action");
	$form = "login_form";
	if($action == "change_password"){
		$form = "change_password_form";
		$title = "Change Password";
	}
	//$rootUrl = $function->root_url();
	if(LOGGED_IN == 1 && ID != ""){
		redirect("pages/display/dashboard.php");
	}
?>
<html lang="en">
<?php
	$head = root_url("pages/defaults/head.php");
	include($head);
?>
	<body>
		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100">
					<div class="login100-pic js-tilt" data-tilt>
					<?php
						$imageUrl = base_url("assets/images/logos/yeslogo.png");
					?>
						<img src="<?php echo $imageUrl; ?>" alt="IMG">
					</div>
				<?php
					$loginForm = root_url("pages/includes/login/".$form.".php");
					include($loginForm);
				?>
				</div>
			</div>
		</div>
	<?php
		$js = root_url("pages/defaults/main_js.php");
		include($js);
		$pageJs = root_url("pages/defaults/page_js.php");
		include($pageJs);
	?>
	</body>
</html>