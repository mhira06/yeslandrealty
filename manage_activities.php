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
	$page = "manage_activities";
	$title = "Manage Activities";
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
								<h1 class="m-0">Activities Administration</h1>
							</div><!-- /.col -->
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url("pages/display/dashboard.php"); ?>">Dashboard</a></li>
									<li class="breadcrumb-item active">Manage Activities</li>
								</ol>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<section class="content">
					<div class="container-fluid">
					<?php
						$selectedId = $function->get("id");
						$activitiesDetails = array();
						if($selectedId != ""){
							$activitiesDetails = $select->get_active_activities_details_by_id($selectedId);
							
						}
						$selectedTargetAttendees = isset($activitiesDetails["target_attendees"]) ? $activitiesDetails["target_attendees"] : "";
						switch($action){
							case "results":
							$selectedStatus = $function->get("status");
						?>
							<div class = "row">
								<div class = "col-md-12">
								<?php
									//$targetAttendeesCondition = "p.positions_id in (".$selectedTargetAttendees.")";
									$targetAttendees = $select->get_active_target_attendees($selectedId);
									$targetAttendeesCount = count($targetAttendees);
									$activitiesAttendeesStatus = $select->get_activities_attendees_status();
									$activitiesSummaryResult = $select->get_active_activities_attendees_summary($selectedId);
									//$function->echo_array($activitiesSummaryResult);
									$activitiesSummary = root_url("pages/includes/activities/activities_summary.php");
									include($activitiesSummary);
								?>
								</div>
								
							</div>
							<div class = "row">
								<div class = "col-md-12">
								<?php
									$targetAttendeesList = $select->get_active_target_attendees($selectedId, $selectedStatus);
									$activitiesAttendeesList = root_url("pages/includes/activities/activities_attendess_list.php");
									include($activitiesAttendeesList);
								?>
								</div>
							</div>
						<?php
							break;
							
							default:
								$selectedAction = $selectedId != "" ? "edit" : "add";
								$selectedTitle = isset($activitiesDetails["activities_title"]) ? $activitiesDetails["activities_title"] : "";
								$selectedDesc = isset($activitiesDetails["activities_desc"]) ? $activitiesDetails["activities_desc"] : "";
								$selectedLocation= isset($activitiesDetails["location"]) ? $activitiesDetails["location"] : "";
								$selectedStartDate = isset($activitiesDetails["start_date"]) ? $activitiesDetails["start_date"] : date("Y-m-d");
								$selectedEndDate = isset($activitiesDetails["end_date"]) ? $activitiesDetails["end_date"] : date("Y-m-d");
								$selectedDateRegistrationEnd = isset($activitiesDetails["date_registration_end"]) ? $activitiesDetails["date_registration_end"] : "";
								$selectedStatus = isset($activitiesDetails["status_id"]) ? $activitiesDetails["status_id"] : "";
								
								$selectedTargetAttendees = $selectedTargetAttendees != "" ? explode(",", $selectedTargetAttendees) : array();
								$startDate = $function->format_date_2($selectedStartDate, "Y-m-d", "m/d/Y");
								$endDate = $function->format_date_2($selectedEndDate, "Y-m-d", "m/d/Y");
								$defaultDate = $startDate." - ".$endDate;
								$selectedRemarks = "";
								if($selectedId != ""){
									$activitiesStatusDetails = $select->get_active_activities_status($selectedId, $selectedStatus);
									$selectedRemarks = isset($activitiesStatusDetails["transaction_remarks"]) ? $activitiesStatusDetails["transaction_remarks"] : "";
								}
							?>
								<div class = "row">
									<div class = "col-md-4">
									<?php
										$activitiesForm = root_url("pages/includes/activities/activities_form.php");
										include($activitiesForm);
									?>
									</div>
									<div class = "col-md-8">
									<?php
										$activitiesCalendar = root_url("pages/includes/activities/activities_calendar.php");
										include($activitiesCalendar);
									?>
									</div>
								</div>
							<?php
							break;
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
		<script src="<?php echo $js ?>/pages/administration/manage_activities.js"></script>
	</body>
</html>
