<?php
require "settings.php";

session_start();

if (isset($_POST['username']) && isset($_POST["password"])) {

	$_SESSION["msg"] = "";

if($login_hcaptcha){
	$responseKey = $_POST['h-captcha-response'];

	$url = 'https://hcaptcha.com/siteverify?secret='.$login_hcaptcha.'&response='.$responseKey;
	$response = file_get_contents($url);
	$response = json_decode($response);

	if($response->success){



	}else{
		$_SESSION["msg"] = "Please complete the captcha!";
		$_SESSION["color"] = "alert-danger";
		header("Location: panel.php");
	}
}else{
	if($_POST['username'] == $login_username){
		if($_POST["password"] == $login_password){
			$_SESSION["username"] = $_POST['username'];
			header("Location: panel.php");
		}else{
			$_SESSION["msg"] = "Password is incorrect!";
			$_SESSION["color"] = "alert-danger";
			header("Location: panel.php");
		}
	}else{
		$_SESSION["msg"] = "Username is incorrect!";
		$_SESSION["color"] = "alert-danger";
		header("Location: panel.php");
	}
}
}else{
	$_SESSION["msg"] = "Missing login creditions!";
	$_SESSION["color"] = "alert-danger";
	header("Location: panel.php");
}
?>
