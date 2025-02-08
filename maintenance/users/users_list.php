<div class = "card card-primary card-outline">
	<div class = "card-header">
		<h3 class = "card-title">Users List</h3>
		<div class = "card-tools">
			<a href = "<?php echo base_url("pages/maintenance/users.php?action=add");?>" class = "btn btn-flat btn-info">Add</a>
		</div>
	</div>
	<div class = "card-body">
		<table class = "table table-bordered" id = "tbl_users">
			<thead>
				<tr>
					<th>No</th>
					<th>Action</th>
					<th>User Number</th>
					<th>Full Name</th>
					<th>Position</th>
					<th>User Type</th>
					<th>Login Type</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$usersList = $select->get_active_users_list();
				//$function->echo_array($usersList);
				$count = 1;
				foreach($usersList as $uRows){
					$usersType = $uRows["users_type_id"];
				?>
					<tr>
						<td><?php
							echo $count;
						?></td>
						<td>
							<a 
								href = "<?php echo base_url("pages/maintenance/users.php?action=edit&id=".$uRows["users_id"]);?>" 
								class = "btn btn-flat btn-info">EDIT</a>
						<?php
							if($usersType == "1"){
							?>
							
								<button 
									type = "button" 
									name = "btn_update_leave_<?php echo $uRows["users_id"]; ?>" 
									id = "btn_update_leave_<?php echo $uRows["users_id"]; ?>" 
									data-id = "<?php echo $uRows["users_id"]; ?>"
									data-users_type = "<?php echo $usersType; ?>" 
									data-action = "update_leave";
									class = "btn btn-flat btn-primary users_action">Update Leave</button>
							<?php
							}
						?>
						</td>
						<td><?php
							echo $uRows["users_number_display"];
						?></td>
						<td><?php
							echo $uRows["full_name"];
						?></td>
						<td><?php
							echo $uRows["positions_desc"];
						?></td>
						<td><?php
							echo $uRows["users_type_desc"];
						?></td>
						<td><?php
							echo $uRows["login_type_desc"];
						?></td>
						<td><?php
							echo $uRows["users_status"];
						?></td>
					</tr>
				<?php
					$count++;
				}
			?>
			</tbody>
		</table>
	</div>
</div>