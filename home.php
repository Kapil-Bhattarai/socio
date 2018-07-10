<?php

  include 'core/init.php';
  $userId = $_SESSION['userId'];
  $user = $userClass->userData($userId);
  
  if($userClass->loggedIn() === false) {
    header('Location: '.BASE_URL.'index.php');
  }


?>
<!DOCTYPE html>
<html>
<head>
	<title>Socio</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/reaction.css">
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/reaction.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/sendComment.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/upload_profile_photos.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/post.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/dropdown.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/normalize.css">

</head>
<body>

<!-- Starting of main Wrapper clas -->
<div class="wrapper">

	<!-- header wrapper -->
	<div class="header-wrapper">

	<?php require 'includes/header.php' ?>
	</div>

	<?php require 'includes/home_post.php' ?>
</div>
<!-- End of Main Wrapper Class -->

	
</body>
</html>