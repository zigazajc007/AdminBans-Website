<?php
include_once "Settings.php";
include_once "Utils.php";

session_start();

if(!isset($_POST['username']) || !isset($_POST["password"])){
	$_SESSION["msg"] = "Missing login creditions!";
	header("Location: login.php");
	return;
}

if(Settings::$turnstile){
	$data = array(
		'secret' => Settings::$turnstile_privatekey,
		'response' => $_POST['cf-turnstile-response'],
		'remoteip' => Utils::getUserIpAddress()
	);

	$verify = curl_init();
	curl_setopt($verify, CURLOPT_URL, "https://challenges.cloudflare.com/turnstile/v0/siteverify");
	curl_setopt($verify, CURLOPT_POST, true);
	curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($verify);

	$responseData = json_decode($response);
	if(!$responseData->success){
		$_SESSION["msg"] = "Captcha is invalid!";
		header("Location: login.php");
		return;
	}
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

unset($_SESSION["msg"]);
$_SESSION["username"] = $_POST['username'];
$_SESSION["token"] = bin2hex(random_bytes(64));
header("Location: index.php");
?>
