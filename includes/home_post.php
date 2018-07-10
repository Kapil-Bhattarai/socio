<?php if($userClass->loggedIn() === true){?>

	<div class="wrapper-top">		
		<!--content -->
		<div class="content">
			<!--left-content-->

			<?php   if( isset($profileId)) { ?>
			<div class="galleries">

				<?php require 'includes/timeline_photos.php' ?>
				<?php require 'includes/friends_photos.php' ?>


				<style>

			    div.gallery {
			        float: left;
			        width: 33.3%;
			    }



			    div.gallery img {
			        width: 100%;
			        height: 130px;
			    }

			    </style>
			</div>
			<?php } ?>

			 	
			<div class="center">


			<?php   if( !isset($profileId) OR $userId==$profileId) { ?>

				<div class="posts">
					<div class="create-posts">
 					<form action="" method="post" class="uploadStatusForm" enctype="multipart/form-data">
						<div class="c-header">
							<div class="c-h-inner">
								<ul>	
									<li style="border-right:none;"><img src="<?php echo BASE_URL; ?>assets/images/layout_img/icon3.png"></img><a href="#">Update Status</a></li>
									<li><input type="file"  onchange="readURL(this);" style="display:none;" name="post_image" id="uploadFile"></li>
									<li><img src="<?php echo BASE_URL; ?>assets/images/layout_img/icon1.png"></img><a href="#" id="uploadTrigger" name="post_image">Add Photos</a></li>
									
								</ul>
							</div>
						</div>
						<div class="c-body">
							<div class="body-left">
								<div class="img-box">
									 <img src="<?php echo BASE_URL.$user->profileImage;?>"></img> 
																	
								</div>
							</div>
							<div class="body-right">
								<textarea class="text-type" id="statusUpId" name="status" placeholder="What's on your mind, <?php echo $user->firstName; ?> ? "></textarea>
							</div>
							<div id="body-bottom">
							<img src="#"  id="preview"/>
							</div>
						</div>
						<div class="c-footer">
							<div class="right-box">
								<ul>
									<li class="floted-left">
						
 										<select id="userGolbalPrivacy" name="privacy_select">
 												
								      		  <option value="0" <?php if(($user->privacyDefault)==0){ echo 'selected="selected"'; }?>  name="privacy_select" data-imagesrc="<?php echo BASE_URL; ?>assets/images/layout_img/globe.png"
									            data-description="Anyone on or off Facebook">Public</option>

									        <option value="1"  <?php if(($user->privacyDefault)==1){ echo 'selected="selected"';  }?>   name="privacy_select" data-imagesrc="<?php echo BASE_URL; ?>assets/images/layout_img/friends.png"
									            data-description="Your Friends on Facebook">Friends</option>


									        <option value="2" <?php if(($user->privacyDefault)==2){ echo 'selected="selected"'; }?>   name="privacy_select" data-imagesrc="<?php echo BASE_URL; ?>assets/images/layout_img/only_me.png"
									            data-description="Only Me">Only Me</option>

									    </select>
																		  
													    
										

									</li >
									<li class="floted-left"><input  name="submit" value="Post" id="postStatus" class="btn2" style="text-align:center; outline-color:transparent;"/></li>
									<div class="clear"></div>
									<input  name="privacy" style="display:none;" value="<?php echo $user->privacyDefault;?>" id="privacyValue"/>
								</ul>
							</div>
								
							</div>
						</form>


						</div>
						</div>
						<?php } ?>
						
						  <!--   End of Posting System  -->


						<script type="text/javascript">
						 //Image Preview Function
						
								$("#uploadTrigger").click(function(){
								   $("#uploadFile").click();
								});
						        function readURL(input) {
						            if (input.files && input.files[0]) {
						                var reader = new FileReader();

						                reader.onload = function (e) {
						                	$('#body-bottom').show();
						                    $('#preview').attr('src', e.target.result);
						                }

						                reader.readAsDataURL(input.files[0]);
						            }
						        }

						        		
										$('#userGolbalPrivacy').ddslick({
										    onSelected: function(selectedData){
										       
										        document.getElementById('privacyValue').value = selectedData.selectedData.value;
										        
										    }   
										});


										
							
						</script>


					
						<div class="user_post_show"></div>
						<?php $postClass->posts($userId);	?>
					
					</div>
					
													
			</div>
       
   
 

</div>

<?php }?>
