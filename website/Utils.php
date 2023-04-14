<?php
include_once 'Settings.php';

class Utils{
	public static function chatColor($text){

		if (strpos($text, '&') !== false) {
			$text = str_replace('&0', "<strong style='color: #000;'>", $text);
			$text = str_replace('&1', "<strong style='color: #00A;'>", $text);
			$text = str_replace('&2', "<strong style='color: #0A0;'>", $text);
			$text = str_replace('&3', "<strong style='color: #0AA;'>", $text);
			$text = str_replace('&4', "<strong style='color: #A00;'>", $text);
			$text = str_replace('&5', "<strong style='color: #A0A;'>", $text);
			$text = str_replace('&6', "<strong style='color: #FA0;'>", $text);
			$text = str_replace('&7', "<strong style='color: #AAA;'>", $text);
			$text = str_replace('&8', "<strong style='color: #555;'>", $text);
			$text = str_replace('&9', "<strong style='color: #55F;'>", $text);
			$text = str_replace('&a', "<strong style='color: #5F5;'>", $text);
			$text = str_replace('&b', "<strong style='color: #5FF;'>", $text);
			$text = str_replace('&c', "<strong style='color: #F55;'>", $text);
			$text = str_replace('&d', "<strong style='color: #F5F;'>", $text);
			$text = str_replace('&e', "<strong style='color: #FF5;'>", $text);
			$text = str_replace('&f', "<strong style='color: #FFF;'>", $text);
			$text = str_replace('&g', "<strong style='color: #DDD605;'>", $text);

			$text = str_replace('&k', "", $text);
			$text = str_replace('&l', "", $text);
			$text = str_replace('&m', "", $text);
			$text = str_replace('&n', "", $text);
			$text = str_replace('&o', "", $text);
			$text = str_replace('&r', "", $text);
		}
		return $text;
	}

	public static function createConnection(){
		$conn = null;
		try{
			$conn = new PDO('mysql:host=' . Settings::$mysql_host . ';port=' . Settings::$mysql_port . ';dbname=' . Settings::$mysql_database, Settings::$mysql_user, Settings::$mysql_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die("Connection failed: " . $e->getMessage());
		}
		return $conn;
	}

	public static function writeCache($key, $value, $ttl = 60){
		$data = json_decode(file_get_contents('cache.json'), true);
		$data[$key] = array('value' => $value, 'expiration' => time() + $ttl);
		file_put_contents('cache.json', json_encode($data));
	}

	public static function readCache($key){
		$data = json_decode(file_get_contents('cache.json'), true);
		return $data[$key]['value'];
	}

	public static function getRowCount($table = 'adminbans_banned_players', $cache = 60){

		return Utils::readCache('row_count_' . $table);

		try{
			$conn = Utils::createConnection();

			$stmt = $conn->prepare("SELECT COUNT(*) AS 'amount' FROM " . $table);
			$stmt->execute();

			$amount = $stmt->fetchColumn();
			Utils::writeCache('row_count_' . $table, $amount, $cache);
			return $amount;
		}catch(PDOException $e) {
			Utils::writeCache('row_count_' . $table, -1, 5);
			return -1;
		}
	}
}

?>
