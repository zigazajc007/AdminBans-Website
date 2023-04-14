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
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/ico" href="images/server-icon.png" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="themes/<?php echo Settings::$default_theme; ?>.css" />
	<link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/animate.css">
	<title><?php echo Settings::$server_name; ?></title>
	<script src="https://kit.fontawesome.com/445ee3669f.js" crossorigin="anonymous"></script>
  </head>
  <body>
	  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <a class="navbar-brand" href="#">
			<img src="images/server-icon.png" width="30" height="30" class="d-inline-block align-top" alt="">
			<?php echo Settings::$server_name; ?>
		  </a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		  <ul class="navbar-nav mr-auto">
			<li class="nav-item <?php if(!isset($_GET["page"]) || $_GET["page"] == ''){ echo "active"; } ?>">
			  <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
			</li>
			<?php if(Settings::$store_link != null){ ?>
			<li>
			  <a class="nav-link" target="_blank" href="<?php echo Settings::$store_link; ?>">Store</a>
			</li>
			<?php } ?>
			<li class="nav-item <?php if(isset($_GET["page"]) && $_GET["page"] == 'bans'){ echo "active"; } ?>">
			  <a class="nav-link" href="/?page=bans">Bans <span class="badge badge-pill badge-light"><?php echo $ban_count; ?></span></a>
			</li>
			<li class="nav-item <?php if(isset($_GET["page"]) && $_GET["page"] == 'mutes'){ echo "active"; } ?>">
			  <a class="nav-link" href="/?page=mutes">Mutes <span class="badge badge-pill badge-light"><?php echo $mute_count; ?></span></a>
			</li>
			<li class="nav-item <?php if(isset($_GET["page"]) && $_GET["page"] == 'warns'){ echo "active"; } ?>">
			  <a class="nav-link" href="/?page=warns">Warns <span class="badge badge-pill badge-light"><?php echo $warn_count; ?></span></a>
			</li>
			<li class="nav-item <?php if(isset($_GET["page"]) && $_GET["page"] == 'kicks'){ echo "active"; } ?>">
			  <a class="nav-link" href="/?page=kicks">Kicks <span class="badge badge-pill badge-light"><?php echo $kick_count; ?></span></a>
			</li>
			<?php if(Settings::$discord_link != null){ ?>
			<li>
			  <a class="nav-link" target="_blank" href="<?php echo Settings::$discord_link; ?>">Discord</a>
			</li>
			<?php } ?>
		  </ul>
		  <?php if(!empty($_GET)){ ?>
			  <form class="form-inline my-2 my-lg-0" method="get">
				<input type="hidden" name="page" id="page" value="<?php echo $_GET["page"]; ?>">
				<input class="form-control mr-sm-2" type="search" name="player" id="player" placeholder="Player" aria-label="Search">
				<button class="btn btn-outline-success" type="submit">Check</button>
			  </form>
		  <?php }else{ ?>
					<a class="btn btn-outline-primary" href="panel.php" role="button">Log in</a>
		  <?php } ?>
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

			   if($_GET["player"] != ''){
				   $sql = $sql . " WHERE username_to = '" . $_GET["player"] . "'";
			   }

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

			   $result = $conn->query($sql);

			   ?><table>
				   <tr>
					   <th><a href="/?page=kicks&order=player<?php if(isset($_GET["order"]) && $_GET["order"] == 'player'){ echo "_desc"; } ?>">Player <?php if(isset($_GET["order"]) && $_GET["order"] == 'player'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'player_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					   <th><a href="/?page=kicks&order=moderator<?php if(isset($_GET["order"]) && $_GET["order"] == 'moderator'){ echo "_desc"; } ?>">Moderator <?php if(isset($_GET["order"]) && $_GET["order"] == 'moderator'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'moderator_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					   <th>Reason</th>
					   <th><a href="/?page=kicks&order=date<?php if(isset($_GET["order"]) && $_GET["order"] == 'date'){ echo "_desc"; } ?>">Date <?php if(isset($_GET["order"]) && $_GET["order"] == 'date'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'date_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					   <th><a href="/?page=kicks&order=expires<?php if(isset($_GET["order"]) && $_GET["order"] == 'server'){ echo "_desc"; } ?>">Server <?php if(isset($_GET["order"]) && $_GET["order"] == 'server'){?> <i class="fas fa-sort-up"></i> <?php }else if(isset($_GET["order"]) && $_GET["order"] == 'server_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
				   </tr>
			   <?php

			   if ($result->num_rows > 0) {

				   while($result[$i] = $result->fetch_assoc()) {
					 ?><tr>
					   <?php $to_uuid_json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $result[$i]['username_to']);
							 $from_uuid_json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $result[$i]['username_from']);
							 $to_uuid = json_decode($to_uuid_json, true);
							 $from_uuid = json_decode($from_uuid_json, true);
							?>
						   <td><?php if($heads_link != null){ ?><img src="<?php echo str_replace("{uuid}", $to_uuid['id'], $heads_link); ?>" /><?php } echo " " . $result[$i]['username_to']; ?></td>
						   <td><?php if($heads_link != null){ ?><img src="<?php echo str_replace("{uuid}", $from_uuid['id'], $heads_link); ?>" /><?php } echo " " . $result[$i]['username_from']; ?></td>
						   <td><?php echo chatColor($result[$i]['reason']); ?></td>
						   <td><?php echo $result[$i]['created']; ?></td>
						   <td><?php if($result[$i]['server'] != ""){ echo $result[$i]['server']; }else{ echo "-"; } ?></td>
					   </tr>
					   <?php
				   }

			   }
			   ?></table><?php

		   }else{
			   include "main_page.php";
		   } ?>
	  </div>

	  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>
