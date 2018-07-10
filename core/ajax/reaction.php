<?php

include '../init.php'; 
    if(isset($_POST['removeReaction']) && !empty($_POST['removeReaction'])){

    	$userId  = $_SESSION['userId'];

    	$postId = $_POST['postId'];
    	$postUserId   = $_POST['postUserId'];
        $oldReactionId =  $_POST['oldReactionId'];
    	$oldReactionIdName = $_POST['oldReactionIdName'];
        $oldReactionLatest =  $_POST['oldReactionLatest'];

        $level              = $_POST['level'];

        $commentId;
        $subCommentId;

        if($level==2){
            $commentId                  =  $_POST['commentId'];
        }else if($level==3){
            $commentId                  =  $_POST['commentId'];
             $subCommentId              = $_POST['subCommentId'];
        }

          $data;
         if($level==1){
           $data=$postClass->removeReaction($userId, $postId, $postUserId,$oldReactionId,$oldReactionIdName,$oldReactionLatest,$level,null,null);
           }else if($level==2){
           $data=$postClass->removeReaction($userId, $postId, $postUserId,$oldReactionId,$oldReactionIdName,$oldReactionLatest,$level,$commentId,null);
           }else if($level==3){
            $data=$postClass->removeReaction($userId, $postId, $postUserId,$oldReactionId,$oldReactionIdName,$oldReactionLatest,$level,$commentId,$subCommentId);
           }

    	// copied part
                    if($level==1){
            $data = json_decode($data);
            $reactionValue=$postClass->getTotalReactionCount(1,$postId);
            $reactions = $postClass->reactions($userId, $postId);
            if($data->reactionlist && $reactionValue>0){

              $classOfEmorList= $postClass->getClassOfEmorList($data->reactionlist,$data->counts[0]->likeCount,$data->counts[0]->loveCount,$data->counts[0]->hahaCount,$data->counts[0]->wowCount,$data->counts[0]->sadCount,$data->counts[0]->angryCount);

            echo '
              <div class="post-reaction">
                    <span class="like-emo"> 
                      '.$classOfEmorList.' 
                    </span>
                    <span class="like-details">

                         ';?><?php 

                      

                             
                                echo $reactionValue.' Other People Reacted'; 
                            
                            

                       

                         ?>
                         <?php echo'

                      

                    </span>
                    </div>
            ';
             }
           }
      
      if($level==2 or $level==3){
            
        
           $data = json_decode($data);
           /* echo '<pre>';
            print_r($data);
            echo '</pre>';
            


            echo $data->reactionlist,'<br>';
            echo $data->value.'<br>';
            echo $data->counts.'<br>';
            echo $data->counts[0]->hahaCount.'<br>';
            die();
*/
          if($level==2){
            $commentReactionValue = $postClass->getTotalReactionCount(2,$commentId);
          }else if($level==3){
             $commentReactionValue = $postClass->getTotalReactionCount(3,$subCommentId);
          }
         if($data->reactionlist && ($commentReactionValue>0)){
             $classOfEmorListComment= $postClass->getClassOfEmorList($data->reactionlist,$data->counts[0]->likeCount,$data->counts[0]->loveCount,$data->counts[0]->hahaCount,$data->counts[0]->wowCount,$data->counts[0]->sadCount,$data->counts[0]->angryCount);
                                                                         
            echo '

                    <span class="like-emo"> 
                             '.$classOfEmorListComment.' 
                                                                                                            
                      </span>
                      <span class="comment-count">
                                ';?>
                                <?php 
                                
                                                                                                                         
                                       if($commentReactionValue){
                                             if($commentReactionValue>=1){
                                                                                                                                                    
                                                 echo $commentReactionValue; 
                                             }
                                           }

                                ?> <?php echo '                                                      
                         
                                                                                                                         
                     </span>
                ';
            

        }
      }
    }

    if(isset($_POST['addReaction']) && !empty($_POST['addReaction'])){

    	$userId  = $_SESSION['userId'];

    	$postId = $_POST['postId'];
    	$postUserId   = $_POST['postUserId'];
    	$newReactionIdName = $_POST['newReactionIdName'];
    	$oldReactionIdName = $_POST['oldReactionIdName'];
    	$newReactionId = $_POST['newReactionId'];
    	$oldReactionId = $_POST['oldReactionId'];
        $oldReactionLatest =  $_POST['oldReactionLatest'];

        $level              = $_POST['level'];
        $commentId;
        $subCommentId;

        if($level==2){
            $commentId                  =  $_POST['commentId'];
        }else if($level==3){
            $commentId                  =  $_POST['commentId'];
             $subCommentId              = $_POST['subCommentId'];
        }


         $data;
        if($level==1){
           $data= $postClass->addReaction($userId, $postId, $postUserId,$newReactionIdName, $oldReactionIdName,$newReactionId,$oldReactionId,$oldReactionLatest,$level,null,null);
           }else if($level==2){
           $data= $postClass->addReaction($userId, $postId, $postUserId,$newReactionIdName, $oldReactionIdName,$newReactionId,$oldReactionId,$oldReactionLatest,$level,$commentId,null);
           }else if($level==3){
            $data =$postClass->addReaction($userId, $postId, $postUserId,$newReactionIdName, $oldReactionIdName,$newReactionId,$oldReactionId,$oldReactionLatest,$level,$commentId,$subCommentId);
           }

           if($level==1){
            $data = json_decode($data);
            $reactionValue=$postClass->getTotalReactionCount(1,$postId);
            $reactions = $postClass->reactions($userId, $postId);
            if($data->reactionlist && $reactionValue>0){

              $classOfEmorList= $postClass->getClassOfEmorList($data->reactionlist,$data->counts[0]->likeCount,$data->counts[0]->loveCount,$data->counts[0]->hahaCount,$data->counts[0]->wowCount,$data->counts[0]->sadCount,$data->counts[0]->angryCount);

            echo '
              <div class="post-reaction">
                    <span class="like-emo"> 
                      '.$classOfEmorList.' 
                    </span>
                    <span class="like-details">

                         ';?><?php 

                      if($reactions){

                            if($reactionValue==1){
                                
                                 echo ' You Reacted'; 
                            }else{
                              $reactionValue--;
                                echo ' You and '. $reactionValue.' Other People Reacted'; 
                            }
                            

                        }else{ 
                          echo $reactionValue.' People Reacted';
                            
                         }

                         ?>
                         <?php echo'

                      

                    </span>
                    </div>
            ';
             }
           }
    	
    	if($level==2 or $level==3){
            
        
           $data = json_decode($data);
           /* echo '<pre>';
            print_r($data);
            echo '</pre>';
            


            echo $data->reactionlist,'<br>';
            echo $data->value.'<br>';
            echo $data->counts.'<br>';
            echo $data->counts[0]->hahaCount.'<br>';
            die();
*/
          if($level==2){
            $commentReactionValue = $postClass->getTotalReactionCount(2,$commentId);
          }else if($level==3){
             $commentReactionValue = $postClass->getTotalReactionCount(3,$subCommentId);
          }
         if($data->reactionlist && ($commentReactionValue>0)){
             $classOfEmorListComment= $postClass->getClassOfEmorList($data->reactionlist,$data->counts[0]->likeCount,$data->counts[0]->loveCount,$data->counts[0]->hahaCount,$data->counts[0]->wowCount,$data->counts[0]->sadCount,$data->counts[0]->angryCount);
                                                                         
            echo '

                    <span class="like-emo"> 
                             '.$classOfEmorListComment.' 
                                                                                                            
                      </span>
                      <span class="comment-count">
                                ';?>
                                <?php 
                                
                                                                                                                         
                                       if($commentReactionValue){
                                             if($commentReactionValue>=1){
                                                                                                                                                    
                                                 echo $commentReactionValue; 
                                             }else{
                                                echo $commentReactionValue;
                                             }
                                                                                                                                        }
                                      }else{
                                        echo $commentReactionValue;
                                      }

                                ?> <?php echo '                                                      
                         
                                                                                                                         
                     </span>
            ';
        }
    }


?>