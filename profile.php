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
	//$function->echo_array($userDetails);
	//exit;
	$usersFullName = isset($userDetails["full_name"]) ? $userDetails["full_name"] : "";
	$usersNumber = isset($userDetails["users_number_display"]) ? $userDetails["users_number_display"] : "";
	$usersPicture = isset($userDetails["users_picture"]) && $userDetails["users_picture"] != "" ? $userDetails["users_picture"] : "assets/images/display/avatar4.png";
	$usersPicture = base_url($usersPicture);
	$usersPosition = isset($userDetails["positions_desc"]) ? $userDetails["positions_desc"] : "No Position Found";
	$usersType = isset($userDetails["users_type_desc"]) ? $userDetails["users_type_desc"] : "";
	$usersBirthday = isset($userDetails["birthday"]) ? $userDetails["birthday"] : "";
	$usersAge = isset($userDetails["age"]) ? $userDetails["age"] : ""; 
	$usersDateHired = isset($userDetails["date_hire"]) ? $userDetails["date_hire"] : ""; 
	$page = "profile";
	$title = "Profile";
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
								<h1 class="m-0">Profile</h1>
							</div><!-- /.col -->
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url("pages/display/dashboard.php"); ?>">Dashboard</a></li>
									<li class="breadcrumb-item active">Profile</li>
								</ol>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-3">
							<?php
								$profileHeader = root_url("pages/includes/profile/profile_header.php");
								include($profileHeader);
								$numberCode = "";
								$statusTitle = "";
								$dateHiredTitle = "Date Hired";
								switch($usersType){
									case "Employee":
										$numberCode = "government";
										$statusTitle = "Employment";
									break;
									
									case "Member":
										$numberCode = "professional";
										$statusTitle = "Member";
										$dateHiredTitle = "Date Affiliated";
									break;
								}
								$numberPage = root_url("pages/includes/profile/profile_".$numberCode."_number.php");
								include($numberPage);
							?>
							</div>
							<div class="col-md-9">
								<div class="card">
									<div class="card-header p-2">
										<ul class="nav nav-pills">
											<li class="nav-item">
												<a class="nav-link active" 
													href="#div_profile_personal_details" 
													data-toggle="tab">Personal Details
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" 
													href="#div_profile_change_password" 
													data-toggle="tab">Change Password
												</a>
											</li>
										</ul>
									</div>
									 <div class="card-body">
										<div class="tab-content">
											<div class="active tab-pane" id="div_profile_personal_details">
											<?php
												$personalDetailsPage = root_url("pages/includes/profile/profile_personal_details.php");
												include($personalDetailsPage);
											?>
											</div>
											<div class="tab-pane" id="div_profile_change_password">
											<?php
												$changePasswordPage = root_url("pages/includes/profile/profile_change_password.php");
												include($changePasswordPage);
											?>
											</div>
										</div>
									 </div>
								</div>
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
	</body>
</html>
