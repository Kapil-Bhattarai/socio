	<div class="nav-container">
		<!-- Nav -->
		<div class="nav">
			
			<div class="nav-left" >
				<?php echo '<img src="'.BASE_URL.'assets/images/home_page_socio_logo1.png" style="margin-top:10px;"/>'; ?>
				<!-- <input type="text" id="search_box" placeholder="Search"/>
				<input type="button" id="search_icon" Value="<i class="fa fa-search" aria-hidden="true"></i>"/> -->

				<div class="search-box-wrapper">
           		 <input type="text" placeholder="Search" class="search-box-input">
           		 <button class="search-box-button" ><i class="fa fa-search" style="width:30px;color:#000; font-size:15px;"></i></button>
        </div>
			</div>
			<div class="nav-right">
			<ul>
			<li><span><a href="<?php echo BASE_URL.$user->userId.'/'.$user->firstName.'_'.$user->lastName ?>"><img src="<?php echo ' '.BASE_URL.''.$user->profileImage.'';?>" style="width:25px; height:25px; border-radius:50%; margin-top:10px;" /> </a></span></li>
			<li><a href="<?php echo BASE_URL.$user->userId.'/'.$user->firstName.'_'.$user->lastName ?>"> <?php echo  $user->firstName; ?></a></li>
			<li><a href="<?php echo BASE_URL; ?>home.php">Home</a></li>
			<li><a href="<?php echo BASE_URL; ?>findfriends.php">Find Friends</a></li>
			<li><a href="<?php echo BASE_URL; ?>home.php"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
			<li><a href="<?php echo BASE_URL; ?>notification.php"><i class="fa fa-globe" aria-hidden="true"></i></a></li>
        	<li><a href="<?php echo BASE_URL; ?>home.php"><i class="fa fa-sort-down" aria-hidden="true"  style="font-size:25px;"></i></a></li>
			</ul>
			</div><!-- nav right ends-->

		</div><!-- nav ends -->

	</div><!-- nav container ends -->
