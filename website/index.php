<?php
include_once "Settings.php";
include_once "Utils.php";

session_start();

$ban_count = Utils::getRowCount('adminbans_banned_players');
$mute_count = Utils::getRowCount('adminbans_muted_players');
$warn_count = Utils::getRowCount('adminbans_warned_players');
$kick_count = Utils::getRowCount('adminbans_kicked_players');

?>

<!doctype html>
<html lang="en">
  <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= Settings::$server_name ?></title>
		<meta name="author" content="Rabbit Company" />
		<link rel="shortcut icon" type="image/png" href="/images/server-icon.png"/>
		<link type="text/css" rel="stylesheet" href="/css/tailwind.min.css" />
		<link type="text/css" rel="stylesheet" href="/css/index.css" />
		<link type="text/css" rel="stylesheet" href="/css/themes/<?= Settings::$default_theme ?>.css" />
  </head>
  <body class="primaryBackgroundColor">

		<?php
			$active = 'mainMenuLinkSelected inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium';
			$inactive = 'mainMenuLink border-transparent inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium';

			$activeMobile = 'mainMenuMobileLinkSelected block pl-3 pr-4 py-2 border-l-4 text-base font-medium';
			$inactiveMobile = 'mainMenuMobileLink block pl-3 pr-4 py-2 border-l-4 text-base font-medium';
		?>

		<nav class="secondaryBackgroundColor shadow">
			<div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
				<div class="flex justify-between h-16">
					<div class="flex px-2 lg:px-0">
						<div class="flex-shrink-0 flex items-center">
							<a href="/"><img class="h-8 w-auto" width="32" height="32" src="images/server-icon.png" alt="<?= Settings::$server_name ?>"></a>
						</div>
						<div class="hidden lg:ml-6 lg:flex lg:space-x-6">
							<a href="/" class="<?php if(!isset($_GET["page"]) || $_GET["page"] == ''){ echo $active; }else{ echo $inactive; } ?>">Home</a>
							<?php if(Settings::$store_link != null){ ?>
								<a href="<?= Settings::$store_link ?>" target="_blank" class="mainMenuLink border-transparent inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Store</a>
							<?php } ?>
							<a href="/?page=bans" class="<?php if(isset($_GET["page"]) && $_GET["page"] == 'bans'){ echo $active; }else{ echo $inactive; } ?>">Bans <span class="grayBadge ml-3 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"><?= $ban_count ?></span></a>
							<a href="/?page=mutes" class="<?php if(isset($_GET["page"]) && $_GET["page"] == 'mutes'){ echo $active; }else{ echo $inactive; } ?>">Mutes <span class="grayBadge ml-3 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"><?= $mute_count ?></span></a>
							<a href="/?page=warns" class="<?php if(isset($_GET["page"]) && $_GET["page"] == 'warns'){ echo $active; }else{ echo $inactive; } ?>">Warns <span class="grayBadge ml-3 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"><?= $warn_count ?></span></a>
							<a href="/?page=kicks" class="<?php if(isset($_GET["page"]) && $_GET["page"] == 'kicks'){ echo $active; }else{ echo $inactive; } ?>">Kicks <span class="grayBadge ml-3 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"><?= $kick_count ?></span></a>
							<?php if(Settings::$discord_link != null){ ?>
								<a href="<?= Settings::$discord_link ?>" target="_blank" class="mainMenuLink border-transparent inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Discord</a>
							<?php } ?>
						</div>
					</div>
					<?php if(!empty($_GET)){ ?>
					<div class="flex-1 flex items-center justify-center px-2 lg:ml-6 lg:justify-end">
            <div class="flex-shrink-0">
              <span class="relative z-0 inline-flex shadow-sm rounded-md">
                <input type="text" id="search" class="relative inline-flex shadow focus:outline-none px-4 py-2 sm:text-sm rounded-md" enterKeyHint="Done" placeholder="Search">
              </span>
            </div>
          </div>
					<?php }else{
						if(isset($_SESSION["username"])){ ?>
							<div class="hidden flex-1 flex items-center justify-center px-2 lg:ml-6 lg:flex lg:justify-end">
								<div class="flex-shrink-0">
									<a href="logout.php" class="tertiaryColor px-3 py-2 rounded-md text-sm font-medium">Log out</a>
								</div>
							</div>
						<?php }else{ ?>
							<div class="hidden flex-1 flex items-center justify-center px-2 lg:ml-6 lg:flex lg:justify-end">
								<div class="flex-shrink-0">
									<a href="login.php" class="primaryButton px-3 py-2 rounded-md text-sm font-medium">Log in</a>
								</div>
							</div>
						<?php }
					} ?>
					<div class="flex items-center lg:hidden">
						<button id="menu-toggle-btn" type="button" class="main-menu-toggle-btn inline-flex items-center justify-center p-2 rounded-md focus:outline-none" aria-controls="mobile-menu" aria-expanded="false">
							<span class="sr-only">Open main menu</span>
							<svg id="mobile-menu-icon" xmlns="http://www.w3.org/2000/svg" class="block h-6 w-6" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
								<line x1="4" y1="6" x2="20" y2="6" />
								<line x1="4" y1="12" x2="20" y2="12" />
								<line x1="4" y1="18" x2="20" y2="18" />
							</svg>
						</button>
					</div>
				</div>
			</div>

			<div class="lg:hidden">
				<div id="mobile-menu" class="hidden pt-2 pb-3 space-y-1">
					<a href="/" class="<?php if(!isset($_GET["page"]) || $_GET["page"] == ''){ echo $activeMobile; }else{ echo $inactiveMobile; } ?>">Home</a>
					<?php if(Settings::$store_link != null){ ?>
						<a href="<?= Settings::$store_link ?>" target="_blank" class="mainMenuMobileLink block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Store</a>
					<?php } ?>
					<a href="/?page=bans" class="<?php if(isset($_GET["page"]) && $_GET["page"] == 'bans'){ echo $activeMobile; }else{ echo $inactiveMobile; } ?>">Bans <span class="grayBadge ml-3 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"><?= $ban_count ?></span></a>
					<a href="/?page=mutes" class="<?php if(isset($_GET["page"]) && $_GET["page"] == 'mutes'){ echo $activeMobile; }else{ echo $inactiveMobile; } ?>">Mutes <span class="grayBadge ml-3 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"><?= $mute_count ?></span></a>
					<a href="/?page=warns" class="<?php if(isset($_GET["page"]) && $_GET["page"] == 'warns'){ echo $activeMobile; }else{ echo $inactiveMobile; } ?>">Warns <span class="grayBadge ml-3 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"><?= $warn_count ?></span></a>
					<a href="/?page=kicks" class="<?php if(isset($_GET["page"]) && $_GET["page"] == 'kicks'){ echo $activeMobile; }else{ echo $inactiveMobile; } ?>">Kicks <span class="grayBadge ml-3 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"><?= $kick_count ?></span></a>
					<?php if(Settings::$discord_link != null){ ?>
						<a href="<?= Settings::$discord_link ?>" target="_blank" class="mainMenuMobileLink block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Discord</a>
					<?php } ?>
				</div>
			</div>
		</nav>

		<div class="mx-auto mt-10 mb-20 px-2 sm:px-6 lg:px-8">
		<div class="max-w-7xl mx-auto">

		  <?php if(isset($_GET["page"]) && $_GET["page"] == 'bans'){ ?>

				<h1 class="text-2xl font-medium mb-2 leading-6 tertiaryColor">Bans</h1>

				<?php
				$sql = "SELECT * FROM adminbans_banned_players";
				$limit = "LIMIT " . Settings::$data_limit;
				$order = (isset($_GET["order"])) ? $_GET["order"] : null;
				$parms = [];

				if(isset($_GET["player"]) && $_GET["player"] != ''){
					$parms[':player'] = [ 'value' => $_GET["player"], 'type' => PDO::PARAM_STR];
					$sql = $sql . " WHERE username_to = :player";
				}else if(isset($_GET["moderator"]) && $_GET["moderator"] != ''){
					$parms[':moderator'] = [ 'value' => $_GET["moderator"], 'type' => PDO::PARAM_STR];
					$sql = $sql . " WHERE username_from = :moderator";
				}else if(isset($_GET["server"]) && $_GET["server"] != ''){
					$parms[':server'] = [ 'value' => $_GET["server"], 'type' => PDO::PARAM_STR];
					$sql = $sql . " WHERE server = :server";
				}

				switch ($order) {
					case 'player':
						$sql = $sql . " ORDER BY username_to " . $limit;
						break;
					case 'player_desc':
						$sql = $sql . " ORDER BY username_to desc " . $limit;
						break;
					case 'moderator':
						$sql = $sql . " ORDER BY username_from " . $limit;
						break;
					case 'moderator_desc':
						$sql = $sql . " ORDER BY username_from desc " . $limit;
						break;
					case 'date':
						$sql = $sql . " ORDER BY created " . $limit;
						break;
					case 'date_desc':
						$sql = $sql . " ORDER BY created desc " . $limit;
						break;
					case 'expires':
						$sql = $sql . " ORDER BY until " . $limit;
						break;
					case 'expires_desc':
						$sql = $sql . " ORDER BY until desc " . $limit;
						break;
					case 'server':
						$sql = $sql . " ORDER BY until " . $limit;
						break;
					case 'server_desc':
						$sql = $sql . " ORDER BY until desc " . $limit;
						break;
					default:
						$sql = $sql . " " . $limit;
						break;
				}

				$result = Utils::executeQuery($sql, $parms);
				?>

				<div class="flex flex-col">
				<div class="-my-2 overflow-x-auto -mx-2">
				<div class="py-2 align-middle inline-block min-w-full px-2">
				<div class="shadow overflow-hidden border-b passwordsBorderColor rounded-lg">
				<table class="min-w-full divide-y passwordsBorderColor table-fixed">
					<thead class="secondaryBackgroundColor">
						<tr>
							<?php
								echo Utils::generateHeader('bans', 'player', 'Player', $order);
								echo Utils::generateHeader('bans', 'moderator', 'Moderator', $order);
								echo Utils::generateHeader('bans', 'reason', 'Reason', $order, 0);
								echo Utils::generateHeader('bans', 'date', 'Date', $order);
								echo Utils::generateHeader('bans', 'expires', 'Expires', $order);
								if(Settings::$show_servers) echo Utils::generateHeader('bans', 'server', 'Server', $order);
								if(isset($_SESSION["username"])) echo '<th scope="col" class="secondaryColor px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Delete</th>';
							?>
						</tr>
					</thead>
					<tbody class="secondaryBackgroundColor divide-y passwordsBorderColor">
					<?php
						for($i = 0; $i < count($result); $i++){
							?><tr class='passwordsBorderColor'>
								<td class="tertiaryColor py-4 px-4"><a href="/?page=bans&player=<?= $result[$i]['username_to'] ?>"><div class="flex justify-start space-x-3"><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_to'], Settings::$heads_link); ?>" /><?php } echo "<span class='mt-auto mb-auto'>" . $result[$i]['username_to']; ?></span></div></a></td>
								<td class="tertiaryColor py-4 px-4"><a href="/?page=bans&moderator=<?= $result[$i]['username_from'] ?>"><div class="flex justify-start space-x-3"><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_from'], Settings::$heads_link); ?>" /><?php } echo "<span class='mt-auto mb-auto'>" . $result[$i]['username_from']; ?></span></div></a></td>
								<td class="tertiaryColor py-4 px-4"><?php if($result[$i]['reason'] != null) echo Utils::chatColor($result[$i]['reason']); ?></td>
								<td class="tertiaryColor py-4 px-4 whitespace-nowrap"><?php echo $result[$i]['created']; ?></td>
								<td class="tertiaryColor py-4 px-4 whitespace-nowrap"><?php if($result[$i]['until'] == '9999-12-31 23:59:59'){ echo 'Never'; }else{ echo $result[$i]['until']; } ?></td>
								<?php if(Settings::$show_servers){ ?>
									<td class="tertiaryColor py-4 px-4 whitespace-nowrap"><a href="/?page=bans&server=<?= $result[$i]['server'] ?>"><?php if($result[$i]['server'] != ""){ echo $result[$i]['server']; }else{ echo "-"; } ?></a></td>
								<?php } ?>
								<?php
								if(isset($_SESSION["username"])) echo "<td class='px-4 py-4 whitespace-nowrap'><a href='delete_entry.php?type=bans&id=" . $result[$i]['id'] . "&token=" . $_SESSION["token"] . "&redirect=" . urlencode($_SERVER['REQUEST_URI']) . "' class='dangerButton cursor-pointer px-3 py-2 rounded-md text-sm font-medium'>Delete</a></td>";
								?>
							</tr>
							<?php
						}?>
					</tbody>
				</table>
				</div>
				</div>
				</div>
				</div>
			<?php
		  }else if(isset($_GET["page"]) && $_GET["page"] == 'mutes'){ ?>

				<h1 class="text-2xl font-medium mb-2 leading-6 tertiaryColor">Mutes</h1>

				<?php
				$sql = "SELECT * FROM adminbans_muted_players";
				$limit = "LIMIT " . Settings::$data_limit;
				$order = (isset($_GET["order"])) ? $_GET["order"] : null;
				$parms = [];

				if(isset($_GET["player"]) && $_GET["player"] != ''){
					$parms[':player'] = [ 'value' => $_GET["player"], 'type' => PDO::PARAM_STR];
					$sql = $sql . " WHERE username_to = :player";
				}else if(isset($_GET["moderator"]) && $_GET["moderator"] != ''){
					$parms[':moderator'] = [ 'value' => $_GET["moderator"], 'type' => PDO::PARAM_STR];
					$sql = $sql . " WHERE username_from = :moderator";
				}else if(isset($_GET["server"]) && $_GET["server"] != ''){
					$parms[':server'] = [ 'value' => $_GET["server"], 'type' => PDO::PARAM_STR];
					$sql = $sql . " WHERE server = :server";
				}

				switch ($order) {
					case 'player':
						$sql = $sql . " ORDER BY username_to " . $limit;
						break;
					case 'player_desc':
						$sql = $sql . " ORDER BY username_to desc " . $limit;
						break;
					case 'moderator':
						$sql = $sql . " ORDER BY username_from " . $limit;
						break;
					case 'moderator_desc':
						$sql = $sql . " ORDER BY username_from desc " . $limit;
						break;
					case 'date':
						$sql = $sql . " ORDER BY created " . $limit;
						break;
					case 'date_desc':
						$sql = $sql . " ORDER BY created desc " . $limit;
						break;
					case 'expires':
						$sql = $sql . " ORDER BY until " . $limit;
						break;
					case 'expires_desc':
						$sql = $sql . " ORDER BY until desc " . $limit;
						break;
					case 'server':
						$sql = $sql . " ORDER BY until " . $limit;
						break;
					case 'server_desc':
						$sql = $sql . " ORDER BY until desc " . $limit;
						break;
					default:
						$sql = $sql . " " . $limit;
						break;
				}

				$result = Utils::executeQuery($sql, $parms);
				?>

				<div class="flex flex-col">
				<div class="-my-2 overflow-x-auto -mx-2">
				<div class="py-2 align-middle inline-block min-w-full px-2">
				<div class="shadow overflow-hidden border-b passwordsBorderColor rounded-lg">
				<table class="min-w-full divide-y passwordsBorderColor table-fixed">
					<thead class="secondaryBackgroundColor">
						<tr>
							<?php
								echo Utils::generateHeader('mutes', 'player', 'Player', $order);
								echo Utils::generateHeader('mutes', 'moderator', 'Moderator', $order);
								echo Utils::generateHeader('mutes', 'reason', 'Reason', $order, 0);
								echo Utils::generateHeader('mutes', 'date', 'Date', $order);
								echo Utils::generateHeader('mutes', 'expires', 'Expires', $order);
								if(Settings::$show_servers) echo Utils::generateHeader('mutes', 'server', 'Server', $order);
								if(isset($_SESSION["username"])) echo '<th scope="col" class="secondaryColor px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Delete</th>';
							?>
						</tr>
					</thead>
					<tbody class="secondaryBackgroundColor divide-y passwordsBorderColor">
				<?php
						for($i = 0; $i < count($result); $i++){
							?><tr class='passwordsBorderColor'>
								<td class="tertiaryColor py-4 px-4"><a href="/?page=mutes&player=<?= $result[$i]['username_to'] ?>"><div class="flex justify-start space-x-3"><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_to'], Settings::$heads_link); ?>" /><?php } echo "<span class='mt-auto mb-auto'>" . $result[$i]['username_to']; ?></span></div></a></td>
								<td class="tertiaryColor py-4 px-4"><a href="/?page=mutes&moderator=<?= $result[$i]['username_from'] ?>"><div class="flex justify-start space-x-3"><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_from'], Settings::$heads_link); ?>" /><?php } echo "<span class='mt-auto mb-auto'>" . $result[$i]['username_from']; ?></span></div></a></td>
								<td class="tertiaryColor py-4 px-4"><?php if($result[$i]['reason'] != null) echo Utils::chatColor($result[$i]['reason']); ?></td>
								<td class="tertiaryColor py-4 px-4 whitespace-nowrap"><?php echo $result[$i]['created']; ?></td>
								<td class="tertiaryColor py-4 px-4 whitespace-nowrap"><?php if($result[$i]['until'] == '9999-12-31 23:59:59'){ echo 'Never'; }else{ echo $result[$i]['until']; } ?></td>
								<?php if(Settings::$show_servers){ ?>
									<td class="tertiaryColor py-4 px-4 whitespace-nowrap"><a href="/?page=mutes&server=<?= $result[$i]['server'] ?>"><?php if($result[$i]['server'] != ""){ echo $result[$i]['server']; }else{ echo "-"; } ?></a></td>
								<?php } ?>
								<?php
								if(isset($_SESSION["username"])) echo "<td class='px-4 py-4 whitespace-nowrap'><a href='delete_entry.php?type=mutes&id=" . $result[$i]['id'] . "&token=" . $_SESSION["token"] . "&redirect=" . urlencode($_SERVER['REQUEST_URI']) . "' class='dangerButton cursor-pointer px-3 py-2 rounded-md text-sm font-medium'>Delete</a></td>";
								?>
							</tr>
							<?php
						}?>
					</tbody>
				</table>
				</div>
				</div>
				</div>
				</div>
			<?php
		  }else if(isset($_GET["page"]) && $_GET["page"] == 'warns'){ ?>

				<h1 class="text-2xl font-medium mb-2 leading-6 tertiaryColor">Warns</h1>

				<?php
				$sql = "SELECT * FROM adminbans_warned_players";
				$limit = "LIMIT " . Settings::$data_limit;
				$order = (isset($_GET["order"])) ? $_GET["order"] : null;
				$parms = [];

				if(isset($_GET["player"]) && $_GET["player"] != ''){
					$parms[':player'] = [ 'value' => $_GET["player"], 'type' => PDO::PARAM_STR];
					$sql = $sql . " WHERE username_to = :player";
				}else if(isset($_GET["moderator"]) && $_GET["moderator"] != ''){
					$parms[':moderator'] = [ 'value' => $_GET["moderator"], 'type' => PDO::PARAM_STR];
					$sql = $sql . " WHERE username_from = :moderator";
				}else if(isset($_GET["server"]) && $_GET["server"] != ''){
					$parms[':server'] = [ 'value' => $_GET["server"], 'type' => PDO::PARAM_STR];
					$sql = $sql . " WHERE server = :server";
				}

				switch ($order) {
					case 'player':
						$sql = $sql . " ORDER BY username_to " . $limit;
						break;
					case 'player_desc':
						$sql = $sql . " ORDER BY username_to desc " . $limit;
						break;
					case 'moderator':
						$sql = $sql . " ORDER BY username_from " . $limit;
						break;
					case 'moderator_desc':
						$sql = $sql . " ORDER BY username_from desc " . $limit;
						break;
					case 'date':
						$sql = $sql . " ORDER BY created " . $limit;
						break;
					case 'date_desc':
						$sql = $sql . " ORDER BY created desc " . $limit;
						break;
					case 'server':
						$sql = $sql . " ORDER BY until " . $limit;
						break;
					case 'server_desc':
						$sql = $sql . " ORDER BY until desc " . $limit;
						break;
					default:
						$sql = $sql . " " . $limit;
						break;
				}

				$result = Utils::executeQuery($sql, $parms);
				?>

				<div class="flex flex-col">
				<div class="-my-2 overflow-x-auto -mx-2">
				<div class="py-2 align-middle inline-block min-w-full px-2">
				<div class="shadow overflow-hidden border-b passwordsBorderColor rounded-lg">
				<table class="min-w-full divide-y passwordsBorderColor table-fixed">
					<thead class="secondaryBackgroundColor">
						<tr>
							<?php
								echo Utils::generateHeader('warns', 'player', 'Player', $order);
								echo Utils::generateHeader('warns', 'moderator', 'Moderator', $order);
								echo Utils::generateHeader('warns', 'reason', 'Reason', $order, 0);
								echo Utils::generateHeader('warns', 'date', 'Date', $order);
								if(Settings::$show_servers) echo Utils::generateHeader('warns', 'server', 'Server', $order);
								if(isset($_SESSION["username"])) echo '<th scope="col" class="secondaryColor px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Delete</th>';
							?>
						</tr>
					</thead>
					<tbody class="secondaryBackgroundColor divide-y passwordsBorderColor">
					<?php
						for($i = 0; $i < count($result); $i++){
							?><tr class='passwordsBorderColor'>
								<td class="tertiaryColor py-4 px-4"><a href="/?page=warns&player=<?= $result[$i]['username_to'] ?>"><div class="flex justify-start space-x-3"><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_to'], Settings::$heads_link); ?>" /><?php } echo "<span class='mt-auto mb-auto'>" . $result[$i]['username_to']; ?></span></div></a></td>
								<td class="tertiaryColor py-4 px-4"><a href="/?page=warns&moderator=<?= $result[$i]['username_from'] ?>"><div class="flex justify-start space-x-3"><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_from'], Settings::$heads_link); ?>" /><?php } echo "<span class='mt-auto mb-auto'>" . $result[$i]['username_from']; ?></span></div></a></td>
								<td class="tertiaryColor py-4 px-4"><?php if($result[$i]['reason'] != null) echo Utils::chatColor($result[$i]['reason']); ?></td>
								<td class="tertiaryColor py-4 px-4 whitespace-nowrap"><?php echo $result[$i]['created']; ?></td>
								<?php if(Settings::$show_servers){ ?>
									<td class="tertiaryColor py-4 px-4 whitespace-nowrap"><a href="/?page=warns&server=<?= $result[$i]['server'] ?>"><?php if($result[$i]['server'] != ""){ echo $result[$i]['server']; }else{ echo "-"; } ?></a></td>
								<?php } ?>
								<?php
								if(isset($_SESSION["username"])) echo "<td class='px-4 py-4 whitespace-nowrap'><a href='delete_entry.php?type=warns&id=" . $result[$i]['id'] . "&token=" . $_SESSION["token"] . "&redirect=" . urlencode($_SERVER['REQUEST_URI']) . "' class='dangerButton cursor-pointer px-3 py-2 rounded-md text-sm font-medium'>Delete</a></td>";
								?>
							</tr>
							<?php
						}?>
					</tbody>
				</table>
				</div>
				</div>
				</div>
				</div>
			<?php
			}else if(isset($_GET["page"]) && $_GET["page"] == 'kicks'){ ?>

				<h1 class="text-2xl font-medium mb-2 leading-6 tertiaryColor">Kicks</h1>

				<?php
				$sql = "SELECT * FROM adminbans_kicked_players";
				$limit = "LIMIT " . Settings::$data_limit;
				$order = (isset($_GET["order"])) ? $_GET["order"] : null;
				$parms = [];

				if(isset($_GET["player"]) && $_GET["player"] != ''){
					$parms[':player'] = [ 'value' => $_GET["player"], 'type' => PDO::PARAM_STR];
					$sql = $sql . " WHERE username_to = :player";
				}else if(isset($_GET["moderator"]) && $_GET["moderator"] != ''){
					$parms[':moderator'] = [ 'value' => $_GET["moderator"], 'type' => PDO::PARAM_STR];
					$sql = $sql . " WHERE username_from = :moderator";
				}else if(isset($_GET["server"]) && $_GET["server"] != ''){
					$parms[':server'] = [ 'value' => $_GET["server"], 'type' => PDO::PARAM_STR];
					$sql = $sql . " WHERE server = :server";
				}

				switch ($order) {
					case 'player':
						$sql = $sql . " ORDER BY username_to " . $limit;
						break;
					case 'player_desc':
						$sql = $sql . " ORDER BY username_to desc " . $limit;
						break;
					case 'moderator':
						$sql = $sql . " ORDER BY username_from " . $limit;
						break;
					case 'moderator_desc':
						$sql = $sql . " ORDER BY username_from desc " . $limit;
						break;
					case 'date':
						$sql = $sql . " ORDER BY created " . $limit;
						break;
					case 'date_desc':
						$sql = $sql . " ORDER BY created desc " . $limit;
						break;
					case 'server':
						$sql = $sql . " ORDER BY until " . $limit;
						break;
					case 'server_desc':
						$sql = $sql . " ORDER BY until desc " . $limit;
						break;
					default:
						$sql = $sql . " " . $limit;
						break;
				}

				$result = Utils::executeQuery($sql, $parms);
				?>

				<div class="flex flex-col">
				<div class="-my-2 overflow-x-auto -mx-2">
				<div class="py-2 align-middle inline-block min-w-full px-2">
				<div class="shadow overflow-hidden border-b passwordsBorderColor rounded-lg">
				<table class="min-w-full divide-y passwordsBorderColor table-fixed">
					<thead class="secondaryBackgroundColor">
						<tr>
							<?php
								echo Utils::generateHeader('kicks', 'player', 'Player', $order);
								echo Utils::generateHeader('kicks', 'moderator', 'Moderator', $order);
								echo Utils::generateHeader('kicks', 'reason', 'Reason', $order, 0);
								echo Utils::generateHeader('kicks', 'date', 'Date', $order);
								if(Settings::$show_servers) echo Utils::generateHeader('kicks', 'server', 'Server', $order);
								if(isset($_SESSION["username"])) echo '<th scope="col" class="secondaryColor px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Delete</th>';
							?>
						</tr>
					</thead>
					<tbody class="secondaryBackgroundColor divide-y passwordsBorderColor">
					<?php
						for($i = 0; $i < count($result); $i++){
							?><tr class='passwordsBorderColor'>
								<td class="tertiaryColor py-4 px-4"><a href="/?page=kicks&player=<?= $result[$i]['username_to'] ?>"><div class="flex justify-start space-x-3"><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_to'], Settings::$heads_link); ?>" /><?php } echo "<span class='mt-auto mb-auto'>" . $result[$i]['username_to']; ?></span></div></a></td>
								<td class="tertiaryColor py-4 px-4"><a href="/?page=kicks&moderator=<?= $result[$i]['username_from'] ?>"><div class="flex justify-start space-x-3"><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_from'], Settings::$heads_link); ?>" /><?php } echo "<span class='mt-auto mb-auto'>" . $result[$i]['username_from']; ?></span></div></a></td>
								<td class="tertiaryColor py-4 px-4"><?php if($result[$i]['reason'] != null) echo Utils::chatColor($result[$i]['reason']); ?></td>
								<td class="tertiaryColor py-4 px-4 whitespace-nowrap"><?php echo $result[$i]['created']; ?></td>
								<?php if(Settings::$show_servers){ ?>
									<td class="tertiaryColor py-4 px-4 whitespace-nowrap"><a href="/?page=kicks&server=<?= $result[$i]['server'] ?>"><?php if($result[$i]['server'] != ""){ echo $result[$i]['server']; }else{ echo "-"; } ?></a></td>
								<?php } ?>
								<?php
								if(isset($_SESSION["username"])) echo "<td class='px-4 py-4 whitespace-nowrap'><a href='delete_entry.php?type=kicks&id=" . $result[$i]['id'] . "&token=" . $_SESSION["token"] . "&redirect=" . urlencode($_SERVER['REQUEST_URI']) . "' class='dangerButton cursor-pointer px-3 py-2 rounded-md text-sm font-medium'>Delete</a></td>";
								?>
							</tr>
							<?php
						}?>
					</tbody>
				</table>
				<div>
				<div>
				<div>
				<div>
			<?php
		  }else{
				include "main_page.php";
		  } ?>
	  </div>
		</div>

		<div id="dialog" class="hidden h-screen w-full fixed left-0 top-0 flex justify-center items-center z-10 inset-0 overflow-y-auto" aria-labelledby="dialog-title" role="dialog" aria-modal="true">
			<div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
			<span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
			<div class="secondaryBackgroundColor inline-block align-bottom rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all m-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
				<div class="sm:flex sm:items-start">
					<div id="dialog-icon" class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
						<svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
						</svg>
					</div>
					<div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
						<h3 class="tertiaryColor text-lg leading-6 font-medium" id="dialog-title"></h3>
						<div class="mt-2">
							<p class="secondaryColor text-sm" id="dialog-text"></p>
						</div>
					</div>
				</div>
				<div class="mt-5 sm:mt-4 sm:ml-10 sm:pl-4 sm:flex">
					<button id="dialog-button" type="button" class="dangerButton inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium focus:outline-none sm:w-auto sm:text-sm">
						Okay
					</button>
					<button id="dialog-button-cancel" type="button" class="cancelButton mt-2 w-full inline-flex justify-center rounded-md border px-4 py-2 text-base font-medium shadow-sm focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
						Cancel
					</button>
				</div>
			</div>
		</div>

		<script type="module" src="js/index.js"></script>
  </body>
</html>
