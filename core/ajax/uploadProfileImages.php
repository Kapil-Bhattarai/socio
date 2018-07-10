<?php
		
			include '../init.php';

			$type = $_POST['type'];
			$userId=$_SESSION['userId'];

			if(!empty($_FILES['file']['name'][0])){

			$file 		= $_FILES['file'];
 		 	$filename   = $file['name'];
			$fileTmp    = $file['tmp_name'];
			$fileSize   = $file['size'];
			$errors     = $file['error'];
			
			

 			$ext = explode('.', $filename);
			$ext = strtolower(end($ext));
 			
 			$allowed_extensions  = array('jpg','png','jpeg');
			$result= array();
			if(in_array($ext, $allowed_extensions)){
				
				if($errors ===0){
					
					if($fileSize <= 2097152){

		 				
		 				 if($type==1){
						$root = 'users/profile/' . $filename;	
		 				 }else{
							$root = 'users/cover/' . $filename;
		 				 }
					  	 move_uploaded_file($fileTmp,$_SERVER['DOCUMENT_ROOT'].'/socio/'.$root);
					  	$update;
						 if($type==1){
						 	 $update= $userClass->update('users','userId', $userId, array('profileImage' => $root));
				 
						 }else{
							 $update= $userClass->update('users', 'userId', $userId, array('coverImage' => $root));
				 
						 }
						
						 if($update){
						 	 $result['status']='1';
						 	 $result['msg']=$root;

						 	

						 }else{
						 	$result['status']='0';
							$result['msg']='Something went Wrong ! Please Re-upload......';
						 }
					}else{
							$result['status']='0';
							$result['msg']="File Size is too large";
							
					    }
			    }else{
			    		$result['status']='0';
						$result['msg']='Something went Wrong ! Please Re-upload.';
			    }
			  }else{
			  			
						
						$result['status']='0';
						$result['msg']='Only alloewd JPG, PNG JPEG extensions';
		  	    }
		  	    echo json_encode($result);
		  	   }else{
		  	   			$result['status']='0';
						$result['msg']='Something went Wrong ! Please Re-upload.';
		  	   			echo json_encode($result);
		  	   }    
		  
?>