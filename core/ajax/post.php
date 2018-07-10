<?php

			include '../init.php';
			$userId=$_SESSION['userId'];

	if(!empty($_FILES['file']['name'][0]) or isset($_POST['status'])){
		 

		$status  = $_POST['status'];
		$privacy  = $_POST['privacy'];
		$postType = 0;
		$postUrl = '';
		if(isset($_POST['postType']) && !empty($_POST['postType']) && isset($_POST['url']) && !empty($_POST['url']) ){
           $postType=$_POST['postType'];
           $postUrl= $_POST['url'];
          
		}
		
			$insertedPost=0;
			 if (empty($_FILES['post_image']['name']) ===true) {
			 		
			 		if($postType!=0){
			 		
			 			 $insertedPost = $userClass->insert('posts', array('postUserId' => $userId, 'status' => $status, 'statusImage' => $postUrl,  'privacy'=> $privacy,  'postType'=> $postType, 'statusTime' => date('Y-m-d H:i:s')));
					 
			 		}else if( !empty($status)===true && strlen($status)>=1 ){
			 		
					 $insertedPost = $userClass->insert('posts', array('postUserId' => $userId, 'status' => $status, 'privacy'=> $privacy,  'statusTime' => date('Y-m-d H:i:s')));
					 
					}
			 	 }else {

				

				 $statusImage = $userClass->uploadImage($_FILES['post_image'],$userId,"post");
				 $insertedPost = $userClass->insert('posts', array('postUserId' => $userId, 'status' => $status, 'privacy'=> $privacy, 'postType'=> $postType, 'statusImage' => $statusImage, 'statusTime' => date('Y-m-d H:i:s')));
				
					
			 }
			if($insertedPost==0){
				echo " ";
			}else{
							$userClass->update('users','userId',$userId, array('privacyDefault' => $privacy));
				
						$post = $postClass->getPostDetails($insertedPost);
		 				$data = $userClass->userData($userId);

 						$reactions = $postClass->reactions($userId, $post->postId);

 						$reactionAttributes= array(
 													'applyClass'=>' ',
 													'applyEmo'=>'fa-thumbs-o-up',
 													'reactionName'=>'Like'	);
 					

 						 if($reactions){
 						 	$reactionType = $reactions['newReactionType'];
 						 	$reactionAttributes = $postClass->getReactionAttribute($reactionType);
 						 }
  						$time_ago = $post->statusTime;
						echo '
						<div class="post-show">
									<div class="post-show-inner">
										<div class="post-header">
											<div class="post-left-box">
												<div class="id-img-box"><img src="'.BASE_URL.$data->profileImage.'" style="width:50px; border-radius:50%;"></img></div>
												<div class="id-name">
													<ul>
													<li style="width:100%;" class="floatedli"><a href="#">'.$data->firstName. ' '.$data->lastName.' </a>
															';?> <?php 
																if($post->postType==1){
																		echo '<span><small>Changed Profile Image</small></span>';
																}else if($post->postType==2){
																	echo '<span><small>Changed Cover Image</small></span>';
																}
															?>


															 <?php echo '
														</li>
													<li style="margin-top:5px; margin-right:10px;" class="floatedli"><small>'.$userClass->timeAgo($time_ago).'</small></li>
															';?><?php 
																if($post->privacy==0){
																	echo '<li class="privacy_setting"><img src="'.BASE_URL.'assets/images/layout_img/globe.png"/></li>';
																}else if($post->privacy==1){
																	echo '<li class="privacy_setting"><img src="'.BASE_URL.'assets/images/layout_img/friends.png"/></li>';
																}else if($post->privacy==2){
																	echo '<li class="privacy_setting"><img src="'.BASE_URL.'assets/images/layout_img/only_me.png"/></li>';
																}

															?> <?php echo '
													</ul>
												</div>
											</div>
											<div class="post-right-box"></div>
										</div>
									
											<div class="post-body">
											<div class="post-header-text">
												'.$post->status.'
											</div>'.( ($post->statusImage != null) ? '<div class="post-img">
												<img src="'.BASE_URL.$post->statusImage.'"></img></div>' : '').'
											<div class="border-post"/></div>
											<div class="post-footer">
												<div class="post-footer-inner">
													<ul>
														

														<li>

									      							<span class="like-btn"   style="text-decoration:none;">
									      									<span  class="like-btn-text ';?><?php	if($reactions){echo'active'.' '.$reactionAttributes['applyClass'];}?><?php  echo'"   >'.$reactionAttributes['reactionName'].'</span>
										      								<i  class="like-btn-emo fa '.$reactionAttributes['applyEmo'].'" aria-hidden="true"></i> 
										      								<ul class="reactions-box" data-level="1" data-postId="'.$post->postId.'" ';?><?php	if($post->reactionList){echo 'data-reactionlatest="'.$post->reactionList.'" ';  }else{ echo 'data-reactionlatest=" "';}?> <?php echo' data-postUserId="'.$post->postUserId.'" 
										      										data-oldReactionId="';?><?php	if($reactions){echo $reactions['oldReactionType'];}else{echo 0;}?><?php echo'"> 
																					<li class="reaction reaction-like post-reaction" data-reaction="Like" data-newReactionId="1"></li>
																					<li class="reaction reaction-love post-reaction" data-reaction="Love" data-newReactionId="2"></li>
																					<li class="reaction reaction-haha post-reaction" data-reaction="HaHa" data-newReactionId="3"></li>
																					<li class="reaction reaction-wow post-reaction" data-reaction="Wow" 	data-newReactionId="4"></li>
																					<li class="reaction reaction-sad post-reaction" data-reaction="Sad"  	 data-newReactionId="5"></li>
																					<li class="reaction reaction-angry post-reaction" data-reaction="Angry" data-newReactionId="6"></li>
																			  </ul>
									      							</span>
									      				</li>

									      				<li>
									      							<button class="commentClass">
									      									<span class="">Comment</span>
										      								<i class="fa fa-comment-o" aria-hidden="true"></i>
										      								
									      							</button>
									      				</li>

														<li>
									      							<button class="shareClass">
									      									<span class="">Share</span>
										      								<i class="fa  fa-share" aria-hidden="true"></i>
										      								
									      							</button>
									      				</li>
														
													</ul>	
												</div>
											</div>
											
										</div>
								
							<div class="post-meta">
										<div class="post-reaction-wrapper">';?> <?php 
									if($post->reactionList && ($this->getTotalReactionCount(1,$post->postId))>0){

									$classOfEmorList= $this->getClassOfEmorList($post->reactionList,$post->likeCount,$post->loveCount,$post->hahaCount,$post->wowCount,$post->sadCount,$post->angryCount);

								echo '
								<div class="post-reaction">
										<span class="like-emo"> 
											'.$classOfEmorList.' 
										</span>
										<span class="like-details">

										';?>  <?php 
											$reactionValue = $postClass->getTotalReactionCount(1,$post->postId);
										 
										  if($reactions){
										  	if($reactionValue==1){
														$reactionValue--;
										  			 echo ' You Reacted'; 
										  	}else{
										  		$reactionValue--;
										  			 echo ' You and '. $reactionValue.' Other People Reacted'; 
										  	}
										  	

										  	}else{ echo $reactionValue.' People Reacted';
										  			
										  		}

										   ?>

										  <?php echo '

										</span>
										</div>
								';

							} echo '</div>'; ?>   <?php 
								if($post->shareCount){
									echo ' <div class ="post-share">
											</div>
									';

								}

								if($post->hasComment && ($post->hasComment ==1)){
									$comments = $postClass->getPostComment($post->postId);
									
									foreach($comments as $comment){
										$commenterData = $userClass->userData($comment->commentBy);

												$commentReactions = $this->commentReactions($userId, $post->postId,$comment->commentId);
												$commentReactionAttributes= array(
 													'applyClass'=>' ',
 													'reactionName'=>'Like'	);
 					
						 						 if($commentReactions){
						 						 	$reactionType = $commentReactions['newReactionType'];
						 						 		$commentReactionAttributes = $postClass->getReactionAttribute($reactionType);
						 						 }

											echo '

												<div class="post-comment">
												<div class="comment-wrapper">


													<div class="comment-display" >
														<div class="post-display-comment-left">
																<img src="'.BASE_URL.$commenterData->profileImage.'"/>
														</div>
													<div class="post-display-comment-right">
															
														<span > <span class="comment-display-username"><a style="color:#3F66B7;" href="'.BASE_URL.$commenterData->userId.'/'.$commenterData->firstName. '_'.$commenterData->lastName.'">'.$commenterData->firstName. ' '.$commenterData->lastName.' </a></span> '.$comment->comment.' </span>
													</div>	
													<div style="clear:both"></div>
													<div class="comment-display-details-container" style=" margin-left:90px; margin-top:5px;">
															<div class="comment-display-details-meta" style="color:#365899; font-size:12px;">
																		<div class="comment-display-details-meta-left">
																		
																			<span class="like-btn"   style="text-decoration:none;">
									      									<span  class="like-btn-text ';?><?php	if($commentReactions){echo'active'.' '.$commentReactionAttributes['applyClass'];}?><?php echo'"   >'.$commentReactionAttributes['reactionName'].'</span>
										      								
										      								<ul class="reactions-box" data-level="2"  data-commentId="'.$comment->commentId.'" data-postId="'.$post->postId.'" ';?><?php	if($comment->reactionList){echo 'data-reactionlatest="'.$comment->reactionList.'" ';  }else{ echo 'data-reactionlatest=" "';}?> <?php echo' data-postUserId="'.$post->postUserId.'" 
										      										data-oldReactionId="';?><?php	if($commentReactions){echo $commentReactions['oldReactionType'];}else{echo 0;}?><?php echo'"> 
																					<li class="reaction reaction-like comment-reaction" data-reaction="Like" data-newReactionId="1"></li>
																					<li class="reaction reaction-love comment-reaction" data-reaction="Love" data-newReactionId="2"></li>
																					<li class="reaction reaction-haha comment-reaction" data-reaction="HaHa" data-newReactionId="3"></li>
																					<li class="reaction reaction-wow comment-reaction" data-reaction="Wow" 	data-newReactionId="4"></li>
																					<li class="reaction reaction-sad comment-reaction" data-reaction="Sad"  	 data-newReactionId="5"></li>
																					<li class="reaction reaction-angry comment-reaction" data-reaction="Angry" data-newReactionId="6"></li>
																			  </ul>
									      							</span>


																	<span class="comment-display-details-reply"> Reply </span>
																	<span class="comment-display-details-time"> '.$userClass->timeAgo($comment->commentDate).' </span>
																	</div> 

																	<div class="comment-display-details-meta-right">';?><?php

																 if($comment->reactionList && ($postClass->getTotalReactionCount(2,$comment->commentId))>0){
																					$classOfEmorListComment= $postClass->getClassOfEmorList($comment->reactionList,$comment->likeCount,$comment->loveCount,$comment->hahaCount,$comment->wowCount,$comment->sadCount,$comment->angryCount);
																						echo '
																								
																										<span class="like-emo"> 
																											'.$classOfEmorListComment.' 
																											
																										</span>
																										<span class="comment-count">
																														';?>
																														<?php 
																															$commentReactionValue = $postClass->getTotalReactionCount(2,$comment->commentId);
																														 
																														  if($commentReactionValue){
																														  	if($commentReactionValue>=1){
																																		
																														  			 echo $commentReactionValue; 
																														  	}
																														  }
																														   ?>
																													<?php echo '
																											</span>
																									
																						';
																					}
																			 ?>
																			<?php echo '
																			</div>
																		<div style="clear:both;"></div>


															 </div>
															';?> <?php if($comment->hasSubComment==1) { 
																$subComments= $postClass->getPostSubComment($comment->commentId,$post->postId);
															
																foreach($subComments as $subComment){
																$subCommnterData = $userClass->userData($subComment->commentBy);

																		$subCommentReactions = $postClass->subCommentReactions($userId, $post->postId,$comment->commentId,$subComment->commentId);
																		$subCommentReactionAttributes= array(
						 													'applyClass'=>' ',
						 													'applyEmo'=>'fa-thumbs-o-up',
						 													'reactionName'=>'Like'	);
						 					
												 						 if($subCommentReactions){
												 						 	$reactionType = $subCommentReactions['newReactionType'];
												 						 		$subCommentReactionAttributes = $postClass->getReactionAttribute($reactionType);
												 						 }
																echo '
																<div class="comment-display-details-replies">

																<div class="post-display-comment-left" style="margin-top:10px; margin-right:10px;">
																		<img src="'.BASE_URL.$subCommnterData->profileImage.'"/>
																</div>
																<div class="post-display-comment-right" style="margin-top:10px;">
																		
																	<span > <span class="comment-display-username"><a style="color:#3F66B7;" href="'.BASE_URL.$subCommnterData->userId.'/'.$subCommnterData->firstName. '_'.$subCommnterData->lastName.'">'.$subCommnterData->firstName. ' '.$subCommnterData->lastName.' </a></span> '.$subComment->comment.' </span>
																</div>
																<div style="clear:both;"></div>
																<div class="sub-comment-display-details-meta"  style="color:#365899; margin-left:90px; font-size:12px;">
																	

																	<span class="like-btn"   style="text-decoration:none;">

									      							<span  class="like-btn-text ';?><?php	if($subCommentReactions){echo'active'.' '.$subCommentReactionAttributes['applyClass'];}?><?php echo'"   >'.$subCommentReactionAttributes['reactionName'].'</span>
										      								 
										      								<ul class="reactions-box" data-level="3" data-commentId="'.$comment->commentId.'" data-subCommentId="'.$subComment->commentId.'" data-postId="'.$post->postId.'" ';?><?php	if($subComment->reactionList){echo 'data-reactionlatest="'.$subComment->reactionList.'" ';  }else{ echo 'data-reactionlatest=" "';}?> <?php echo' data-postUserId="'.$post->postUserId.'" 
										      										data-oldReactionId="';?><?php	if($subCommentReactions){echo $subCommentReactions['oldReactionType'];}else{echo 0;}?><?php echo'"> 
																					<li class="reaction reaction-like sub-comment-reaction" data-reaction="Like" data-newReactionId="1"></li>
																					<li class="reaction reaction-love sub-comment-reaction" data-reaction="Love" data-newReactionId="2"></li>
																					<li class="reaction reaction-haha sub-comment-reaction" data-reaction="HaHa" data-newReactionId="3"></li>
																					<li class="reaction reaction-wow  sub-comment-reaction" data-reaction="Wow" 	data-newReactionId="4"></li>
																					<li class="reaction reaction-sad  sub-comment-reaction" data-reaction="Sad"  	 data-newReactionId="5"></li>
																					<li class="reaction reaction-angry sub-comment-reaction" data-reaction="Angry" data-newReactionId="6"></li>
																			  </ul>
									      							</span>


																	<span class="sub-comment-display-details-time"> '.$userClass->timeAgo($subComment->commentDate).' </span>

																		<div class="comment-display-details-meta-right">';?><?php

																				 if($subComment->reactionList && ($postClass->getTotalReactionCount(3,$subComment->commentId))>0){
																						$classOfEmorListSubComment= $postClass->getClassOfEmorList($subComment->reactionList,$subComment->likeCount,$subComment->loveCount,$subComment->hahaCount,$subComment->wowCount,$subComment->sadCount,$subComment->angryCount);
																							echo '
																									
																											<span class="like-emo"> 
																												'.$classOfEmorListSubComment.' 
																												
																											</span>
																											<span class="comment-count">
																															';?>
																															<?php 
																																$subCommentReactionValue = $postClass->getTotalReactionCount(3,$subComment->commentId);
																															 
																															  if($subCommentReactionValue){
																															  	if($subCommentReactionValue>=1){
																																			
																															  			 echo $subCommentReactionValue; 
																															  	}
																															  }
																															   ?>
																														<?php echo '
																												</span>
																										
																							';
																																										}
																				 ?>
																			<?php echo '
																			</div>
																		<div style="clear:both;"></div>


																 </div>




																</div>
																
																


																';
																}
															 }  


																?>  <?php echo '

																<div class="show_user_sub_reply"></div>	
																<div class="sub-comment-reply-wrapper"	'; ?> <?php if($comment->hasSubComment==0){ echo 'style=display:none';}?> <?php echo' >
																<div class="post-sub-comment-left">
																			<img src="'.BASE_URL.$user->profileImage.'"/>
																	</div>
																	<div class="post-sub-comment-right">
																			
																		<textarea class="sendSubCommentToPost" id="subComment_'.$post->postId.'" data-commentedPost="'.$post->postId.'" data-commentedOn="'.$comment->commentId.'" name="status" placeholder="Reply to comment !"   cols="30" ></textarea>
																	</div>	
																	<div style="clear:both;"></div>

																	</div>

														</div>
													</div>

								
												
						
												</div>
												
												</div>


											';
											}
									
								}

							echo ' 
								<div class="show_user_reply"></div>								

									<div class="post-comment-left">
											<img src="'.BASE_URL.$data->profileImage.'"/>
									</div>
									<div class="post-comment-right">
											
										<textarea class="sendCommentToPost" id="comment_'.$post->postId.'" data-commentedOn="'.$post->postId.'" name="status" placeholder="Write your comment!"   cols="45" ></textarea>
									</div>	
									<div style="clear:both;"></div>

								</div>
								</div>

 				';

			}
		

	}else{
		echo " ";
	}

	 

	

?>