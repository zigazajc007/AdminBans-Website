<?php
include_once "Settings.php";
include_once "Utils.php";

session_start();

if(!isset($_SESSION["username"])){
	header("Location: index.php");
	return;
}

if(!isset($_GET['type']) || !isset($_GET['id']) || !isset($_GET['token'])){
	header("Location: index.php");
	return;
}

if(strlen($_GET['token']) !== 128 || $_GET['token'] !== $_SESSION["token"]){
	header("Location: index.php");
	return;
}

$validTypes = ['bans', 'mutes', 'warns', 'kicks'];
if(!in_array($_GET['type'], $validTypes)){
	header("Location: index.php");
	return;
}

$table = 'adminbans_banned_players';
if($_GET['type'] === 'mutes') $table = 'adminbans_muted_players';
if($_GET['type'] === 'warns') $table = 'adminbans_warned_players';
if($_GET['type'] === 'kicks') $table = 'adminbans_kicked_players';

if(Utils::deleteEntry($table, $_GET['id'])){
	unlink('cache.json');
}
header("Location: " .$_GET['redirect']);