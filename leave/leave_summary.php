<?php
	if(empty($usersLeaveList)){
		$alert = $function->generate->alert_message("danger", "No Leave Credits Found");
		echo $alert;
	}
	
	if(!empty($usersLeaveList)){
	?>
		<div class = "row"><?php
			foreach($usersLeaveList as $uRows){
				$usersLeaveCreditId = $uRows["users_leave_credit_id"];
				$usersTypeLeave = $uRows["users_type_leave_id"];
				$dateFrom = $uRows["date_from"];
				$dateEnd = $uRows["date_to"];
				$usedLeaveDetails = $select->get_active_users_used_leaves(ID, $usersTypeLeave, $dateFrom, $dateEnd);
				//$function->echo_array($usedLeaveDetails);
				$usedLeave = isset($usedLeaveDetails["total_used_leave_credits"]) ? $usedLeaveDetails["total_used_leave_credits"] : 0;
				$availableCredits = ($uRows["users_leave_credit"] - $usedLeave);
			?>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-success">
						<div class="inner">
							<h3><?php echo $availableCredits;?></h3>

							<p><?php
								echo $uRows["leave_type_desc"]." (".$uRows["leave_type_code"].")";
							?></p>
						</div>
						<div class="icon">
							<i class="far fa-calendar-alt"></i>
						</div>
					<?php
						$moreInfoUrl = base_url("pages/display/leave.php");
						$moreInfoUrl .= "?action=more_info&leave_type=".$usersLeaveCreditId;
					?>
						<a href="<?php echo $moreInfoUrl; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
			<?php
			}
		?></div>
	<?php
	}
?>
