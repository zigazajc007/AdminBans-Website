<?php
require "Settings.php";

session_start();

if(!isset($_POST['username']) || !isset($_POST["password"])){
	$_SESSION["msg"] = "Missing login creditions!";
	header("Location: login.php");
	return;
}

if(Settings::$turnstile){

}

if(!array_key_exists($_POST['username'], Settings::$admin_accounts)){
	$_SESSION["msg"] = "Username is incorrect!";
	header("Location: login.php");
	return;
}

if(Settings::$admin_accounts[$_POST['username']] !== $_POST["password"]){
	$_SESSION["msg"] = "Password is incorrect!";
	header("Location: login.php");
	return;
}

$_SESSION["msg"] = "";
$_SESSION["username"] = $_POST['username'];
header("Location: panel.php");
?>
