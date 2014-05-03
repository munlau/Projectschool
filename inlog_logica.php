<?php
include_once ("classes/user.class.php");
session_start();
$_SESSION['loggedin']=FALSE;

$feedback="";
if (isset($_POST['btnregister'])) {
	try{
	$user = new User();
	$user -> Username = $_POST['username'];
	$user -> Email = $_POST['email'];
	$user -> Password = $_POST['password'];
	$user -> Save();
	}catch (Exception $e)
	{
		$feedback=$e->getMessage();
	}


	}

if (isset($_POST['btnlogin'])) {
	$user = new User();
	$user -> Username = $_POST['name'];
	$user -> Password = $_POST['loginpassword'];
	$user -> canLogin();
}




?>