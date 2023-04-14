<?php
include_once "Settings.php";
include_once "Utils.php";

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
					<?php }else{ ?>
					<div class="hidden flex-1 flex items-center justify-center px-2 lg:ml-6 lg:flex lg:justify-end">
						<div id="login-nav" class="flex-shrink-0">
							<a href="panel.php" class="primaryButton px-3 py-2 rounded-md text-sm font-medium">Log in</a>
						</div>
					</div>
					<?php } ?>
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

	  <div class="table">

		  <?php if(isset($_GET["page"]) && $_GET["page"] == 'bans'){ ?>

				<h1 class="animate__animated animate__bounceInDown">Bans</h1> <?php

				$sql = "SELECT * FROM adminbans_banned_players";
				$limit = "LIMIT " . Settings::$data_limit;

				if(isset($_GET["player"]) && $_GET["player"] != ''){
					$sql = $sql . " WHERE username_to = '" . $_GET["player"] . "'";
				}

				if(isset($_GET["order"])){
					switch ($_GET["order"]) {
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
				}

				$result = Utils::executeQuery($sql);

				?><table>
					<tr>
						<th><a href="/?page=bans&order=player<?php if(isset($_GET["order"]) && $_GET["order"] == 'player'){ echo "_desc"; } ?>">Player <?php if(isset($_GET["order"]) && $_GET["order"] == 'player'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'player_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th><a href="/?page=bans&order=moderator<?php if(isset($_GET["order"]) && $_GET["order"] == 'moderator'){ echo "_desc"; } ?>">Moderator <?php if(isset($_GET["order"]) && $_GET["order"] == 'moderator'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'moderator_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th><a>Reason</a></th>
						<th><a href="/?page=bans&order=date<?php if(isset($_GET["order"]) && $_GET["order"] == 'date'){ echo "_desc"; } ?>">Date <?php if(isset($_GET["order"]) && $_GET["order"] == 'date'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'date_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th><a href="/?page=bans&order=expires<?php if(isset($_GET["order"]) && $_GET["order"] == 'expires'){ echo "_desc"; } ?>">Expires <?php if(isset($_GET["order"]) && $_GET["order"] == 'expires'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'expires_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th><a href="/?page=bans&order=expires<?php if(isset($_GET["order"]) && $_GET["order"] == 'server'){ echo "_desc"; } ?>">Server <?php if(isset($_GET["order"]) && $_GET["order"] == 'server'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'server_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					</tr>
				<?php

				for($i = 0; $i < count($result); $i++){
					?><tr>
						<td><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_to'], Settings::$heads_link); ?>" /><?php } echo " " . $result[$i]['username_to']; ?></td>
						<td><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_from'], Settings::$heads_link); ?>" /><?php } echo " " . $result[$i]['username_from']; ?></td>
						<td><?php if($result[$i]['reason'] != null) echo Utils::chatColor($result[$i]['reason']); ?></td>
						<td><?php echo $result[$i]['created']; ?></td>
						<td><?php if($result[$i]['until'] == '9999-12-31 23:59:59'){ echo 'Never'; }else{ echo $result[$i]['until']; } ?></td>
						<td><?php if($result[$i]['server'] != ""){ echo $result[$i]['server']; }else{ echo "-"; } ?></td>
					</tr>
					<?php
				}
				?></table><?php

		  }else if(isset($_GET["page"]) && $_GET["page"] == 'mutes'){ ?>

				<h1 class="animate__animated animate__bounceInDown">Mutes</h1> <?php

				$sql = "SELECT * FROM adminbans_muted_players";
				$limit = "LIMIT " . Settings::$data_limit;

				if(isset($_GET["player"]) && $_GET["player"] != ''){
					$sql = $sql . " WHERE username_to = '" . $_GET["player"] . "'";
				}

				if(isset($_GET["order"])){
					switch ($_GET["order"]) {
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
				}

				$result = Utils::executeQuery($sql);

				?><table>
					<tr>
						<th><a href="/?page=mutes&order=player<?php if(isset($_GET["order"]) && $_GET["order"] == 'player'){ echo "_desc"; } ?>">Player <?php if(isset($_GET["order"]) && $_GET["order"] == 'player'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'player_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th><a href="/?page=mutes&order=moderator<?php if(isset($_GET["order"]) && $_GET["order"] == 'moderator'){ echo "_desc"; } ?>">Moderator <?php if(isset($_GET["order"]) && $_GET["order"] == 'moderator'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'moderator_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th>Reason</th>
						<th><a href="/?page=mutes&order=date<?php if(isset($_GET["order"]) && $_GET["order"] == 'date'){ echo "_desc"; } ?>">Date <?php if(isset($_GET["order"]) && $_GET["order"] == 'date'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'date_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th><a href="/?page=mutes&order=expires<?php if(isset($_GET["order"]) && $_GET["order"] == 'expires'){ echo "_desc"; } ?>">Expires <?php if(isset($_GET["order"]) && $_GET["order"] == 'expires'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'expires_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th><a href="/?page=mutes&order=expires<?php if(isset($_GET["order"]) && $_GET["order"] == 'server'){ echo "_desc"; } ?>">Server <?php if(isset($_GET["order"]) && $_GET["order"] == 'server'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'server_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					</tr>
				<?php


				for($i = 0; $i < count($result); $i++){
				?><tr>
						<td><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_to'], Settings::$heads_link); ?>" /><?php } echo " " . $result[$i]['username_to']; ?></td>
						<td><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_from'], Settings::$heads_link); ?>" /><?php } echo " " . $result[$i]['username_from']; ?></td>
						<td><?php echo Utils::chatColor($result[$i]['reason']); ?></td>
						<td><?php echo $result[$i]['created']; ?></td>
						<td><?php echo $result[$i]['until']; ?></td>
						<td><?php if($result[$i]['server'] != ""){ echo $result[$i]['server']; }else{ echo "-"; } ?></td>
					</tr>
					<?php
				}
				?></table><?php

		  }else if(isset($_GET["page"]) && $_GET["page"] == 'warns'){ ?>
				<h1 class="animate__animated animate__bounceInDown">Warns</h1> <?php

				$sql = "SELECT * FROM adminbans_warned_players";
				$limit = "LIMIT " . Settings::$data_limit;

				if(isset($_GET["player"]) && $_GET["player"] != ''){
					$sql = $sql . " WHERE username_to = '" . $_GET["player"] . "'";
				}

				if(isset($_GET["order"])){
					switch ($_GET["order"]) {
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
				}

				$result = Utils::executeQuery($sql);

				?><table>
					<tr>
						<th><a href="/?page=warns&order=player<?php if(isset($_GET["order"]) && $_GET["order"] == 'player'){ echo "_desc"; } ?>">Player <?php if(isset($_GET["order"]) && $_GET["order"] == 'player'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'player_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th><a href="/?page=warns&order=moderator<?php if(isset($_GET["order"]) && $_GET["order"] == 'moderator'){ echo "_desc"; } ?>">Moderator <?php if(isset($_GET["order"]) && $_GET["order"] == 'moderator'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'moderator_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th>Reason</th>
						<th><a href="/?page=warns&order=date<?php if(isset($_GET["order"]) && $_GET["order"] == 'date'){ echo "_desc"; } ?>">Date <?php if(isset($_GET["order"]) && $_GET["order"] == 'date'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'date_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th><a href="/?page=warns&order=expires<?php if(isset($_GET["order"]) && $_GET["order"] == 'server'){ echo "_desc"; } ?>">Server <?php if(isset($_GET["order"]) && $_GET["order"] == 'server'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'server_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					</tr>
				<?php

				for($i = 0; $i < count($result); $i++){
					?><tr>
						<td><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_to'], Settings::$heads_link); ?>" /><?php } echo " " . $result[$i]['username_to']; ?></td>
						<td><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_from'], Settings::$heads_link); ?>" /><?php } echo " " . $result[$i]['username_from']; ?></td>
						<td><?php echo Utils::chatColor($result[$i]['reason']); ?></td>
						<td><?php echo $result[$i]['created']; ?></td>
						<td><?php if($result[$i]['server'] != ""){ echo $result[$i]['server']; }else{ echo "-"; } ?></td>
					</tr>
					<?php
				}
				?></table><?php

			}else if(isset($_GET["page"]) && $_GET["page"] == 'kicks'){ ?>
				<h1 class="animate__animated animate__bounceInDown">Kicks</h1> <?php

				$sql = "SELECT * FROM adminbans_kicked_players";
				$limit = "LIMIT " . Settings::$data_limit;

				if(isset($_GET["player"]) && $_GET["player"] != ''){
					$sql = $sql . " WHERE username_to = '" . $_GET["player"] . "'";
				}

				if(isset($_GET["order"])){
					switch ($_GET["order"]) {
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
				}

				$result = Utils::executeQuery($sql);

				?><table>
					<tr>
						<th><a href="/?page=kicks&order=player<?php if(isset($_GET["order"]) && $_GET["order"] == 'player'){ echo "_desc"; } ?>">Player <?php if(isset($_GET["order"]) && $_GET["order"] == 'player'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'player_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th><a href="/?page=kicks&order=moderator<?php if(isset($_GET["order"]) && $_GET["order"] == 'moderator'){ echo "_desc"; } ?>">Moderator <?php if(isset($_GET["order"]) && $_GET["order"] == 'moderator'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'moderator_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th>Reason</th>
						<th><a href="/?page=kicks&order=date<?php if(isset($_GET["order"]) && $_GET["order"] == 'date'){ echo "_desc"; } ?>">Date <?php if(isset($_GET["order"]) && $_GET["order"] == 'date'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'date_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						<th><a href="/?page=kicks&order=expires<?php if(isset($_GET["order"]) && $_GET["order"] == 'server'){ echo "_desc"; } ?>">Server <?php if(isset($_GET["order"]) && $_GET["order"] == 'server'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'server_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					</tr>
				<?php

				for($i = 0; $i < count($result); $i++){
					?><tr>
						<td><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_to'], Settings::$heads_link); ?>" /><?php } echo " " . $result[$i]['username_to']; ?></td>
						<td><?php if(Settings::$heads_link != null){ ?><img src="<?php echo str_replace("{name}", $result[$i]['username_from'], Settings::$heads_link); ?>" /><?php } echo " " . $result[$i]['username_from']; ?></td>
						<td><?php echo Utils::chatColor($result[$i]['reason']); ?></td>
						<td><?php echo $result[$i]['created']; ?></td>
						<td><?php if($result[$i]['server'] != ""){ echo $result[$i]['server']; }else{ echo "-"; } ?></td>
					</tr>
					<?php
				}
				?></table><?php

		  }else{
				include "main_page.php";
		  } ?>
	  </div>
		<script type="module" src="js/index.js"></script>
  </body>
</html>
