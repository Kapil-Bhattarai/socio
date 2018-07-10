
<?php

    include '../init.php'; 
    if(isset($_POST['sendComment']) && !empty($_POST['comment'])){

    	$userId  = $_SESSION['userId'];
    	$postId = $_POST['commentedOn'];
    	$comment   = $_POST['comment'];
    	$comment = $postClass->sendComment($userId, $postId, $comment);
        $comment = $comment[0];
    }

    if(isset($_POST['sendSubComment']) && !empty($_POST['comment'])){

    	$userId  = $_SESSION['userId'];
    	$commentedPostId = $_POST['commentedPost'];
    	$commentOnId = $_POST['commentedOn'];
    	$comment   = $_POST['comment'];
    	$subComment = $postClass->sendSubComment($userId, $commentedPostId, $commentOnId,$comment);
        $subComment = $subComment[0];
    }

     if(isset($_POST['sendComment']) && !empty($_POST['comment'])){

          $commenterData = $userClass->userData($comment->commentBy);
          $post = $postClass->getPostDetails($comment->parentId);

                                        $commentReactions = $postClass->commentReactions($userId, $post->postId,$comment->commentId);
                                                $commentReactionAttributes= array(
                                                    'applyClass'=>' ',
                                                    'reactionName'=>'Like'  );
                    
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
                                                            
                                                        <span > <span class="comment-display-username"><a  style="color:#3F66B7;" href="'.BASE_URL.$commenterData->userId.'/'.$commenterData->firstName. '_'.$commenterData->lastName.'">'.$commenterData->firstName. ' '.$commenterData->lastName.' </a></span> '.$comment->comment.'  </span>
                                                    </div>  
                                                    <div style="clear:both"></div>
                                                    <div class="comment-display-details-container" style=" margin-left:90px; margin-top:5px;">

                                                            <div class="comment-display-details-meta" style=" color:#365899; font-size:12px;">
                                                                <div class="comment-display-details-meta-left">
                                                                        
                                                                            <span class="like-btn"   style="text-decoration:none;">
                                                                            <span  class="like-btn-text ';?><?php   if($commentReactions){echo'active'.' '.$commentReactionAttributes['applyClass'];}?><?php echo'"   >'.$commentReactionAttributes['reactionName'].'</span>
                                                                            
                                                                            <ul class="reactions-box" data-level="2"  data-commentId="'.$comment->commentId.'" data-postId="'.$post->postId.'" ';?><?php    if($comment->reactionList){echo 'data-reactionlatest="'.$comment->reactionList.'" ';  }else{ echo 'data-reactionlatest=" "';}?> <?php echo' data-postUserId="'.$post->postUserId.'" 
                                                                                    data-oldReactionId="';?><?php   if($commentReactions){echo $commentReactions['oldReactionType'];}else{echo 0;}?><?php echo'"> 
                                                                                    <li class="reaction reaction-like comment-reaction" data-reaction="Like" data-newReactionId="1"></li>
                                                                                    <li class="reaction reaction-love comment-reaction" data-reaction="Love" data-newReactionId="2"></li>
                                                                                    <li class="reaction reaction-haha comment-reaction" data-reaction="HaHa" data-newReactionId="3"></li>
                                                                                    <li class="reaction reaction-wow comment-reaction" data-reaction="Wow"  data-newReactionId="4"></li>
                                                                                    <li class="reaction reaction-sad comment-reaction" data-reaction="Sad"       data-newReactionId="5"></li>
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

                                                               <div class="show_user_sub_reply"></div>

                                                               <div class="sub-comment-reply-wrapper" ';?> <?php if($comment->hasSubComment==0){ echo 'style="display:none;"';}?> <?php echo' >
                                                                <div class="post-sub-comment-left">
                                                                            <img src="'.BASE_URL.$commenterData->profileImage.'"/>
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
                                                
                                                </div>


                                            ';

                                        }


     if(isset($_POST['sendSubComment']) && !empty($_POST['comment'])){
                                      $subCommnterData = $userClass->userData($subComment->commentBy);
                                    $post = $postClass->getPostDetails($subComment->commentedPostId);
                                    $subCommentReactions = $postClass->subCommentReactions($userId, $commentedPostId,$commentOnId,$subComment->commentId);
                                                                        $subCommentReactionAttributes= array(
                                                                            'applyClass'=>' ',
                                                                            'applyEmo'=>'fa-thumbs-o-up',
                                                                            'reactionName'=>'Like'  );
                                            
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
                                                                                    
                                                                                <span > <span class="comment-display-username"><a  style="color:#3F66B7;"  href="'.BASE_URL.$subCommnterData->userId.'/'.$subCommnterData->firstName. '_'.$subCommnterData->lastName.'">'.$subCommnterData->firstName. ' '.$subCommnterData->lastName.' </a></span> <span style="color:black;">'.$subComment->comment.'</span> </span>
                                                                            </div>
                                                                            
                                                                         <div style="clear:both;"></div>



                                                                <div class="sub-comment-display-details-meta"  style="color:#365899; margin-left:90px; font-size:12px;">
                                                                 <span class="like-btn"   style="text-decoration:none;">

                                                                            <span  class="like-btn-text ';?><?php   if($subCommentReactions){echo'active'.' '.$subCommentReactionAttributes['applyClass'];}?><?php echo'"   >'.$subCommentReactionAttributes['reactionName'].'</span>
                                                                                     
                                                                                    <ul class="reactions-box" data-level="3" data-commentId="'.$commentOnId.'" data-subCommentId="'.$subComment->commentId.'" data-postId="'.$commentedPostId.'" ';?><?php  if($subComment->reactionList){echo 'data-reactionlatest="'.$subComment->reactionList.'" ';  }else{ echo 'data-reactionlatest=" "';}?> <?php echo' data-postUserId="'.$userId.'" 
                                                                                            data-oldReactionId="';?><?php   if($subCommentReactions){echo $subCommentReactions['oldReactionType'];}else{echo 0;}?><?php echo'"> 
                                                                                            <li class="reaction reaction-like sub-comment-reaction" data-reaction="Like" data-newReactionId="1"></li>
                                                                                            <li class="reaction reaction-love sub-comment-reaction" data-reaction="Love" data-newReactionId="2"></li>
                                                                                            <li class="reaction reaction-haha sub-comment-reaction" data-reaction="HaHa" data-newReactionId="3"></li>
                                                                                            <li class="reaction reaction-wow  sub-comment-reaction" data-reaction="Wow"     data-newReactionId="4"></li>
                                                                                            <li class="reaction reaction-sad  sub-comment-reaction" data-reaction="Sad"      data-newReactionId="5"></li>
                                                                                            <li class="reaction reaction-angry sub-comment-reaction" data-reaction="Angry" data-newReactionId="6"></li>
                                                                                      </ul>
                                                                            </span>
                                                                    <span class="sub-comment-display-details-time"> '.$userClass->timeAgo($subComment->commentDate).' </span>
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
                                                                 </div>




                                                                </div>
                                                                
                                                                  
                                                                

                                                    </div>


                                                                ';
     }

?>