<?php
include_once "settings.php";
include_once "functions.php";

session_start();

if($mysql_port != "3306"){
	$mysql_host = $mysql_host . ":" . $mysql_port;
}

$conn = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_database);

if (mysqli_connect_error()) {
	die("Connection failed: " . mysqli_connect_error());
}

$sql="SELECT * FROM adminbans_banned_players";
if ($result=mysqli_query($conn,$sql)){ $ban_count=mysqli_num_rows($result); }

$sql="SELECT * FROM adminbans_muted_players";
if ($result=mysqli_query($conn,$sql)){ $mute_count=mysqli_num_rows($result); }

$sql="SELECT * FROM adminbans_warned_players";
if ($result=mysqli_query($conn,$sql)){ $warn_count=mysqli_num_rows($result); }

$sql="SELECT * FROM adminbans_kicked_players";
if ($result=mysqli_query($conn,$sql)){ $kick_count=mysqli_num_rows($result); }

?>

<!doctype html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/ico" href="images/server-icon.png" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="themes/<?php echo $default_theme; ?>.css" />
	<link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/animate.css">
	<title><?php echo $server_name; ?></title>
	<script src="https://kit.fontawesome.com/445ee3669f.js" crossorigin="anonymous"></script>
  </head>
  <body>
	  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <a class="navbar-brand" href="#">
			<img src="images/server-icon.png" width="30" height="30" class="d-inline-block align-top" alt="">
			<?php echo $server_name; ?>
		  </a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		  <ul class="navbar-nav mr-auto">
			<li class="nav-item <?php if($_GET["page"] == ''){ echo "active"; } ?>">
			  <a class="nav-link" href="panel.php">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item <?php if($_GET["page"] == 'bans'){ echo "active"; } ?>">
			  <a class="nav-link" href="panel.php?page=bans">Bans <span class="badge badge-pill badge-light"><?php echo $ban_count; ?></span></a>
			</li>
			<li class="nav-item <?php if($_GET["page"] == 'mutes'){ echo "active"; } ?>">
			  <a class="nav-link" href="panel.php?page=mutes">Mutes <span class="badge badge-pill badge-light"><?php echo $mute_count; ?></span></a>
			</li>
			<li class="nav-item <?php if($_GET["page"] == 'warns'){ echo "active"; } ?>">
			  <a class="nav-link" href="panel.php?page=warns">Warns <span class="badge badge-pill badge-light"><?php echo $warn_count; ?></span></a>
			</li>
			<li class="nav-item <?php if($_GET["page"] == 'kicks'){ echo "active"; } ?>">
			  <a class="nav-link" href="panel.php?page=kicks">Kicks <span class="badge badge-pill badge-light"><?php echo $kick_count; ?></span></a>
			</li>
		  </ul>
		  <?php if(!empty($_GET)){ ?>
			  <form class="form-inline my-2 my-lg-0" method="get">
				<input type="hidden" name="page" id="page" value="<?php echo $_GET["page"]; ?>">
				<input class="form-control mr-sm-2" type="search" name="player" id="player" placeholder="Player" aria-label="Search">
				<button class="btn btn-outline-success" type="submit">Check</button>
			  </form>
		  <?php }else{
			  if(isset($_SESSION["username"])){?>
				  <a class="btn btn-outline-danger" href="check_logout.php" role="button">Log out</a>
		  <?php
				}
			} ?>
		</div>
	  </nav>

	  <div class="table">

		  <?php
		  if(isset($_SESSION["username"])){
			  if($_GET["page"] == 'bans'){ ?>

					<h1 class="animate__animated animate__bounceInDown">Bans</h1> <?php

					$sql = "SELECT * FROM adminbans_banned_players";
					$limit = "LIMIT " . $data_limit;

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

					$result = $conn->query($sql);

					?><table>
						<tr>
							<th><a href="panel.php?page=bans&order=player<?php if($_GET["order"] == 'player'){ echo "_desc"; } ?>">Player <?php if($_GET["order"] == 'player'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'player_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
							<th><a href="panel.php?page=bans&order=moderator<?php if($_GET["order"] == 'moderator'){ echo "_desc"; } ?>">Moderator <?php if($_GET["order"] == 'moderator'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'moderator_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
							<th><a>Reason</a></th>
							<th><a href="panel.php?page=bans&order=date<?php if($_GET["order"] == 'date'){ echo "_desc"; } ?>">Date <?php if($_GET["order"] == 'date'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'date_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
							<th><a href="panel.php?page=bans&order=expires<?php if($_GET["order"] == 'expires'){ echo "_desc"; } ?>">Expires <?php if($_GET["order"] == 'expires'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'expires_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
							<th><a href="panel.php?page=bans&order=expires<?php if($_GET["order"] == 'server'){ echo "_desc"; } ?>">Server <?php if($_GET["order"] == 'server'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'server_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
						</tr>
					<?php

					if ($result->num_rows > 0) {

						while($row = $result->fetch_assoc()) {
						  ?><tr>
							<?php $to_uuid_json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $row['username_to']);
								  $from_uuid_json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $row['username_from']);
								  $to_uuid = json_decode($to_uuid_json, true);
								  $from_uuid = json_decode($from_uuid_json, true);
								 ?>
								<td><?php if($heads_link != null){ ?><img src="<?php echo str_replace("{uuid}", $to_uuid['id'], $heads_link); ?>" /><?php } echo " " . $row['username_to']; ?></td>
								<td><?php if($heads_link != null){ ?><img src="<?php echo str_replace("{uuid}", $from_uuid['id'], $heads_link); ?>" /><?php } echo " " . $row['username_from']; ?></td>
								<td><?php echo chatColor($row['reason']); ?></td>
								<td><?php echo $row['created']; ?></td>
								<td><?php echo $row['until']; ?></td>
								<td><?php if($row['server'] != ""){ echo $row['server']; }else{ echo "-"; } ?></td>
							</tr>
							<?php
						}

					}
					?></table><?php

					$conn->close();
		   }else if($_GET["page"] == 'mutes'){ ?>

			   <h1 class="animate__animated animate__bounceInDown">Mutes</h1> <?php

			   $sql = "SELECT * FROM adminbans_muted_players";
			   $limit = "LIMIT " . $data_limit;

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

			   $result = $conn->query($sql);

			   ?><table>
				   <tr>
					   <th><a href="panel.php?page=mutes&order=player<?php if($_GET["order"] == 'player'){ echo "_desc"; } ?>">Player <?php if($_GET["order"] == 'player'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'player_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					   <th><a href="panel.php?page=mutes&order=moderator<?php if($_GET["order"] == 'moderator'){ echo "_desc"; } ?>">Moderator <?php if($_GET["order"] == 'moderator'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'moderator_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					   <th>Reason</th>
					   <th><a href="panel.php?page=mutes&order=date<?php if($_GET["order"] == 'date'){ echo "_desc"; } ?>">Date <?php if($_GET["order"] == 'date'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'date_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					   <th><a href="panel.php?page=mutes&order=expires<?php if($_GET["order"] == 'expires'){ echo "_desc"; } ?>">Expires <?php if($_GET["order"] == 'expires'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'expires_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					   <th><a href="panel.php?page=mutes&order=expires<?php if($_GET["order"] == 'server'){ echo "_desc"; } ?>">Server <?php if($_GET["order"] == 'server'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'server_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
				   </tr>
			   <?php

			   if ($result->num_rows > 0) {

				   while($row = $result->fetch_assoc()) {
					 ?><tr>
					   <?php $to_uuid_json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $row['username_to']);
							 $from_uuid_json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $row['username_from']);
							 $to_uuid = json_decode($to_uuid_json, true);
							 $from_uuid = json_decode($from_uuid_json, true);
							?>
						   <td><?php if($heads_link != null){ ?><img src="<?php echo str_replace("{uuid}", $to_uuid['id'], $heads_link); ?>" /><?php } echo " " . $row['username_to']; ?></td>
						   <td><?php if($heads_link != null){ ?><img src="<?php echo str_replace("{uuid}", $from_uuid['id'], $heads_link); ?>" /><?php } echo " " . $row['username_from']; ?></td>
						   <td><?php echo chatColor($row['reason']); ?></td>
						   <td><?php echo $row['created']; ?></td>
						   <td><?php echo $row['until']; ?></td>
						   <td><?php if($row['server'] != ""){ echo $row['server']; }else{ echo "-"; } ?></td>
					   </tr>
					   <?php
				   }

			   }
			   ?></table><?php

			   $conn->close();
		   }else if($_GET["page"] == 'warns'){ ?>
			   <h1 class="animate__animated animate__bounceInDown">Warns</h1> <?php

			   $sql = "SELECT * FROM adminbans_warned_players";
			   $limit = "LIMIT " . $data_limit;

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
					   <th><a href="panel.php?page=warns&order=player<?php if($_GET["order"] == 'player'){ echo "_desc"; } ?>">Player <?php if($_GET["order"] == 'player'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'player_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					   <th><a href="panel.php?page=warns&order=moderator<?php if($_GET["order"] == 'moderator'){ echo "_desc"; } ?>">Moderator <?php if($_GET["order"] == 'moderator'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'moderator_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					   <th>Reason</th>
					   <th><a href="panel.php?page=warns&order=date<?php if($_GET["order"] == 'date'){ echo "_desc"; } ?>">Date <?php if($_GET["order"] == 'date'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'date_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					   <th><a href="panel.php?page=warns&order=expires<?php if($_GET["order"] == 'server'){ echo "_desc"; } ?>">Server <?php if($_GET["order"] == 'server'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'server_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
				   </tr>
			   <?php

			   if ($result->num_rows > 0) {

				   while($row = $result->fetch_assoc()) {
					 ?><tr>
					   <?php $to_uuid_json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $row['username_to']);
							 $from_uuid_json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $row['username_from']);
							 $to_uuid = json_decode($to_uuid_json, true);
							 $from_uuid = json_decode($from_uuid_json, true);
							?>
						   <td><?php if($heads_link != null){ ?><img src="<?php echo str_replace("{uuid}", $to_uuid['id'], $heads_link); ?>" /><?php } echo " " . $row['username_to']; ?></td>
						   <td><?php if($heads_link != null){ ?><img src="<?php echo str_replace("{uuid}", $from_uuid['id'], $heads_link); ?>" /><?php } echo " " . $row['username_from']; ?></td>
						   <td><?php echo chatColor($row['reason']); ?></td>
						   <td><?php echo $row['created']; ?></td>
						   <td><?php if($row['server'] != ""){ echo $row['server']; }else{ echo "-"; } ?></td>
					   </tr>
					   <?php
				   }

			   }
			   ?></table><?php

			   $conn->close();
		   }else if($_GET["page"] == 'kicks'){ ?>
			   <h1 class="animate__animated animate__bounceInDown">Kicks</h1> <?php

			   $sql = "SELECT * FROM adminbans_kicked_players";
			   $limit = "LIMIT " . $data_limit;

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
					   <th><a href="panel.php?page=kicks&order=player<?php if($_GET["order"] == 'player'){ echo "_desc"; } ?>">Player <?php if($_GET["order"] == 'player'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'player_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					   <th><a href="panel.php?page=kicks&order=moderator<?php if($_GET["order"] == 'moderator'){ echo "_desc"; } ?>">Moderator <?php if($_GET["order"] == 'moderator'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'moderator_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					   <th>Reason</th>
					   <th><a href="panel.php?page=kicks&order=date<?php if($_GET["order"] == 'date'){ echo "_desc"; } ?>">Date <?php if($_GET["order"] == 'date'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'date_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
					   <th><a href="panel.php?page=kicks&order=expires<?php if($_GET["order"] == 'server'){ echo "_desc"; } ?>">Server <?php if($_GET["order"] == 'server'){?> <i class="fas fa-sort-up"></i> <?php }else if($_GET["order"] == 'server_desc'){ ?> <i class="fas fa-sort-down"></i> <?php } ?></a></th>
				   </tr>
			   <?php

			   if ($result->num_rows > 0) {

				   while($row = $result->fetch_assoc()) {
					 ?><tr>
					   <?php $to_uuid_json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $row['username_to']);
							 $from_uuid_json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $row['username_from']);
							 $to_uuid = json_decode($to_uuid_json, true);
							 $from_uuid = json_decode($from_uuid_json, true);
							?>
						   <td><?php if($heads_link != null){ ?><img src="<?php echo str_replace("{uuid}", $to_uuid['id'], $heads_link); ?>" /><?php } echo " " . $row['username_to']; ?></td>
						   <td><?php if($heads_link != null){ ?><img src="<?php echo str_replace("{uuid}", $from_uuid['id'], $heads_link); ?>" /><?php } echo " " . $row['username_from']; ?></td>
						   <td><?php echo chatColor($row['reason']); ?></td>
						   <td><?php echo $row['created']; ?></td>
						   <td><?php if($row['server'] != ""){ echo $row['server']; }else{ echo "-"; } ?></td>
					   </tr>
					   <?php
				   }

			   }
			   ?></table><?php

			   $conn->close();
		   }else{
			   include "main_page.php";
			   $conn->close();
		   }
	   }else{ ?>
		   <h1>Log in</h1>
		   <div class="container" style="max-width: 20em;">
			   <form name="login" action="check_login.php" method="post" novalidate>
				  <div class="form-group">
					<label for="inputUsername">Username</label>
					<input type="text" name="username" class="form-control" id="inputUsername" aria-describedby="usernameHelp" required>
				  </div>
				  <div class="form-group">
					<label for="inputPassword">Password</label>
					<input type="password" name="password" class="form-control" id="inputPassword" required>
				  </div>
				  <div style="text-align: center;">
					<?php if($login_hcaptcha){ ?>
						<div style="margin-top: 10px;" class="h-captcha" data-sitekey="<?php echo $login_hcaptcha_sitekey; ?>"></div>
					<?php } ?>
					<button type="submit" class="btn btn-primary">Log in</button>
				  </div>
			  </form>
		  </div>
	   <?php } ?>
	  </div>

	  <?php
  if($_SESSION["msg"] != ""){ ?>
	  <div class="alert <?php echo $_SESSION["color"]; ?> alert-dismissible fade show" role="alert" style="position: fixed; bottom: 0; left: 0; margin: 30px;">
	  <?php echo "<strong>".$_SESSION['msg']."</strong>";
	  $_SESSION['msg'] = ""?>
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	  </button>
	  </div>
  <?php } ?>

	  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>
