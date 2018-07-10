	<?php

		 if(isset($_POST['login']) && !empty($_POST['login'])) {

		    $email = $_POST['email'];
		    $password = $_POST['password'];

		    if(!empty($email) or !empty($password)) {

		      $email = $userClass->checkInputData($email);
		      $password = $userClass->checkInputData($password);

		      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		        $errorMsg = "Invalid format";
		      }else {
		        if($userClass->login($email, $password) === false){
		          $errorMsg = "The email or password is incorrect!";
		        }
		      }
		    }else {
		      $errorMsg = "Please enter Email and password!";
		    }
		  }

		  if(isset($errorMsg) && isset($_SESSION['failed_email'])){
		  	header('location: loginfailed.php');
		  }

	?>

				<div class="login-div-socio">
				<form method="POST">

						<div id="login-left-socio">
							<div id="login-right-leftside-socio">
								Email<br>
								  <input type="email" name="email" style="margin-top:5px;" />
							</div>
							<div id="login-right-rightside-socio"> 
								Password <br>
								 <input type="password" name="password" style="margin-top:5px; margin-bottom:5px;" /><br>
								 	<a href="#" style="color:#9cb4d8;"> Forgot account ? </a>
							</div>	

							</div>

							<div id="login-right-socio">
								<input type="submit" id="logingButton" name="login" value="Log In"/>
							</div>


							
						 
					</form>
				</div>
				<div class="clearDiv"></div>