<?php
class Message extends User{
	

 	public function __construct($pdo){
		$this->pdo = $pdo;
		
	}
}
?>