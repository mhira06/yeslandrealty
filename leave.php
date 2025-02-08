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
	$page = "leave";
	$title = "Leave";
	$session = isset($_SESSION[PROJECT][$page]) ? $_SESSION[PROJECT][$page] : array();
	//$function->echo_array($session);
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
								<h1 class="m-0">Leave</h1>
							</div><!-- /.col -->
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url("pages/display/dashboard.php"); ?>">Dashboard</a></li>
									<li class="breadcrumb-item active">Leave</li>
								</ol>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<section class="content">
					<div class="container-fluid">
					<?php
						switch($action){
							case "add":
							?>
								<div class = "row">
									<div class = "col-lg-4"><?php
										$leaveForm = root_url("pages/includes/leave/leave_form.php");
										include($leaveForm);
									?></div>
									<div class = "col-lg-8"><?php
										$leaveTransactionList = $select->get_users_pending_leave_list(ID);
										
										$leaveList = root_url("pages/includes/leave/leave_list.php");
										include($leaveList);
									?></div>
								</div>
							<?php
							break;
							
							default:
								$selectedStartDate = isset($session["start_date"]) ? $session["start_date"] : "";
								$selectedEndDate = isset($session["end_date"]) ? $session["end_date"] : "";
								$searchCondition = isset($session["search_condition"]) ? $session["search_condition"] : "";
								$leaveTransactionList = $select->get_users_leave_transaction_list(ID, $searchCondition);
								$usersLeaveList = $select->get_users_leave_credit_list(ID);
								$leaveSummary = root_url("pages/includes/leave/leave_summary.php");
								include($leaveSummary);
								$leaveSearchForm = root_url("pages/includes/leave/leave_search_form.php");
								include($leaveSearchForm);
								$leaveList = root_url("pages/includes/leave/leave_list.php");
								include($leaveList);
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
		<script src="<?php echo $js ?>/pages/display/leave.js"></script>
	</body>
</html>
