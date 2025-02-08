<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">List</h3>
		<div class = "card-tools">
		<?php
			$activitiesForm  =  "pages/administration/manage_activities.php";
			$activitiesForm .= "?id=".$selectedId;
		?>
			<a href = "<?php echo base_url($activitiesForm);?>" 
				class = "btn btn-flat btn-info">Back</a>
		</div>
	</div>
	<div class = "card-body">
		<table id = "tbl_activities_attendees" class = "table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Users Number</th>
					<th>Name</th>
					<th>Users Type</th>
					<th>Decision</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if(!empty($targetAttendeesList)){
					$count = 1;
					foreach($targetAttendeesList as $tRows){
					?>
						<tr>
							<td><?php
								echo $count;
							?></td>		
							<td><?php
								echo $tRows["users_number_display"];
							?></td>	
							<td><?php
								echo $tRows["full_name"];
							?></td>	
							<td><?php
								echo $tRows["users_type_desc"];
							?></td>	
							<td><?php
								echo $tRows["status_desc"];
							?></td>	
						</tr>
					<?php
						$count++;
					}
				}
			?>
			</tbody>
		</table>
	</div>
</div>