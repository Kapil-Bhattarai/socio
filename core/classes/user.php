<?php

class User{
	protected $pdo;
	
 	public function __construct($pdo){											
	    $this->pdo = $pdo;
	}

	public function checkInputData($data){
		$data = htmlspecialchars($data);
		$data = trim($data);
		$data = stripcslashes($data);
		return $data;
	}

	public function login($email, $password){
		$passwordHash = md5($password);
		$stmt = $this->pdo->prepare('SELECT `userId` FROM `users` WHERE `email` = :email AND `password` = :password');
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
		$stmt->execute();

		$count = $stmt->rowCount();
		$user = $stmt->fetch(PDO::FETCH_OBJ);

		if($count > 0){
			$_SESSION['userId'] = $user->userId;
			header('Location: home.php');
		}else{
			$_SESSION['failed_email']=$email;
			return false;
		}
	}

	public function userData($userId){
		$stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `userId` = :userId');
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function logout(){
		$_SESSION = array();
		session_destroy();
		header('Location: ../index.php');
	}


	public function loggedIn(){
		return (isset($_SESSION['userId'])) ? true : false;
	}

	public function checkEmail($email){
		$stmt = $this->pdo->prepare("SELECT `email` FROM `users` WHERE `email` = :email");
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();

		$count = $stmt->rowCount();
		if($count > 0){
			return true;
		}else{
			return false;
		}
	}

	public function insert($table, $fields = array()){
		$columns = implode(',', array_keys($fields));
		$values  = ':'.implode(', :', array_keys($fields));
		$sql     = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";

		if($stmt = $this->pdo->prepare($sql)){
			foreach ($fields as $key => $data) {
				$stmt->bindValue(':'.$key, $data);
			}
			$stmt->execute();
			return $this->pdo->lastInsertId();
		}
	}


	/*  public function directInsert($email, $password){
	    $passwordHash = md5($password);
	    $stmt = $this->pdo->prepare("INSERT INTO `users` ( `firstName`, `lastName`) VALUES ( 'kapil', '');");
;
	    $stmt->execute();

	   return  $user_id = $this->pdo->lastInsertId();
	   
	  }*/

	public function update($table, $primaryKeyName, $pid, $fields){
		$columns = '';
		$i       = 1;

		foreach ($fields as $name => $value) {
			$columns .= "`{$name}` = :{$name} ";
			if($i < count($fields)){
				$columns .= ', ';
			}
			$i++;
		}
		$sql = "UPDATE {$table} SET {$columns} WHERE `$primaryKeyName` = {$pid}";
		if($stmt = $this->pdo->prepare($sql)){
			foreach ($fields as $key => $value) {
				$stmt->bindValue(':'.$key, $value);
			}
			$stmt->execute();
			if($stmt){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function delete($table, $array){
		$sql   = "DELETE FROM " . $table;
		$where = " WHERE ";

		foreach($array as $key => $value){
			$sql .= $where . $key . " = '" . $value . "'";
			$where = " AND ";
		}
		$sql .= ";";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		if($stmt){
			return true;
		}else{
			return false;
		}
	}



	public function uploadImage($file,$userId,$photoType){
 		 	$filename   = $file['name'];
			$fileTmp    = $file['tmp_name'];
			$fileSize   = $file['size'];
			$errors     = $file['error'];

 			$ext = explode('.', $filename);
			$ext = strtolower(end($ext));
 			
 			$allowed_extensions  = array('jpg','png','jpeg');
		
			if(in_array($ext, $allowed_extensions)){
				
				if($errors ===0){
					
					if($fileSize <= 2097152){

		 				$root = 'users/'.$filename;
					  	 move_uploaded_file($fileTmp, $_SERVER['DOCUMENT_ROOT'].'/socio/'.$root);
						 return $root; 

					}else{
							$GLOBALS['imgError'] = "File Size is too large";
					    }
			    }
			  }else{
						$GLOBALS['imgError'] = "Only alloewd JPG, PNG JPEG extensions";
		  	       }
 		}

 	public function timeAgo($datetime){
		$time    = strtotime($datetime);
 		$current = time();
 		$seconds = $current - $time;
 		$minutes = round($seconds / 60);
		$hours   = round($seconds / 3600);
		$months  = round($seconds / 2600640);

		if($seconds <= 60){
			if($seconds == 0){
				return 'now';
			}else{
				return $seconds.'s ago';
			}
		}else if($minutes <= 60){

			return $minutes.'m ago';

		}else if($hours <= 24){

			return $hours.'h ago';

		}else if($months <= 12){

			return date('M j', $time);

		}else{
			return date('j M Y', $time);
		}
	}

}

?>