<?php 
	session_start();

	include 'database/connection.ini.php';

	include 'classes/user.php';
	include 'classes/friend.php';
	include 'classes/message.php';
	include 'classes/post.php';
	

  	global $pdo;

  	$userClass = new User($pdo);
  	$friendClass = new Friend($pdo);
    $postClass = new Post($pdo);
    $messageClass = new Message($pdo);
  
  	define('BASE_URL', 'http://localhost/socio/');


 ?>                                                   
 