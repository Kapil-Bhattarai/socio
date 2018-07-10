<?php
class Friend extends User{
	
 	public function __construct($pdo){
		$this->pdo = $pdo;
		
	}

	public function checkRequest($userId,$profileId){

		$stmt = $this->pdo->prepare("SELECT * FROM `requests` WHERE `sender` = :userId AND `receiver` = :profileId OR `sender` = :profileId AND `receiver` = :userId");
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
		$stmt->bindParam(':profileId', $profileId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);

	}

	public function checkFriend($userId,$profileId){

			$stmt = $this->pdo->prepare("SELECT * FROM `friends` WHERE `userId` = :userId AND `profileId` = :profileId");
			$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
			$stmt->bindParam(':profileId', $profileId, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);

		}

	public function actionBtn($userId,$profileId){
		$request = $this->checkRequest($userId,$profileId);

		if($request){
				
				if($request['sender']==$userId){
						return '
							  <button class="action-button-friend request-sent-btn" style="margin-right:10px; width:150px;"   data-profileId="'.$profileId.'">
			                     <i class="fa fa-user" style="padding-right:5px;"></i>   
			                     <span >Cancel Request</span>            
		                    </button>
						';
				}else{
						return '

							 <button class="action-button-friend request-received-btn" style="margin-right:10px; width:150px;"  data-profileId="'.$profileId.'">
			                     <i class="fa fa-user-plus" style="padding-right:5px;"></i>   
			                     <span >Accept Request</span>            
		                    </button>
						';
				}

		}else{

			

			$friend=$this->checkFriend($userId,$profileId);

			if($friend){

				return '

			                <button class="action-button-friend friends-btn" style="margin-right:10px; width:150px;"   data-profileId="'.$profileId.'">
			                     <i class="fa fa-check" style="padding-right:5px;"></i>   
			                     <span >You are Friends</span>            
		                    </button>

							 <button class="action-button-message message-btn"  data-profileId="'.$profileId.'">
			                     <i class="fa fa-envelope" style="padding-right:10px;"></i>   
			                     <span >Message</span>            
			                  </button>
						';

			}else{

				return '

						  <button class="action-button-friend send-request-btn" style="margin-right:10px; width:150px;"   data-profileId="'.$profileId.'" >
			                     <i class="fa fa-user-plus" style="padding-right:5px;"></i>   
			                     <span >Add Friend</span>            
		                    </button>
					';
			}

		}

	}

	public function sentRequest($userId,$profileId){
		$insertRequest = $this->insert('requests', array('sender' => $userId, 'receiver' => $profileId, 'requestDate' => date('Y-m-d H:i:s')));
		if($insertRequest){
			echo 'request is Sent';
		}else{
			echo 'Something went wrong brother';
		}
					 	
	}

	public function cancelRequest($userId,$profileId){
		$deleteRequest = $this->delete('requests', array('sender' => $userId, 'receiver' => $profileId));
		if($deleteRequest){
			echo 'request is canceled';
		}else{
			echo 'Something went wrong brother';
		}
	}

	public function acceptRequest($userId,$profileId){
		$addToFriendTable1= $this->insert('friends', array('userId' => $userId, 'profileId' => $profileId, 'friendOn' => date('Y-m-d H:i:s')));
		$addToFriendTable2= $this->insert('friends', array('userId' => $profileId, 'profileId' => $userId, 'friendOn' => date('Y-m-d H:i:s')));

		$stmt = $this->pdo->prepare("UPDATE `users` SET `friends` = `friends`+1 WHERE `userId` = :userId");
		$stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
		$stmt = $stmt->execute();

		$stmt1 = $this->pdo->prepare("UPDATE `users` SET `friends` = `friends`+1 WHERE `userId` = :profileId");
		$stmt1->bindParam(":profileId", $profileId, PDO::PARAM_INT);
		$stmt1 = $stmt->execute();

		if($addToFriendTable1 && $addToFriendTable2 && $stmt && $stmt1){

		
				$deleteRequest1 = $this->delete('requests', array('sender' => $userId, 'receiver' => $profileId));
				$deleteRequest2 = $this->delete('requests', array('sender' => $profileId, 'receiver' => $userId));

					if($deleteRequest1 || $deleteRequest2){
							echo 'request is accepted';
					}else{
						echo 'Something went wrong brother';
					}	

		}else{
			echo 'Something went wrong brother';
		}
	}

	public function unFriend($userId,$profileId){

			$unFriend1 = $this->delete('friends', array('userId' => $userId, 'profileId' => $profileId));
			$unFriend2 = $this->delete('friends', array('userId' => $profileId, 'profileId' => $userId));

				$stmt = $this->pdo->prepare("UPDATE `users` SET `friends` = `friends`- 1 WHERE `userId` = :userId");
				$stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
				$stmt = $stmt->execute();

				$stmt1 = $this->pdo->prepare("UPDATE `users` SET `friends` = `friends`-1 WHERE `userId` = :profileId");
				$stmt1->bindParam(":profileId", $profileId, PDO::PARAM_INT);
				$stmt1 = $stmt->execute();

			if($unFriend1 || $unFriend2 && $stmt && $stmt1){
				echo 'Unfriend Successful';
			}else{
				echo 'Something went wrong brother';
			}
	}

	// end of friend system


	
	public function getFriendsList($profileId){
			$stmt = $this->pdo->prepare("SELECT users.userId, users.firstName, users.lastName, users.friends, users.profileImage, users.coverImage FROM `users` INNER JOIN `friends` on users.userId=friends.profileId AND friends.userId=:profileId");
			$stmt->bindParam(':profileId', $profileId, PDO::PARAM_INT);
			$stmt->execute();
			$friends= $stmt->fetchAll(PDO::FETCH_OBJ);
		
			foreach($friends as $friend){
				echo '

				<div class="inner_profile" id="'.$friend->firstName.$friend->lastName.'">
					<div class="photo float"><img alt="" src="'.BASE_URL.$friend->profileImage.'" style="width:100px; height:100px;" />
					</div>
					<div class="name float"><a href="'.BASE_URL.$friend->userId.'/'.$friend->firstName.'_'.$friend->lastName.'" >'.$friend->firstName.' '.$friend->lastName.'</a></div>
					<div class="dropdown">
					 <button class="action-button-friend friend-page-action-btn account" data-ids="ye'.$friend->userId.'"style="margin-right:10px;">
	                     <i class="fa fa-check" style="padding-right:5px;"></i>   
	                     <span >Friends</span>            
                    </button>

                    	<div class="submenu" id="ye'.$friend->userId.'" style="display: none; ">
	
							  <ul class="root">
																			    
									    <li >
									      <a href="'.BASE_URL.$friend->userId.'/'.$friend->firstName.'_'.$friend->lastName.'" >'.$friend->firstName.' '.$friend->lastName.'</a>
									    </li>

									    <li >
									      <a href="#message" >Message</a>
									    </li>

									   <li >
									      <a href="#unfriend">Unfriend</a>
									    </li>
									  
							  </ul>
							</div>

						</div>
				</div>
				';
			}
	}

	public function getPostImageUrls($profileId){
			$stmt = $this->pdo->prepare("SELECT  posts.statusImage, users.userId, users.firstName, users.lastName FROM `posts` INNER JOIN `users` on users.userId=posts.postUserId AND users.userId=:profileId AND posts.statusImage is not null AND posts.privacy!=2 ORDER BY `posts`.`postId` ASC LIMIT 9");
			$stmt->bindParam(':profileId', $profileId, PDO::PARAM_INT);
			$stmt->execute();
			$friends= $stmt->fetchAll(PDO::FETCH_OBJ);
			/*echo '<pre>';
			print_r($friends);
			echo '</pre>';
			die();*/
			foreach($friends as $friend){
					echo '
						<div class="gallery">
				  		  <img src="'.BASE_URL.''.$friend->statusImage.'" />		 

						</div>					
					';

				}
		}

	public function getFriendsProfileImageUrls($profileId){
			$stmt = $this->pdo->prepare("SELECT users.userId, users.profileImage, users.firstName, users.lastName FROM `users` INNER JOIN `friends` on users.userId=friends.profileId AND friends.userId=:profileId AND users.profileImage is not null ORDER BY RAND() ASC LIMIT 9");
			$stmt->bindParam(':profileId', $profileId, PDO::PARAM_INT);
			$stmt->execute();
			$friends= $stmt->fetchAll(PDO::FETCH_OBJ);
			
			foreach($friends as $friend){
					echo '
						<div class="gallery">
						<a href="'.BASE_URL.''.$friend->userId.'/'.$friend->firstName.'_'.$friend->lastName.'">
				  		  <img src="'.BASE_URL.''.$friend->profileImage.'" />		 
				  		 </a>
						</div>					
					';

				}
	}
}
?>