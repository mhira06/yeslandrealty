<?php
	$positionsId = $userDetails["positions_id"];
	$activitiesCondition = "p.positions_id = '".$positionsId."' 
							and a.date_registration_end >= '".date("Y-m-d")."'";
	$activitiesList = $select->get_active_activities_list("", $activitiesCondition);
?>
<div class="row">
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-pink">
			<div class="inner">
			<h3><?php
				echo count($activitiesList);
			?></h3>

			<p>Current Activities</p>
			</div>
			<div class="icon">
				<i class="far fa-calendar-check"></i>
			</div>
			<a href="<?php echo base_url("pages/display/activities.php");?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
</div>