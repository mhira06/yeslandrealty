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
	
	$page = "manage_online_ordering";
	$title = "Manage Online Ordering";
	$action = "manage_online_ordering";
	$pageLocation = "administration";
	$pageAction = $action != "" ? $action : $page;
	$session = isset($_SESSION[PROJECT][$pageAction]) ? $_SESSION[PROJECT][$pageAction] : array();
	$selectedStartDate = isset($session["start_date"]) ? $session["start_date"] : date("Y-m-01");
	$selectedEndDate = isset($session["end_date"]) ? $session["end_date"] : date("Y-m-d");
	$searchCondition = isset($session["search_condition"]) ? $session["search_condition"] : "";
	$startDate = $function->format_date_2($selectedStartDate, "Y-m-d", "m/d/Y");
	$endDate = $function->format_date_2($selectedEndDate, "Y-m-d", "m/d/Y");
	$defaultDate = $startDate." - ".$endDate;
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
								<h1 class="m-0">Manage Online Ordering</h1>
							</div><!-- /.col -->
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url("pages/display/dashboard.php"); ?>">Dashboard</a></li>
									<li class="breadcrumb-item active">Manage Online Ordering</li>
								</ol>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<section class="content">
					<div class="container-fluid">
						<div class = "row">
							<div class = "col-12">
							<?php
								$addtoCartCount = $select->get_add_to_cart_count(ID);
								$pendingCount = isset($addtoCartCount["order_count"]) ? $addtoCartCount["order_count"] : 0;
								$onlineOrderingSearchForm = root_url("pages/includes/online_ordering/online_ordering_search_form.php");
								include($onlineOrderingSearchForm);
							?>
							</div>
						</div>
						<div class = "row">
							<div class = "col-12">
							<?php
								
								//$searchCondition = "";
								//$pendingItemsList = $select->get_users_pending_orders(ID);
								$orderedItemsList = $select->get_active_submitted_ordered_items_list("", $searchCondition);
								$onlineOrderingOrderedItems = root_url("pages/includes/online_ordering/online_ordering_ordered_items.php");
								include($onlineOrderingOrderedItems);
							?>
							</div>
						</div>
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
		<script src="<?php echo $js ?>/pages/administration/manage_online_ordering.js"></script>
	</body>
</html>
