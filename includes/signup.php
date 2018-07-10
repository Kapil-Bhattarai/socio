<?php

if(isset($_POST['signup'])){

		   $firstname= $_POST['firstname'];
		   $lastname = $_POST['lastname'];
		   $email 	 = $_POST['email'];
		   $reemail = $_POST['reemail'];
		   $password = $_POST['password'];
		   $error;

		   $months   = $_POST['months'];
		   $day 	 = $_POST['day'];
		   $year 	 = $_POST['year'];
		   $gender = $_POST['gender'];

 	if( (  empty($firstname) or empty($lastname) or empty($email) or empty($password) ) && !isset($_SESSION['firstname'])){
		$error = 'All fields are required';
	}else {


		   $_SESSION['firstname']=$firstname;
		   $_SESSION['lastname']= $lastname;
		   $_SESSION['email']= $email;
		   $_SESSION['reemail']= $reemail;
		   $_SESSION['password']= $password;

		   $_SESSION['months']= $months;
		   $_SESSION['day']= $day;
		   $_SESSION['year']= $year;
		   $_SESSION['gender']= $gender;

		   $firstname = $userClass->checkInputData($firstname);
		   $lastname  = $userClass->checkInputData($lastname);
		   $email 	  = $userClass->checkInputData($email);
		   $reemail   = $userClass->checkInputData($reemail);
		   $password  = $userClass->checkInputData($password);


		 

		if(strlen($firstname)<3){
			$error = 'Firstname must have at least 3 characters';
		   }else if(strlen($lastname)<3){
			$error = 'LastName must have at least 3 characters';
		   }else if(filter_var($email,FILTER_VALIDATE_EMAIL)===false) {
				$error = 'Invalid email format';
			}else if($reemail!=$email){
				$error = 'Email doesn\'t match';
			}else if(strlen($password) < 5){
				$error = 'Password is too short';
			}else if($months==='Months' or $day ==='Day' or $year === 'Year'){
				$error = 'Invalid Date of Birth';
			}else {
				if($userClass->checkEmail($email) === true){
					$error = 'Email is already in use';
				}else {

						if($gender==1){
							$profileImage = 'assets/images/user_1.png';
						}else{
							$profileImage = 'assets/images/user_2.png';
						}
						$dob = $year."/".$months."/".$day;

						 $userId = $userClass->insert('users', array(

     	   												'firstName' => ucfirst($firstname), 
     	   												'lastName' => ucfirst($lastname) , 
     	   												'email' => $email, 
     	   												'password' => md5($password), 
     	   												'gender' => $gender,  
     	   												 'DOB'   => $dob,     	   												
     	   												'profileImage' => $profileImage, 
     	   												'coverImage' => 'assets/images/bg1.png', 
     	   												

     	   												));
						}
						$_SESSION['userId']=$userId;
						// do email confirmation
						header('Location: home.php');
				}
			}
	
}
  ?>
<div class="nav-container-body-socio">
			
			<div class="nav-left-body-socio" >
			<h1 style="text-align:center; margin-top:50px;"> Connect with friends and the<br>
world around you on Socio.</h1><br>
			<img src="assets/images/bg3.jpg"/>
							</div>
			<div class="nav-right-body-socio">
			<h1>Create a New Account </h1>
			<h3> It’s free and always will be . </h3>	<br>
				<?php 
					if(isset($error)){
				        echo '
				        <span style="color:red; font-size:20px;">'.$error.' ! </span>
				        ';
				      }

				      ?>
			<form method="POST">

					 <input type="firstname"  class="signup-bottom" id="signup-bottom-firstname-id" placeholder="First Name" name="firstname" value="<?php if(isset($_SESSION['firstname'])){ echo $_SESSION['firstname']; }?>" />
					  <input type="lastname"  class="signup-bottom" id="signup-bottom-lastname-id" placeholder="Last Name" name="lastname" value="<?php if(isset($_SESSION['lastname'])){ echo $_SESSION['lastname']; }?>"  /><br>
					  <input type="email"     class="signup-bottom" id="signup-bottom-email-id" placeholder="Email Address" name="email" value="<?php if(isset($_SESSION['email'])){ echo $_SESSION['email']; }?>"/><br>
					  <input type="email"     class="signup-bottom" id="signup-bottom-re-email-id" placeholder="Re Enter your Email Address" name="reemail" value="<?php if(isset($_SESSION['reemail'])){ echo $_SESSION['reemail']; }?>"/><br>
					  <input type="password"  class="signup-bottom" id="signup-bottom-password-id" placeholder="New Password" name="password"  value="<?php if(isset($_SESSION['password'])){ echo $_SESSION['password']; }?>"  /><br>
						
						<br>
						<h2> Birthday </h3>	<br>

						<select name="months">
						  <option  value="<?php if(isset($_SESSION['months'])){ echo $_SESSION['months']; } else { echo 'Months';}?>"><?php if(isset($_SESSION['months'])){ echo $_SESSION['months']; } else { echo 'Months';}?></option>
						 <?php require'includes/months.php' ?>
 
						</select>
						<select name="day" >
						<option value="<?php if(isset($_SESSION['day'])){ echo $_SESSION['day']; } else { echo 'Day';}?>"><?php if(isset($_SESSION['day'])){ echo $_SESSION['day']; } else { echo 'Day';}?></option>
						 <?php 
						 	for($i=1; $i<=30 ; $i++){
						 		echo '
 									<option value="'.$i.'"> '.$i.' </option>
						 		';
						 	}
						  ?>

						</select>
						<select name="year">
						<option  value="<?php if(isset($_SESSION['year'])){ echo $_SESSION['year']; } else { echo 'Year';}?>"><?php if(isset($_SESSION['year'])){ echo $_SESSION['year']; } else { echo 'Year';}?></option>
						 <?php 
						 	for($i=2018; $i>=1905 ; $i--){
						 		echo '
 									<option value="'.$i.'"> '.$i.' </option>
						 		';
						 	}
						  ?>

						</select><br><br>
						<input type="radio" class="form-radio" name="gender" value="1" checked >Male <i class="fa fa-male"></i>
  						<input type="radio"  name="gender" value="0" <?php if(isset($_SESSION['gender']) && $_SESSION['gender']==0){ echo 'checked';}?>> Female <i class="fa fa-female"></i><br>
  							<br>
  						<input type="submit"  name="signup" id="signup-bottom-submit-id" Value="Create Account" /><br>
					
			</form>
			</div>

		
	</div><!-- nav container body ends -->
	