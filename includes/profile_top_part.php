	<div class="fb-profile-block">
         
          <div class="fb-profile-block-thumb">
             <img src="<?php echo BASE_URL.$profileData->coverImage ?>"  style="width:100%;">
          </div>
         
          <div class="profile-img">
            <img src="<?php echo BASE_URL.$profileData->profileImage ?>">
          </div>
          
          <div class="profile-name">
            <h2><?php echo $profileData->firstName." ".$profileData->lastName ?></h2>
          </div>
          
          <div class="fb-profile-block-menu">
               <div class="block-menu">
                    <ul>
                       <li ><a href="<?php echo BASE_URL.$profileData->userId.'/'.$profileData->firstName.'_'.$profileData->lastName?>" >Timeline</a></li>
                       <li><a href="#">about</a></li>
                       <li><a href="<?php echo BASE_URL.$profileData->userId.'/'.$profileData->firstName.'_'.$profileData->lastName.'/friends'?>">Friends
                        <span style="color:black; margin-left:5px; font-size:11px; opacity:0.8;">
                              <?php 

                              echo $profileData->friends;
                              
                              ?> 
                          </span></a>
                        </li>
                       <li><a href="#">Photos</a></li>
                    </ul>
               </div>
           </div>
  
              <?php if($userId==$profileId) {?>
              <div class="profile-hover-wrapper">
                <i class="fa fa-camera" style="width:30px;color:#fff; font-size:15px;"></i>
                <span> Update profile</span><br><span style="margin-left:38px;">Picture </span>
                
             </div>

             <form id="profileUploadForm" class="profileForm" method="POST" enctype="multipart/form-data">
                <input type="file" style="display:none;" name="file" id="uploadProfileFile">
              </form>

               <div class="cover-hover-wrapper">
                <i class="fa fa-camera" style="width:30px;color:#fff; font-size:15px;"></i>
                <span> Update Cover Photo </span>


             </div>
               <form id="coverUploadForm" class="coverForm" method="POST" enctype="multipart/form-data">
                <input type="file"   style="display:none; display:none;"name="post_cover_photo" id="uploadCoverFile">
             </form>
             <?php } ?>

             <div class="action-button-wrapper">

              

              <?php  if($userId!=$profileId){

                echo $friendClass->actionBtn($userId,$profileId);
                


                }else{
                  echo '
                    <button class="action-button-friend edit-btn" style="margin-right:10px;">
                     <i class="fa fa-pencil" style="padding-right:5px;"></i>   
                     <span >Edit Profile</span>            
                    </button>
                  ';
                }

                
                ?>
              
            </div>
    </div>