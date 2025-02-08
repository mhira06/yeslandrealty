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
	$page = "sales";
	$title = "Sales";
	$action = $function->get("action");
	$pageAction = $action != "" ? $action : $page;
	$session = isset($_SESSION[PROJECT][$pageAction]) ? $_SESSION[PROJECT][$pageAction] : array();
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
								<h1 class="m-0">Sales</h1>
							</div><!-- /.col -->
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url("pages/display/dashboard.php"); ?>">Dashboard</a></li>
									<li class="breadcrumb-item active">Online Ordering</li>
								</ol>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<section class="content">
					<div class="container-fluid">
					<?php
						switch($action){
							case "add_client":
								
							break;
							
							case "add_sales":
							?>
								<div class = "row">
									<div class = "col-lg-12">
									<?php
										$clientsList = $select->get_active_clients_list();
										$salesForm = root_url("pages/includes/sales/sales_form.php");
										include($salesForm);
									?>
									</div>
								</div>
							<?php
							break;
							
							default:
								$selectedStartDate = isset($session["start_date"]) && $session["start_date"] != "" ? $session["start_date"] : date("Y-m-01");
								$selectedEndDate = isset($session["end_date"]) && $session["end_date"] != ""? $session["end_date"] : date("Y-m-d");
								$selectedSummary = isset($session["summary"]) && $session["summary"] != ""? $session["summary"] : date("Y-m-d");
								
								$searchCondition = isset($session["search_condition"]) ? $session["search_condition"] : "";
								
								$summaryCondition = "sa_u.users_id = '".ID."'";
								$dailySummaryCondition = $summaryCondition." and date_reserve = date(now())";
								$dailySummary = $select->get_active_sales_summary($dailySummaryCondition);
								$dailySummaryCount = isset($dailySummary["sales_count"]) ? $dailySummary["sales_count"] : "0";
								$dailyClass = $selectedSummary == "daily" ? "bg-success" : "bg-info";
								
								$monthlySummaryCondition = $summaryCondition." and date_format(date_reserve, '%Y-%m') = date_format(now(), '%Y-%m')";
								$monthlySummary = $select->get_active_sales_summary($monthlySummaryCondition);
								$monthlySummaryCount = isset($monthlySummary["sales_count"]) ? $monthlySummary["sales_count"] : "0";
								$monthlyClass = $selectedSummary == "monthly" ? "bg-success" : "bg-info";
								
								$yearlySummaryCondition = $summaryCondition." and date_format(date_reserve, '%Y') = date_format(now(), '%Y')";
								$yearlySummary = $select->get_active_sales_summary($monthlySummaryCondition);
								$yearlySummaryCount = isset($yearlySummary["sales_count"]) ? $yearlySummary["sales_count"] : "0";
								$yearlyClass = $selectedSummary == "yearly" ? "bg-success" : "bg-info";
								
								$salesSummary = root_url("pages/includes/sales/sales_summary.php");
								include($salesSummary);
							?>
								<div class = "row">
									<div class = "col-lg-12"><?php
										$startDate = $function->format_date_2($selectedStartDate, "Y-m-d", "m/d/Y");
										$endDate = $function->format_date_2($selectedEndDate, "Y-m-d", "m/d/Y");
										$defaultDate = $startDate." - ".$endDate;
										$summaryDesc = "";
										switch($selectedSummary){
											case "daily":
												$summaryDesc = "Daily";
											break;
											
											case "monthly":
												$summaryDesc = "Monthly";
											break;
											
											case "yearly":
												$summaryDesc = "Yearly";
											break;
										}
										$salesSearchForm = root_url("pages/includes/sales/sales_search_form.php");
										include($salesSearchForm);
									?></div>
									
									<div class = "col-lg-12"><?php
										$searchCondition = "";
										$usersCondition = "sa_u.users_id = '".ID."'";
										$salesCondition = $usersCondition ." and (date(sa.date_reserve) >= '".$selectedStartDate."'
															and date(sa.date_reserve) <= '".$selectedEndDate."')";
										if($searchCondition != ""){
											$salesCondition = $usersCondition." and ".$searchCondition;
										}
										$salesList = $select->get_active_sales_list("", $salesCondition);
										$salesSearchForm = root_url("pages/includes/sales/sales_list.php");
										include($salesSearchForm);
									?></div>
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
		<script src="<?php echo $js ?>/pages/display/sales.js"></script>
	</body>
</html>
