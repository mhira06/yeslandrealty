<?php
	$professionalIdList = $select->get_active_professional_id();
	$usersProfessionalId = $select->get_active_users_professional_id(ID);
?>
<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">Goverment Number</h3>
	</div>
	<div class="card-body">
	<?php
		foreach($professionalIdList as $proRows){
			$idValue = isset($usersProfessionalId[$proRows["identification_desc"]]) ? $usersProfessionalId[$proRows["identification_desc"]] : "No Detected Id";
		?>
			<strong><i class="fas fa-book mr-1"></i> <?php
				echo $proRows["identification_desc"];
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