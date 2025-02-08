<?php
	$rootFolder = $_SERVER['DOCUMENT_ROOT']."/ylr_portal";
	include($rootFolder."/classes/functions.php");
	include($rootFolder."/classes/menu.php");
	$function = new Functions();
	$menu = new Menu();
	$select = new Select();
	if(ID == ""){
		redirect();
	}
	//$function->echo_array($sessionUser);
	//echo $employeeType;
	//$userTypeDetails = $select->get_user_type($userType);
	$userDetails = $select->get_user_details(ID);
	$action = $function->get("action");
	$page = "activities";
	$title = "Activities";
	$action = $function->get("action");
?>
<!DOCTYPE html>
<html lang="en">
	<?php
		$head = root_url("pages/defaults/head.php");
		//echo $head;
		include($head);
	?>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
		<?php
			$header = root_url("pages/defaults/header.php");
			//echo $header;
			include($header);
			$sideMenu = root_url("pages/defaults/side_menu.php");
			include($sideMenu);
		?>
			<div class="content-wrapper">
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0">Activities</h1>
							</div><!-- /.col -->
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url("pages/display/dashboard.php"); ?>">Dashboard</a></li>
									<li class="breadcrumb-item active">Activities</li>
								</ol>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<section class="content">
					<div class="container-fluid">
					<?php
						//$function->echo_array($userDetails);
						$positionsId = $userDetails["positions_id"];
						$activitiesCondition = "p.positions_id = '".$positionsId."' 
												and a.date_registration_end >= '".date("Y-m-d")."'";
						$activitiesList = $select->get_active_activities_list("", $activitiesCondition);
						//$function->echo_array($activitiesList);
						if(empty($activitiesList)){
							$messae = "No Activities";
							$alert = $function->generate->alert_message("warning", $messae);
							echo $alert;
						}
						if(!empty($activitiesList)){
							foreach($activitiesList as $aRows){
								$activitiesId = $aRows["activities_id"];
								$answerCondition = "activities_id = '".$activitiesId."' 
													and users_id = '".ID."'";
								$answerDetails = $select->get_active_activities_attendees_details("", $answerCondition);
								//$function->echo_array($answerDetails);
								$answer = isset($answerDetails["status_id"]) ? $answerDetails["status_id"] : "";
								$answerDesc = "";
								$answerClass = "";
								switch($answer){
									case "6": //join
										$answerDesc = "Will Join";
									break;
									
									case "7": //not join
										$answerDesc = "Will Not Join";
									break;
								}
							?>
								<div class = "row">
									<div class = "col-lg-12">
										<div class = "card card-default">
											<div class = "card-header">
												<h3 class = "card-title"><?php
													echo $aRows["activities_title"];
												?></h3>
											</div>
											<div class = "card-body">
												<p class = "h3"><?php
													echo $aRows["activities_desc"];
												?></p>
												<p class = "m-0">
													<b>Location: </b>
													<?php echo $aRows["location"];?>
												</p>
												
												<p class = "m-0">
													<b>From: </b>
													<?php echo $aRows["start_date"];?>
												</p>
												<p class = "m-0">
													<b>To: </b>
													<?php echo $aRows["end_date"];?>
												</p>
												<p class = "m-0">
													<b>Status: </b>
													<?php echo $answerDesc; ?>
												</p>
											</div>
											<div class = "card-footer">
											<?php
												switch($answer){
													case "6": //join
												?>
													<button 
														type = "button" 
														name = "btn_join" 
														id = "btn_join" 
														class = "btn btn-flat btn-danger activities_action"
														data-id = "<?php echo $aRows["activities_id"]; ?>"
														data-status = "7">Unjoin</button>
												<?php
													break;
													
													case "7":
												?>
													<button 
														type = "button" 
														name = "btn_join" 
														id = "btn_join" 
														class = "btn btn-flat btn-success activities_action"
														data-id = "<?php echo $aRows["activities_id"]; ?>"
														data-status = "6">Join</button>
												<?php
													break;
													
													default:
												?>
													<button 
														type = "button" 
														name = "btn_join" 
														id = "btn_join" 
														class = "btn btn-flat btn-success activities_action"
														data-id = "<?php echo $aRows["activities_id"]; ?>"
														data-status = "6">Join</button>
													<button 
														type = "button" 
														name = "btn_not_join" 
														id = "btn_not_join" 
														class = "btn btn-flat btn-danger activities_action"
														data-id = "<?php echo $aRows["activities_id"]; ?>"
														data-status = "7">Not Join</button>
												<?php
													break;
												}
											?>
												
											</div>
										</div>
									</div>
								</div>
							<?php
							}
						}
					?>
					</div>
				</section>
			</div>
			<?php
				$footer = root_url("pages/defaults/footer.php");
				include($footer);
			?>
		</div>
	<?php
		$js = root_url("pages/defaults/main_js.php");
		include($js);
		$pageJs = root_url("pages/defaults/page_js.php");
		include($pageJs);
	?>
		<script src="<?php echo $js ?>/pages/display/activities.js"></script>
	</body>
</html>
