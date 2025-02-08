<div class="card card-primary card-outline">
	<div class="card-body box-profile">
		<div class="text-center">
			<img class="profile-user-img img-fluid img-circle"
			   src="<?php echo $usersPicture; ?>"
			   alt="User profile picture">
		</div>

		<h3 class="profile-username text-center"><?php
			echo $usersFullName;
		?></h3>

		<p class="text-muted text-center"><?php
			echo $usersPosition;
		?></p>

		<ul class="list-group list-group-unbordered mb-3">
			<li class="list-group-item">
				<b><?php echo $usersType; ?> Number</b> <a class="float-right"><?php
					echo $usersNumber;
				?></a>
			</li>
			<li class="list-group-item">
				<b>User Type</b> <a class="float-right"><?php echo $usersType; ?></a>
			</li>
			<li class="list-group-item">
				<b>Birthday</b> <a class="float-right"><?php echo $usersBirthday; ?></a>
			</li>
			<li class="list-group-item">
				<b>Age</b> <a class="float-right"><?php 
					echo $usersAge;
				?></a>
			</li>
		</ul>
	</div>
</div>