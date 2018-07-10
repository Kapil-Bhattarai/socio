<?php

	include '../init.php'; 
    if(isset($_POST['profileId']) && !empty($_POST['profileId']) ){

    	$userId = $_SESSION['userId'];
    	$profileId= $_POST['profileId'];

    	if( isset($_POST['sendRequest'] ) && $_POST['sendRequest']==true){

    		$friendClass->sentRequest($userId,$profileId);

    	}else if( isset($_POST['cancelRequest'] ) && $_POST['cancelRequest']==true){

			$friendClass->cancelRequest($userId,$profileId);

    	}else if(isset($_POST['acceptRequest'] ) && $_POST['acceptRequest']==true){

    		$friendClass->acceptRequest($userId,$profileId);

    	}else if(isset($_POST['unfriend'] ) && $_POST['unfriend']==true){
    		$friendClass->unFriend($userId,$profileId);
    	}
    	
    	

   
   }
?>