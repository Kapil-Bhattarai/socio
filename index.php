<?php 

include 'core/init.php';
if($userClass->loggedIn() === true){
		header('Location: home.php');
	}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Socio</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>

	
	<link rel="stylesheet" type="text/css" href="assets/css/home_style.css">
</head>
<body>

<!-- Starting of main Wrapper clas -->
<div class="wrapper-socio"> 
	<!-- header wrapper -->
<div class="header-wrapper-socio">
	
	<div class="nav-container-socio">
		<!-- Nav -->
		<div class="nav-socio">
			
			<div class="nav-left-socio">
				<img src="assets/images/socio.png" alt="Socio Logo" style="margin-top:20px;" />
			</div>
			<div class="nav-right-socio">
				<?php require 'includes/signin.php' ?>
			</div><!-- nav right ends-->

		</div><!-- nav ends -->

	</div><!-- nav container ends -->

</div><!-- header wrapper end -->

<!-- End of Main Wrapper Class -->
<?php require 'includes/signup.php' ?>
	
</body>
</html>