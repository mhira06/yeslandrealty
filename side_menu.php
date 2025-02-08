<aside class="main-sidebar sidebar-light-primary elevation-4">
	<div class = "nav-child-indent">
		<a href="index3.html">
			<center>
				<img src="<?php echo base_url("assets/images/logos/yes.jpg");?>" alt="YES Land Realty" class="brand-image elevation-3 w-75" style="opacity: .8">
			</center>
		</a>
	</div>
	
	<div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="<?php echo base_url(PROFILE_PICTURE);?>" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block"><?php
					echo FULL_NAME;
				?></a>
			</div>
		</div>
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<?php
				$sideMenu = $menu->side($page);
				//$function->echo_array($sideMenu);
				foreach($sideMenu as $sRows){
					$active = $sRows["class"];
					$icon = $sRows["icon"];
					$text = $sRows["text"];
					$url = $sRows["url"];
					$subMenu = isset($sRows["sub_menu"]) ? $sRows["sub_menu"] : array();
					$open = $active == "active" && !empty($subMenu) ? "menu-open" : "";
				?>
					<li class="nav-item <?php echo $open; ?>">
						<a href="<?php echo $url; ?>" class="nav-link <?php echo $active; ?>">
							<i class="nav-icon fas fa-<?php echo $icon; ?>"></i>
							<p><?php
								echo $text;
							?></p>
						<?php
							if(!empty($subMenu)){
							?>
								<i class="right fas fa-angle-left"></i>
							<?php
							}
						?>
						</a>
					<?php
						if(!empty($subMenu)){
						?>
							<ul class="nav nav-treeview">
						<?php
							foreach($subMenu as $suRows){
								$subUrlActive = $suRows["class"];
								$subUrlText = $suRows["text"];
								$subUrl = $suRows["url"];
							?>
								<li class="nav-item">
									<a href="<?php echo $subUrl; ?>" class="nav-link <?php echo $subUrlActive; ?>">
										<i class="far fa-circle nav-icon"></i>
										<p><?php 
											echo $subUrlText;
										?></p>
									</a>
								</li>
							<?php
							}
						?>
							</ul>
						<?php
						}
					?>
					</li>
				<?php
				}
				//$function->echo_array($sideMenu);
			?>
				
			</ul>
		</nav>
	</div>
</aside>