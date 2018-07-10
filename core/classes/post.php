<?php
class Post extends User{
	

 	public function __construct($pdo){
		$this->pdo = $pdo;
		
	}

	
	public function posts($userId){
			$user = $this->userData($userId);
			$stmt = $this->pdo->prepare("SELECT * FROM `posts`  WHERE `privacy` = 1 OR `privacy`= 0 ORDER BY `postId` DESC");
			$stmt->execute();
		    $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

		   			 foreach($posts as $post){

 						$data = $this->userData($post->postUserId);


 						$reactions = $this->reactions($userId, $post->postId);

 						$reactionAttributes= array(
 													'applyClass'=>' ',
 													'applyEmo'=>'fa-thumbs-o-up',
 													'reactionName'=>'Like'	);
 					

 						 if($reactions){
 						 	$reactionType = $reactions['newReactionType'];
 						 	$reactionAttributes = $this->getReactionAttribute($reactionType);
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
														<li style="width:100%;" class="floatedli"><a href="'.BASE_URL.$data->userId.'/'.$data->firstName. '_'.$data->lastName.'">'.$data->firstName. ' '.$data->lastName.' </a> 
															';?> <?php 
																if($post->postType==1){
																		echo '<span><small>Changed Profile Image</small></span>';
																}else if($post->postType==2){
																	echo '<span><small>Changed Cover Image</small></span>';
																}
															?>


															 <?php echo '
														</li>
														<li style="margin-top:5px; margin-right:10px;" class="floatedli"><small>'.$this->timeAgo($time_ago).'</small></li>
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
											$reactionValue = $this->getTotalReactionCount(1,$post->postId);
										 
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
									$comments = $this->getPostComment($post->postId);
									
									foreach($comments as $comment){
										$commenterData = $this->userData($comment->commentBy);

												$commentReactions = $this->commentReactions($userId, $post->postId,$comment->commentId);
												$commentReactionAttributes= array(
 													'applyClass'=>' ',
 													'reactionName'=>'Like'	);
 					
						 						 if($commentReactions){
						 						 	$reactionType = $commentReactions['newReactionType'];
						 						 		$commentReactionAttributes = $this->getReactionAttribute($reactionType);
						 						 }

											echo '

												<div class="post-comment">
												<div class="comment-wrapper">


													<div class="comment-display" >
														<div class="post-display-comment-left">
																<img src="'.BASE_URL.$commenterData->profileImage.'"/>
														</div>
													<div class="post-display-comment-right">
															
														<span > <span class="comment-display-username"><a  style="color:#3F66B7;" href="'.BASE_URL.$commenterData->userId.'/'.$commenterData->firstName. '_'.$commenterData->lastName.'">'.$commenterData->firstName. ' '.$commenterData->lastName.' </a></span> '.$comment->comment.' </span>
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
																	<span class="comment-display-details-time"> '.$this->timeAgo($comment->commentDate).' </span>
																	</div> 

																	<div class="comment-display-details-meta-right">';?><?php

																 if($comment->reactionList && ($this->getTotalReactionCount(2,$comment->commentId))>0){
																					$classOfEmorListComment= $this->getClassOfEmorList($comment->reactionList,$comment->likeCount,$comment->loveCount,$comment->hahaCount,$comment->wowCount,$comment->sadCount,$comment->angryCount);
																						echo '
																								
																										<span class="like-emo"> 
																											'.$classOfEmorListComment.' 
																											
																										</span>
																										<span class="comment-count">
																														';?>
																														<?php 
																															$commentReactionValue = $this->getTotalReactionCount(2,$comment->commentId);
																														 
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
																$subComments= $this->getPostSubComment($comment->commentId,$post->postId);
															
																foreach($subComments as $subComment){
																$subCommnterData = $this->userData($subComment->commentBy);

																		$subCommentReactions = $this->subCommentReactions($userId, $post->postId,$comment->commentId,$subComment->commentId);
																		$subCommentReactionAttributes= array(
						 													'applyClass'=>' ',
						 													'applyEmo'=>'fa-thumbs-o-up',
						 													'reactionName'=>'Like'	);
						 					
												 						 if($subCommentReactions){
												 						 	$reactionType = $subCommentReactions['newReactionType'];
												 						 		$subCommentReactionAttributes = $this->getReactionAttribute($reactionType);
												 						 }
																echo '
																<div class="comment-display-details-replies">

																<div class="post-display-comment-left" style="margin-top:10px; margin-right:10px;">
																		<img src="'.BASE_URL.$subCommnterData->profileImage.'"/>
																</div>
																<div class="post-display-comment-right" style="margin-top:10px;">
																		
																	<span > <span class="comment-display-username"><a  style="color:#3F66B7;" href="'.BASE_URL.$subCommnterData->userId.'/'.$subCommnterData->firstName. '_'.$subCommnterData->lastName.'">'.$subCommnterData->firstName. ' '.$subCommnterData->lastName.' </a></span> '.$subComment->comment.' </span>
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


																	<span class="sub-comment-display-details-time"> '.$this->timeAgo($subComment->commentDate).' </span>

																		<div class="comment-display-details-meta-right">';?><?php

																				 if($subComment->reactionList && ($this->getTotalReactionCount(3,$subComment->commentId))>0){
																						$classOfEmorListSubComment= $this->getClassOfEmorList($subComment->reactionList,$subComment->likeCount,$subComment->loveCount,$subComment->hahaCount,$subComment->wowCount,$subComment->sadCount,$subComment->angryCount);
																							echo '
																									
																											<span class="like-emo"> 
																												'.$classOfEmorListSubComment.' 
																												
																											</span>
																											<span class="comment-count">
																															';?>
																															<?php 
																																$subCommentReactionValue = $this->getTotalReactionCount(3,$subComment->commentId);
																															 
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
											<img src="'.BASE_URL.$user->profileImage.'"/>
									</div>
									<div class="post-comment-right">
											
										<textarea class="sendCommentToPost" id="comment_'.$post->postId.'" data-commentedOn="'.$post->postId.'" name="status" placeholder="Write your comment!"   cols="45" ></textarea>
									</div>	
									<div style="clear:both;"></div>

								</div>
								</div>

 				';

		    }

	}

   public function addReaction($userId, $postId, $postUserId,$newReactionIdName, $oldReactionIdName,$newReactionId,$oldReactionId,$oldReactionLatest,$level,$commentId,$subCommentId){
   			
   				

   				$reactionArray = explode(',', $oldReactionLatest);
				$reactionArray = array_slice($reactionArray,0,4);
				array_push($reactionArray,$newReactionId);
				$reactionArray = array_unique($reactionArray);
				$reactionArray = array_reverse($reactionArray);
				$reactionArray = array_slice($reactionArray,0,4);
				$reactionText = implode(',', $reactionArray);

				if($level==1){

		  				$stmt = $this->pdo->prepare("UPDATE `posts` SET `$newReactionIdName` = `$newReactionIdName`+1 ,`reactionList` = '$reactionText' WHERE `postId` = :postId");
						$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
						$stmt->execute();

				}else if($level==2){

		  				$stmt = $this->pdo->prepare("UPDATE `comments` SET `$newReactionIdName` = `$newReactionIdName`+1 ,`reactionList` = '$reactionText' WHERE `commentId` = :commentId");
						$stmt->bindParam(":commentId", $commentId, PDO::PARAM_INT);
						$stmt->execute();

				}else if($level==3){

			  			$stmt = $this->pdo->prepare("UPDATE `comments` SET `$newReactionIdName` = `$newReactionIdName`+1 ,`reactionList` = '$reactionText' WHERE `commentId` = :subCommentId");
						$stmt->bindParam(":subCommentId", $subCommentId, PDO::PARAM_INT);
						$stmt->execute();
				}


				
		   	if($oldReactionId==0){

		   		if($level==1){
					$this->insert('reactions', array('reactionBy' => $userId, 'reactionOn' => $postId, 'newReactionType' => $newReactionId, 'oldReactionType' => $newReactionId));
		   		}else if($level==2){
		   				$this->insert('commentreaction', array('reactionBy' => $userId, 'reactionOn' => $commentId, 'newReactionType' => $newReactionId, 'oldReactionType' => $newReactionId,'parentPostId' => $postId));
		   	
		   		}else if($level==3){
					$this->insert('subcommentreaction', array('reactionBy' => $userId, 'reactionOn' => $subCommentId, 'newReactionType' => $newReactionId, 'oldReactionType' => $newReactionId,'parentPostId' => $postId,'parentCommentId' => $commentId));
		   		}
				
		   	}else{
		   		

				if($level==1){

		  				$stmt = $this->pdo->prepare("UPDATE `posts` SET `$oldReactionIdName` = `$oldReactionIdName`-1 ,`reactionList` = '$reactionText' WHERE `postId` = :postId");
						$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
						$stmt->execute();

				}else if($level==2){

		  				$stmt = $this->pdo->prepare("UPDATE `comments` SET `$oldReactionIdName` = `$oldReactionIdName`-1 ,`reactionList` = '$reactionText' WHERE `commentId` = :commentId");
						$stmt->bindParam(":commentId", $commentId, PDO::PARAM_INT);
						$stmt->execute();

				}else if($level==3){

			  			$stmt = $this->pdo->prepare("UPDATE `comments` SET `$oldReactionIdName` = `$oldReactionIdName`-1 ,`reactionList` = '$reactionText' WHERE `commentId` = :subCommentId");
						$stmt->bindParam(":subCommentId", $subCommentId, PDO::PARAM_INT);
						$stmt->execute();
				}


				if($level ==1){

				$stmt1 = $this->pdo->prepare("UPDATE `reactions` SET `oldReactionType` = $newReactionId , `newReactionType` = $newReactionId WHERE `reactionBy` = :userId AND `reactionOn` = :postId");
				$stmt1->bindParam(":userId", $userId, PDO::PARAM_INT);
				$stmt1->bindParam(":postId", $postId, PDO::PARAM_INT);
				$stmt1->execute();

				}else if($level==2){

				$stmt1 = $this->pdo->prepare("UPDATE `commentreaction` SET `oldReactionType` = $newReactionId , `newReactionType` = $newReactionId WHERE `reactionBy` = :userId AND `reactionOn` = :commentId");
				$stmt1->bindParam(":userId", $userId, PDO::PARAM_INT);
				$stmt1->bindParam(":commentId", $commentId, PDO::PARAM_INT);
				$stmt1->execute();

				}else if($level==3){

				$stmt1 = $this->pdo->prepare("UPDATE `subcommentreaction` SET `oldReactionType` = $newReactionId , `newReactionType` = $newReactionId WHERE `reactionBy` = :userId AND `reactionOn` = :subCommentId");
				$stmt1->bindParam(":userId", $userId, PDO::PARAM_INT);
				$stmt1->bindParam(":subCommentId", $subCommentId, PDO::PARAM_INT);
				$stmt1->execute();
				}


				$this->removeReactinListItem($postId,$oldReactionId,$oldReactionLatest,$level,$commentId,$subCommentId);
		   	}

		   	$postnnValue='';
		   	if($level==1){

		   	$stmt33 = $this->pdo->prepare("select ifnull(`likeCount`, 0) + ifnull(`loveCount`, 0) + ifnull(`hahaCount`, 0) + ifnull(`wowCount`, 0) + ifnull(`sadCount`, 0) + ifnull(`angryCount`, 0) as totalReaction from `posts` WHERE `postId` =:postId");
			$stmt33->bindParam(":postId", $postId, PDO::PARAM_INT);
			$stmt33->execute();
			$postnn=$stmt33->fetchAll(PDO::FETCH_OBJ);
			$postnnValue= $postnn[0]->totalReaction;
			

		   	}else if($level==2){

		   	$stmt33 = $this->pdo->prepare("select ifnull(`likeCount`, 0) + ifnull(`loveCount`, 0) + ifnull(`hahaCount`, 0) + ifnull(`wowCount`, 0) + ifnull(`sadCount`, 0) + ifnull(`angryCount`, 0) as totalReaction from `comments` WHERE `commentId` =:commentId");
			$stmt33->bindParam(":commentId", $commentId, PDO::PARAM_INT);
			$stmt33->execute();
			$postnn=$stmt33->fetchAll(PDO::FETCH_OBJ);
			$postnnValue= $postnn[0]->totalReaction;
			

		   	}else if($level==3){

		   	$stmt33 = $this->pdo->prepare("select ifnull(`likeCount`, 0) + ifnull(`loveCount`, 0) + ifnull(`hahaCount`, 0) + ifnull(`wowCount`, 0) + ifnull(`sadCount`, 0) + ifnull(`angryCount`, 0) as totalReaction from `comments` WHERE `commentId` =:subCommentId");
			$stmt33->bindParam(":subCommentId", $subCommentId, PDO::PARAM_INT);
			$stmt33->execute();
			$postnn=$stmt33->fetchAll(PDO::FETCH_OBJ);
			$postnnValue= $postnn[0]->totalReaction;
			

		   	}

		   	$reactionCounts=array();
		   	if($level==1){

			$stmt = $this->pdo->prepare("select `likeCount`, `loveCount`, `hahaCount`,`wowCount`,`sadCount`,`angryCount` FROM `posts` WHERE `postId`=:postId");
			$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
			$stmt->execute();
			$reactionCounts=$stmt->fetchAll(PDO::FETCH_OBJ);
			
			}else if($level==2){

		  	$stmt = $this->pdo->prepare("select `likeCount`, `loveCount`, `hahaCount`,`wowCount`,`sadCount`,`angryCount` FROM `comments` WHERE `commentId`=:commentId");
			$stmt->bindParam(":commentId", $commentId, PDO::PARAM_INT);
			$stmt->execute();
			$reactionCounts=$stmt->fetchAll(PDO::FETCH_OBJ);
			
			}else if($level==3){

			$stmt = $this->pdo->prepare("select `likeCount`, `loveCount`, `hahaCount`,`wowCount`,`sadCount`,`angryCount` FROM `comments` WHERE `commentId`=:subCommentId");
			$stmt->bindParam(":subCommentId", $subCommentId, PDO::PARAM_INT);
			$stmt->execute();
			$reactionCounts=$stmt->fetchAll(PDO::FETCH_OBJ);
			
			}

			$result = array(
						'reactionlist'=>$reactionText,
						'value'=>$postnnValue,
						'counts'=>$reactionCounts
					);

			return json_encode($result);
		

		/*	$stmt = $this->pdo->prepare("SELECT * FROM `posts`");
			$stmt->execute();
		    $postnn=$stmt->fetch(PDO::FETCH_OBJ);
			var_dump($postnn);*/
		   
	
		
	}

	public function removeReaction($user_id, $postId, $postUserId,$oldReactionId,$oldReactionIdName,$oldReactionLatest,$level,$commentId,$subCommentId){

			$postnnValue='';
			if($level==1){


			$stmt = $this->pdo->prepare("UPDATE `posts` SET `$oldReactionIdName` = `$oldReactionIdName`-1 WHERE `postId` = :postId");
			$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
			$stmt->execute();
		
			$stmt = $this->pdo->prepare("DELETE FROM `reactions` WHERE `reactionBy` = :user_id and `reactionOn` = :postId");
			$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
			$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
			$stmt->execute(); 
        

		   	$stmt33 = $this->pdo->prepare("select ifnull(`likeCount`, 0) + ifnull(`loveCount`, 0) + ifnull(`hahaCount`, 0) + ifnull(`wowCount`, 0) + ifnull(`sadCount`, 0) + ifnull(`angryCount`, 0) as totalReaction from `posts` WHERE `postId` =:postId");
			$stmt33->bindParam(":postId", $postId, PDO::PARAM_INT);
			$stmt33->execute();
			$postnn=$stmt33->fetchAll(PDO::FETCH_OBJ);
			$postnnValue= $postnn[0]->totalReaction;
		

		   	}else if($level==2){

		   	$stmt = $this->pdo->prepare("UPDATE `comments` SET `$oldReactionIdName` = `$oldReactionIdName`-1 WHERE `commentId` = :commentId");
			$stmt->bindParam(":commentId", $commentId, PDO::PARAM_INT);
			$stmt->execute();
		
			$stmt = $this->pdo->prepare("DELETE FROM `commentreaction` WHERE `reactionBy` = :user_id and `reactionOn` = :commentId");
			$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
			$stmt->bindParam(":commentId", $commentId, PDO::PARAM_INT);
			$stmt->execute(); 
        

		   	$stmt33 = $this->pdo->prepare("select ifnull(`likeCount`, 0) + ifnull(`loveCount`, 0) + ifnull(`hahaCount`, 0) + ifnull(`wowCount`, 0) + ifnull(`sadCount`, 0) + ifnull(`angryCount`, 0) as totalReaction from `comments` WHERE `commentId` =:commentId");
			$stmt33->bindParam(":commentId", $commentId, PDO::PARAM_INT);
			$stmt33->execute();
			$postnn=$stmt33->fetchAll(PDO::FETCH_OBJ);
			$postnnValue= $postnn[0]->totalReaction;
			

		   	}else if($level==3){

		   	$stmt = $this->pdo->prepare("UPDATE `comments` SET `$oldReactionIdName` = `$oldReactionIdName`-1 WHERE `commentId` = :subCommentId");
			$stmt->bindParam(":subCommentId", $subCommentId, PDO::PARAM_INT);
			$stmt->execute();
		
			$stmt = $this->pdo->prepare("DELETE FROM `subcommentreaction` WHERE `reactionBy` = :user_id and `reactionOn` = :subCommentId");
			$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
			$stmt->bindParam(":subCommentId", $subCommentId, PDO::PARAM_INT);
			$stmt->execute(); 


		   	$stmt33 = $this->pdo->prepare("select ifnull(`likeCount`, 0) + ifnull(`loveCount`, 0) + ifnull(`hahaCount`, 0) + ifnull(`wowCount`, 0) + ifnull(`sadCount`, 0) + ifnull(`angryCount`, 0) as totalReaction from `comments` WHERE `commentId` =:subCommentId");
			$stmt33->bindParam(":subCommentId", $subCommentId, PDO::PARAM_INT);
			$stmt33->execute();
			$postnn=$stmt33->fetchAll(PDO::FETCH_OBJ);
			$postnnValue= $postnn[0]->totalReaction;
		

		   	}



		$this->removeReactinListItem($postId,$oldReactionId,$oldReactionLatest,$level,$commentId,$subCommentId);

			$reactionCounts=array();
		   	if($level==1){

			$stmt = $this->pdo->prepare("select `likeCount`, `loveCount`, `hahaCount`,`wowCount`,`sadCount`,`angryCount`, `reactionList` FROM `posts` WHERE `postId`=:postId");
			$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
			$stmt->execute();
			$reactionCounts=$stmt->fetchAll(PDO::FETCH_OBJ);
			
			}else if($level==2){

		  	$stmt = $this->pdo->prepare("select `likeCount`, `loveCount`, `hahaCount`,`wowCount`,`sadCount`,`angryCount`,`reactionList` FROM `comments` WHERE `commentId`=:commentId");
			$stmt->bindParam(":commentId", $commentId, PDO::PARAM_INT);
			$stmt->execute();
			$reactionCounts=$stmt->fetchAll(PDO::FETCH_OBJ);
			
			}else if($level==3){

			$stmt = $this->pdo->prepare("select `likeCount`, `loveCount`, `hahaCount`,`wowCount`,`sadCount`,`angryCount`, `reactionList` FROM `comments` WHERE `commentId`=:subCommentId");
			$stmt->bindParam(":subCommentId", $subCommentId, PDO::PARAM_INT);
			$stmt->execute();
			$reactionCounts=$stmt->fetchAll(PDO::FETCH_OBJ);
			
			}


			$result = array(
						'reactionlist'=>$reactionCounts[0]->reactionList,
						'value'=>$postnnValue,
						'counts'=>$reactionCounts
					);

			return json_encode($result);
	}

	public function getPostDetails($postId){
		$stmt = $this->pdo->prepare("SELECT * FROM `posts` WHERE `postId` = :postId");
		$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function removeReactinListItem($postId,$removeReactionId,$oldReactionLatest,$level,$commentId,$subCommentId){
			$reactionReactionNameField="socio"; // no socio field , this is just a default case to prevent wrong update
			switch($removeReactionId){
					case 1:
							$reactionReactionNameField='likeCount';
							break;
					case 2:	
							$reactionReactionNameField='loveCount';
							break;
					case 3:	
							$reactionReactionNameField='hahaCount';
							break;
					case 4:
							$reactionReactionNameField='wowCount';
							break;
					case 5:
							$reactionReactionNameField='sadCount';
							break;
					case 6:
							$reactionReactionNameField='angryCount';
							break;
					default:
							$reactionReactionNameField='socio';
							break;
			}	

			if($level==1){
			$stmt = $this->pdo->prepare("select $reactionReactionNameField FROM `posts` WHERE `postId`=:postId");
			$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
			$stmt->execute();
			$reactionCount=$stmt->fetchAll(PDO::FETCH_OBJ);
			
			}else if($level==2){
		  	$stmt = $this->pdo->prepare("select $reactionReactionNameField FROM `comments` WHERE `commentId`=:commentId");
			$stmt->bindParam(":commentId", $commentId, PDO::PARAM_INT);
			$stmt->execute();
			$reactionCount=$stmt->fetchAll(PDO::FETCH_OBJ);
			
			}else if($level==3){

			$stmt = $this->pdo->prepare("select $reactionReactionNameField FROM `comments` WHERE `commentId`=:subCommentId");
			$stmt->bindParam(":subCommentId", $subCommentId, PDO::PARAM_INT);
			$stmt->execute();
			$reactionCount=$stmt->fetchAll(PDO::FETCH_OBJ);
			
			}
	
			switch($removeReactionId){
					case 1:
							$result=$reactionCount[0]->likeCount;
							break;
					case 2:	
							$result=$reactionCount[0]->loveCount;
							break;
					case 3:	
							$result=$reactionCount[0]->hahaCount;
							break;
					case 4:
							$result=$reactionCount[0]->wowCount;
							break;
					case 5:
							$result=$reactionCount[0]->sadCount;
							break;
					case 6:
							$result=$reactionCount[0]->angryCount;
							break;
					default:
							$result=0;
							break;
			}	

			if($result<=1){

			    $reactionArray = explode(',', $oldReactionLatest);
				$reactionArray = array_unique($reactionArray);

					if (($key = array_search($removeReactionId, $reactionArray)) !== false) {
					    unset($reactionArray[$key]);
					    $reactionArray = array_slice($reactionArray,0,4);
						$reactionText = implode(',', $reactionArray);



						if($level==1){

						$stmt = $this->pdo->prepare("UPDATE `posts` SET `reactionList` = '$reactionText' `postId` = :postId");
						$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
						$stmt->execute();

						}else if($level==2){

						$stmt = $this->pdo->prepare("UPDATE `comments` SET `reactionList` = '$reactionText' `commentId` = :commentId");
						$stmt->bindParam(":commentId", $commentId, PDO::PARAM_INT);
						$stmt->execute();

						}else if($level==3){

						$stmt = $this->pdo->prepare("UPDATE `comments` SET `reactionList` = '$reactionText' `commentId` = :subCommentId");
						$stmt->bindParam(":subCommentId", $subCommentId, PDO::PARAM_INT);
						$stmt->execute();

						}
					}

			}	


		}

	public function reactions($userId,$postId){
	
		$stmt = $this->pdo->prepare("SELECT * FROM `reactions` WHERE `reactionBy` = :userId AND `reactionOn` = :postId");
		$stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
		$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);

	}

	public function commentReactions($userId,$postId,$commentId){
	
		$stmt = $this->pdo->prepare("SELECT * FROM `commentreaction` WHERE `reactionBy` = :userId AND `reactionOn` = :commentId AND `parentPostId` = :postId");
		$stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
		$stmt->bindParam(":commentId", $commentId, PDO::PARAM_INT);
		$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);

	}

		public function subCommentReactions($userId,$postId,$commentId,$subCommentId){
	
		$stmt = $this->pdo->prepare("SELECT * FROM `subcommentreaction` WHERE `reactionBy` = :userId AND `reactionOn` = :subCommentId AND `parentPostId`=:postId AND `parentCommentId`= :commentId");
		$stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
		$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
		$stmt->bindParam(":subCommentId", $subCommentId, PDO::PARAM_INT);
		$stmt->bindParam(":commentId", $commentId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);

	}
	public function getReactionAttribute($reactionType){

 						$applyClass;
 						$applyEmo='fa-thumbs-o-up'; 
 						$reactionName='Like';

		 					switch ($reactionType) {
 						 		case 1:
 						 			$applyClass="like-btn-text-like";
 						 			$applyEmo="like-btn-like";
 						 			$reactionName='Like';
 						 			break;
 						 		case 2:
 						 			$applyClass="like-btn-text-love";
 						 			$applyEmo="like-btn-love";
 						 			$reactionName='Love';

 						 			break;
 						 		case 3:
 						 			$applyClass="like-btn-text-haha";
 						 			$applyEmo="like-btn-haha";
 						 			$reactionName='Haha';
 						 			break;
 						 		case 4:
 						 			$applyClass="like-btn-text-wow";
 						 			$applyEmo="like-btn-wow";
 						 			$reactionName='Wow';
 						 			break;
 						 		case 5:
 						 			$applyClass="like-btn-text-sad";
 						 			$applyEmo="like-btn-sad";
 						 			$reactionName='Sad';
 						 			break;
 						 		case 6:
 						 			$applyClass="like-btn-text-angry";
 						 			$applyEmo="like-btn-angry";
 						 			$reactionName='Angry';
 						 			break;


 						 		default:
 						 			$applyClass ='';
 						 			$applyEmo="fa-thumbs-o-up";
 						 			$reactionName='Like';
 						 			break;
 						 	}
 						 $reactionAttributes= array(
 						 		'applyClass'=> $applyClass ,
 						 		'applyEmo'=>$applyEmo ,
 						 		'reactionName'=>$reactionName
 						 	);
 						return $reactionAttributes;
			}
	public function getClassOfEmorList($reactionList, $likeCount,$loveCount,$hahaCount,$wowCount,$sadCount,$angryCount){
								$reactionArray = explode(',', $reactionList);
								$reactionArray = array_unique($reactionArray);
								$reactionArray = array_slice($reactionArray,0,4);

								$classOfEmorList='';

								if(in_array('1', $reactionArray) && ($likeCount)>=1){
									$classOfEmorList.="<span class='like-btn-like'></span>"; 

								}

								if(in_array('2', $reactionArray)&& ($loveCount)>=1){
									$classOfEmorList.="<span class='like-btn-love'></span>";
								}

								if(in_array('3', $reactionArray)&& ($hahaCount)>=1){
									$classOfEmorList.="<span class='like-btn-haha'></span>";
								}


								if(in_array('4', $reactionArray)&& ($wowCount)>=1){
									$classOfEmorList.="<span class='like-btn-wow'></span>";
								}



								if(in_array('5', $reactionArray)&& ($sadCount)>=1){
									$classOfEmorList.="<span class='like-btn-sad'></span>";
								}


								if(in_array('6', $reactionArray)&& ($angryCount)>=1){
									$classOfEmorList.="<span class='like-btn-angry'></span>";
								}

								return $classOfEmorList;
	}
	public function getPostComment($postId){
		$stmt = $this->pdo->prepare("SELECT * FROM `comments` WHERE `parentId` = :postId AND `level`=0");
		$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
		$stmt->execute();
		$data= $stmt->fetchAll(PDO::FETCH_OBJ);
		return $data;
		
	}

	public function getPostSubComment($parentId,$postId){
		$stmt = $this->pdo->prepare("SELECT * FROM `comments` WHERE `parentId` = :parentId AND  `commentedPostId` = :postId AND `level`=1");
		$stmt->bindParam(":parentId", $parentId, PDO::PARAM_INT);
		$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
		$stmt->execute();
		$data= $stmt->fetchAll(PDO::FETCH_OBJ);
		return $data;
	}
	public function getTotalReactionCount($level,$id){

			if($level==1){

		   	$stmt33 = $this->pdo->prepare("select ifnull(`likeCount`, 0) + ifnull(`loveCount`, 0) + ifnull(`hahaCount`, 0) + ifnull(`wowCount`, 0) + ifnull(`sadCount`, 0) + ifnull(`angryCount`, 0) as totalReaction from `posts` WHERE `postId` =:postId");
			$stmt33->bindParam(":postId", $id, PDO::PARAM_INT);
			$stmt33->execute();
			$postnn=$stmt33->fetchAll(PDO::FETCH_OBJ);
			$postnnValue= $postnn[0]->totalReaction;
			return $postnnValue;

			}else if($level==2 or $level==3){
		 	$stmt33 = $this->pdo->prepare("select ifnull(`likeCount`, 0) + ifnull(`loveCount`, 0) + ifnull(`hahaCount`, 0) + ifnull(`wowCount`, 0) + ifnull(`sadCount`, 0) + ifnull(`angryCount`, 0) as totalReaction from `comments` WHERE `commentId` =:commentId");
			$stmt33->bindParam(":commentId", $id, PDO::PARAM_INT);
			$stmt33->execute();
			$postnn=$stmt33->fetchAll(PDO::FETCH_OBJ);
			$postnnValue= $postnn[0]->totalReaction;
			return $postnnValue;
			}else{
				return 0;
			}

	}

	public function sendComment($userId, $postId, $comment){

			 $commentId = $this->insert('comments', array(

     	   												'comment' => $comment, 
     	   												'parentId' => $postId, 
     	   												'commentBy' => $userId,
     	   												'commentDate'=> date('Y-m-d H:i:s'),     	   												

     	   											));

			 		if($commentId){
			 			$updateIsComment= $this->update('posts','postId', $postId, array('hasComment' => '1'));
			 			
			 			
				 			$stmt = $this->pdo->prepare("SELECT * FROM `comments` WHERE `parentId` = :postId AND `commentBy` = :userId AND `commentId` =:commentId AND `level`=0");
							$stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
							$stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
							$stmt->bindParam(":commentId", $commentId, PDO::PARAM_INT);
							$stmt->execute();
							return $data = $stmt->fetchAll(PDO::FETCH_OBJ);
							
			 			
			 			
						
			 		} 
				}


	public function sendSubComment($userId, $commentedPostId, $commentOnId, $comment){

			 $commentId = $this->insert('comments', array(

     	   												'comment' => $comment, 
     	   												'parentId' => $commentOnId,
     	   												 'commentedPostId'=> $commentedPostId,
     	   												'commentBy' => $userId,
     	   												'level'      =>1,
     	   												'commentDate'=> date('Y-m-d H:i:s'),     	   												

     	   											));

			 		if($commentId){
			 			$updateIsComment= $this->update('comments','commentId', $commentOnId, array('hasSubComment' => '1'));
			 			
			 			
				 			$stmt = $this->pdo->prepare("SELECT * FROM `comments` WHERE `parentId` = :commentOnId AND `commentBy` = :userId AND `commentId` =:commentId AND `commentedPostId`= :commentedPostId AND `level`=1");
						
							$stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
							$stmt->bindParam(":commentedPostId", $commentedPostId, PDO::PARAM_INT);
							$stmt->bindParam(":commentOnId", $commentOnId, PDO::PARAM_INT);
							$stmt->bindParam(":commentId", $commentId, PDO::PARAM_INT);

							$stmt->execute();
							return $data = $stmt->fetchAll(PDO::FETCH_OBJ);
						
			 			
			 			
						
			 		} 
				}
}
?>