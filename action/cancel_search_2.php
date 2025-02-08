<?php
	$rootFolder = $_SERVER['DOCUMENT_ROOT']."/ylr_portal";
	include($rootFolder."/classes/functions.php");
	$function = new Functions();
	$session = $function->post("session");
	unset($_SESSION[PROJECT][$session]);
	echo json_encode("success");
	/*$page = $function->get("page");
	$location = $function->get("location");
	$pageLocation = $location == "" || $location == "undefine" ? "display" : $location;
	unset($_SESSION[PROJECT][$page]);
	$redirect = "pages/".$pageLocation."/".$page.".php";
	redirect($redirect);*/
?>