<div class = "row">
	<div class="col-lg-3 col-6">
			<!-- small box -->
		<div class="small-box bg-info">
			<div class="inner">
			<h3><?php
				echo $targetAttendeesCount;
			?></h3>

			<p>Target Attendees</p>
			</div>
			<div class="icon">
				<i class="fas fa-users"></i>
			</div>
		<?php
			$statusUrl = "pages/administration/manage_activities.php";
			$statusUrl .= "?id=".$selectedId;
			$statusUrl .= "&action=results";;
		?>
			<a href="<?php echo base_url($statusUrl);?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
<?php
	$notYetDecided = $targetAttendeesCount;
	foreach($activitiesAttendeesStatus as $aRows){
		$statusClass = "";
		$statusIcon = "";
		$statusId = $aRows["status_id"];
		$statusCode = $aRows["status_code"];
		$resultFields = $statusCode."_count";
		$result = isset($activitiesSummaryResult[$resultFields]) ? $activitiesSummaryResult[$resultFields] : 0;
		$notYetDecided = ($notYetDecided - $result);
		switch($statusId){
			case "6":
				$statusClass = "bg-success";
				$statusIcon = "thumbs-up";
			break;
			
			case "7":
				$statusClass = "bg-danger";
				$statusIcon = "thumbs-down";
			break;
		}
	?>
		<div class="col-lg-3 col-6">
			<!-- small box -->
			<div class="small-box <?php echo $statusClass; ?>">
				<div class="inner">
				<h3><?php
					echo $result;
				?></h3>

				<p><?php
					echo $aRows["status_desc"];
				?></p>
				</div>
				<div class="icon">
					<i class="fas fa-<?php echo $statusIcon; ?>"></i>
				</div>
			<?php
				$statusUrl = "pages/administration/manage_activities.php";
				$statusUrl .= "?id=".$selectedId;
				$statusUrl .= "&action=results";
				$statusUrl .= "&status=".$statusId;
			?>
				<a href="<?php echo base_url($statusUrl);?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
	<?php
	}
?>
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-warning">
			<div class="inner">
			<h3><?php
				echo $notYetDecided;
			?></h3>

			<p>Not Yet Decided</p>
			</div>
			<div class="icon">
				<i class="fas fa-users"></i>
			</div>
		<?php
			$statusUrl = "pages/administration/manage_activities.php";
			$statusUrl .= "?id=".$selectedId;
			$statusUrl .= "&action=results";
			$statusUrl .= "&status=not_yet_decided";
		?>
			<a href="<?php echo base_url($statusUrl);?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
</div>
