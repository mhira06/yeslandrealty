<?php
	$governmentIdList = $select->get_active_government_id();
	$usersGovernmentId = $select->get_active_users_government_id(ID);
?>
<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">Goverment Number</h3>
	</div>
	<div class="card-body">
	<?php
		foreach($governmentIdList as $govRows){
			$idValue = isset($usersGovernmentId[$govRows["identification_desc"]]) ? $usersGovernmentId[$govRows["identification_desc"]] : "No Detected Id";
		?>
			<strong><i class="fas fa-book mr-1"></i> <?php
				echo $govRows["identification_desc"];
			?></strong>
			<p class="text-muted"><?php
				echo $idValue;
			?></p>
			<hr>
		<?php
		}
	?>
	</div>
</div>