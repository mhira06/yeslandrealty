<?php
	include("classes/functions.php");
	$function = new Functions();
	$session = isset($_SESSION[PROJECT]) ? $_SESSION[PROJECT] : array();
	$sessionUser = isset($session["user"]) ? $session["user"] : array();
	$userId = isset($sessionUser["id"]) ? $sessionUser["id"] : "";
	//echo $userId;
	//exit;
	if($userId == ""){
		redirect("pages/display/login.php");
	}
	else{
		redirect("pages/display/dashboard.php");
	}
?>