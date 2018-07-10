<?php
            ob_start();
            include 'core/init.php';
            $userId = $_SESSION['userId'];
            $user = $userClass->userData($userId);
            
            if($userClass->loggedIn() === false) {
              header('Location: '.BASE_URL.'index.php');
            }


              $profileId;
           if (isset($_GET['profileId']) === true && empty($_GET['profileId']) === false && isset($_GET['userName']) === true && empty($_GET['userName']) === false) {
             
              $profileId = $_GET['profileId'];
              $profileUserName= $_GET['userName'];

              $profileData;
              if($profileId==$userId){
                $profileData=$user;
              }else{
                $profileData = $userClass->userData($profileId);
              }

            if (!$profileData) {
              header('Location: '.BASE_URL.'index.php');
            }
            if($profileData->firstName.'_'.$profileData->lastName!=$profileUserName){
               header('Location: '.BASE_URL.'index.php');
            }

          }else{
            header('Location: '.BASE_URL.'index.php');
          }



?>
<!DOCTYPE html>
<html>
<head>
	<title>Friends</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/reaction.css">
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/profile.css">
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/reaction.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/sendComment.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/post.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/dropdown.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/friend.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/upload_profile_photos.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/normalize.css">
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/friend.css">
</head>
<body>

<!-- Starting of main Wrapper clas -->
<div class="wrapper">

	<!-- header wrapper -->
	<div class="header-wrapper">

	<?php require 'includes/header.php' ?>

	</div>

	<div class="main-wrapper">
    <div class="uppper-wrapper">
    <?php require 'includes/profile_top_part.php' ?>
    </div>
		<!--   add friends -->
    <?php require 'includes/friend_includes.php' ?>
	</div>


</div>
<!-- End of Main Wrapper Class -->

	
</body>
</html>