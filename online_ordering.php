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
	$page = "online_ordering";
	$pageLocation = "display";
	$title = "Online Ordering";
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
								<h1 class="m-0">Online Ordering</h1>
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
						$selectedStartDate = isset($session["start_date"]) ? $session["start_date"] : date("Y-m-01");
						$selectedEndDate = isset($session["end_date"]) ? $session["end_date"] : date("Y-m-d");
						$searchCondition = isset($session["search_condition"]) ? $session["search_condition"] : "";
						$startDate = $function->format_date_2($selectedStartDate, "Y-m-d", "m/d/Y");
						$endDate = $function->format_date_2($selectedEndDate, "Y-m-d", "m/d/Y");
						$defaultDate = $startDate." - ".$endDate;
						switch($action){
							case "order":
								$selectedItems = $function->get("id");
								$itemCondition = "i.items_id = '".$selectedItems."'";
								$itemsDetails = $select->get_active_items_display_details($itemCondition);
								$selectedItemImage = isset($itemsDetails["image"]) && $itemsDetails["image"] != "" ? $itemsDetails["image"] : "assets/images/items/not_available.jpg";
								$itemsImageUrl = base_url($selectedItemImage);
								//$function->echo_array($itemsDetails);
								$onlineOrderingForm = root_url("pages/includes/online_ordering/online_ordering_form.php");
								include($onlineOrderingForm);
							break;
							case "invoice":
							?>
								<div class = "row">
									<div class = "col-12">
									<?php
										echo $function->display_flash();
										$pendingItemsList = $select->get_users_pending_orders(ID);
										$onlineOrderingPendingItems = root_url("pages/includes/online_ordering/online_ordering_pending_items.php");
										include($onlineOrderingPendingItems);
									?>
									</div>
								</div>
							<?php
							break;
							case "view_orders":
							?>
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
										//$pendingItemsList = $select->get_users_pending_orders(ID);
										$orderedItemsList = $select->get_users_ordered_items_list(ID, $searchCondition);
										$onlineOrderingOrderedItems = root_url("pages/includes/online_ordering/online_ordering_ordered_items.php");
										include($onlineOrderingOrderedItems);
									?>
									</div>
								</div>
							<?php
							break;
							
							default: 
							?>
								<div class = "row">
									<div class = "col-12">
									<?php
										//$function->echo_array($session);
										$selectedItemType = isset($session["item_type"]) ? $session["item_type"] : array();
										
										$addtoCartCount = $select->get_add_to_cart_count(ID);
										$pendingCount = isset($addtoCartCount["order_count"]) ? $addtoCartCount["order_count"] : 0;
										$onlineOrderingSearchForm = root_url("pages/includes/online_ordering/online_ordering_search_form.php");
										include($onlineOrderingSearchForm);
									?>
									</div>
								</div>
							<?php
								echo $function->display_flash();
								$itemsList = $select->get_active_items_display_list($selectedItemType);
								$onlineOrderingItems = root_url("pages/includes/online_ordering/online_ordering_items.php");
								include($onlineOrderingItems);
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
		<script src="<?php echo $js ?>/pages/display/online_ordering.js"></script>
	</body>
</html>
