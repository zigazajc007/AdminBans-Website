<?php

class Settings{

	//Server name
	public static $server_name = "Server Name";

	//Database
	public static $mysql_host = "fi1.rabbit-hosting.com";
	public static $mysql_port = "3306";
	public static $mysql_database = "s182_adminbans";
	public static $mysql_user = "u182_EphvwweB8S";
	public static $mysql_password = "EuHa^!6hNtp3erOs4KjS8HCd";

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
	public static $data_limit = 10;

	//Discord server link. Example: "https://discord.gg/hUNymXX" or null
	public static $discord_link = "Your Link Here";

	//Server store link. Example: "http://store.rabbitcraft.net" or null
	public static $store_link = "Your Link Here";

	/* Website for player heads:

		Options:
			- "https://crafatar.com/avatars/{uuid}?size=20"
			- "http://cravatar.eu/avatar/{uuid}/20.png"
			- "https://mc-heads.net/avatar/{uuid}/20"
			- "https://minotar.net/avatar/{uuid}/20"
			- "https://visage.surgeplay.com/face/20/{uuid}"
			- null

	*/
	public static $heads_link = "https://crafatar.com/avatars/{uuid}?size=20";
}

?>
