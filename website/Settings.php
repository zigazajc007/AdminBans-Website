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
	public static $admin_accounts = [
		"admin" => "d45HKmyHkQkNPGNoZxz7Dwz7i",
		"admin2" => "vn5QkeDq3AkVzP8vpCP84bW8m",
	];

	// Do you want to use Turnstile (Captcha) for admin logins (Mitigate brute force attacks)?
	public static $turnstile = false;
	public static $turnstile_sitekey = "1x00000000000000000000AA";
	public static $turnstile_privatekey = "1x0000000000000000000000000000000AA";

	//Choose default theme
	public static $default_theme = "dark";

	//How many rows can be shown at the same time?
	public static $data_limit = 50;

	//For how many seconds the data should be cached?
	public static $cache_data = 300;

	//Should servers be shown in the table?
	public static $show_servers = false;

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