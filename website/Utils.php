<?php
include_once 'Settings.php';

class Utils{

	public static $cache = null;

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

	public static function writeCache($key, $value, $ttl = null){
		if($ttl === null) $ttl = Settings::$cache_data;

		$data = Utils::$cache;
		if($data === null){
			$data = json_decode(file_get_contents('cache.json'), true);
		}
		$data[$key] = array('value' => $value, 'expiration' => time() + $ttl);
		file_put_contents('cache.json', json_encode($data));
		Utils::$cache = $data;
	}

	public static function readCache($key){
		$data = Utils::$cache;
		if($data === null){
			$data = json_decode(file_get_contents('cache.json'), true);
			Utils::$cache = $data;
		}
		if(!isset($data[$key])) return null;
		if($data[$key]['expiration'] < time()) return null;
		return $data[$key]['value'];
	}

	public static function getRowCount($table = 'adminbans_banned_players'){

		$cachedData = Utils::readCache('row_count_' . $table);
		if($cachedData !== null) return $cachedData;

		try{
			$conn = Utils::createConnection();

			$stmt = $conn->prepare("SELECT COUNT(*) AS 'amount' FROM " . $table);
			$stmt->execute();

			$amount = $stmt->fetchColumn();
			Utils::writeCache('row_count_' . $table, $amount);
			return $amount;
		}catch(PDOException $e) {
			Utils::writeCache('row_count_' . $table, -1, 5);
			return -1;
		}
	}

	public static function executeQuery($query, $parms = []){

		$queryHash = hash('sha256', $query);

		$cachedData = Utils::readCache('query_' . $queryHash);
		if($cachedData !== null) return $cachedData;

		try{
			$conn = Utils::createConnection();

			$stmt = $conn->prepare($query);

			$keys = array_keys($parms);
			for($i = 0; $i < count($keys); $i++){
				$stmt->bindParam($keys[$i], $parms[$keys[$i]]['value'], $parms[$keys[$i]]['type']);
			}

			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			Utils::writeCache('rows_' . $queryHash, $data);
			return $data;
		}catch(PDOException $e) {
			Utils::writeCache('rows_' . $queryHash, null, 5);
			return null;
		}
	}

	public static function generateHeader($page = 'bans', $order = 'player', $name = 'Player', $curOrder = null, $type = 1){

		if($type === 0){
			return '<th scope="col" class="secondaryColor px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">' . $name . '</th>';
		}

		$ascIcon = '<svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 15l6 -6l6 6"></path></svg>';
		$descIcon = '<svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 9l6 6l6 -6"></path></svg>';

		$newOrder = (isset($curOrder) && $curOrder == $order) ? $order . '_desc' : $order;
		$html = '<th scope="col" class="secondaryColor px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"><a href="/?page=' . $page . '&order=' . $newOrder . '"><div class="flex justify-start space-x-3"><span>' . $name . '</span>';

		if(isset($curOrder) && $curOrder == $order){
			$html .= $ascIcon;
		}else if(isset($curOrder) && $curOrder == $order . '_desc'){
			$html .= $descIcon;
		}

		$html .= '</div></a></th>';

		return $html;
	}
}

?>
