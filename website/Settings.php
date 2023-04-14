<?php

class Settings{

	//Server name
	public static $server_name = "Server Name";

	//Database
	public static $mysql_host = "127.0.0.1";
	public static $mysql_port = "3306";
	public static $mysql_database = "AdminBans";
	public static $mysql_user = "root";
	public static $mysql_password = "";

	// Login data for Admin Bans panel (Please don't use default password)
	public static $login_username = "admin";
	public static $login_password = "d45HKmyHkQkNPGNoZxz7Dwz7i";
	// Do you want to use hCaptcha for login?
	public static $login_hcaptcha = false;
	public static $login_hcaptcha_sitekey = "Site Key Here";
	public static $login_hcaptcha_privatekey = "Private Key Here";

	//Choose default theme
	public static $default_theme = "dark";

	//How many rows can be shown at the same time?
	public static $data_limit = 50;

	//For how many seconds the data should be cached?
	public static $cache_data = 300;

	//Discord server link. Example: "https://discord.gg/hUNymXX" or null
	public static $discord_link = "Your Link Here";

	//Server store link. Example: "http://store.rabbitcraft.net" or null
	public static $store_link = "Your Link Here";

	/* Website for player heads:

		Options:
			- "https://mc-heads.net/avatar/{name}/40"
			- null

	*/
	public static $heads_link = "https://mc-heads.net/avatar/{name}/40";
}

?>