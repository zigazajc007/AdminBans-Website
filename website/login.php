<?php

include_once "Settings.php";

session_start();

if(isset($_SESSION["username"])){
	header("Location: index.php");
	return;
}

?>

<!DOCTYPE html>
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
		<div class="primaryBackgroundColor min-h-screen flex items-center justify-center py-6 px-4 sm:px-3 lg:px-8">
			<div class="max-w-md w-full space-y-6">
				<div>
					<a href="/"><img class="mx-auto h-20 w-auto" width="80" height="80" src="images/server-icon.png" alt="<?= Settings::$server_name ?>"></a>
				</div>
				<form action="check_login.php" method="POST" class="mt-8 space-y-6">
					<input type="hidden" name="remember" value="true">
					<div class="rounded-md shadow-sm -space-y-px">
						<div>
							<label for="username" class="sr-only">Username</label>
							<div class="relative rounded-md shadow-sm">
								<div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 secondaryColor" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
										<circle cx="12" cy="7" r="4"></circle>
										<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
									</svg>
								</div>
								<input id="username" name="username" type="text" autocomplete="username" required class="tertiaryBackgroundColor tertiaryColor primaryBorderColor appearance-none rounded-t-md block w-full pl-10 px-3 py-2 border focus:outline-none focus:z-10 sm:text-sm" placeholder="Username">
							</div>
						</div>
						<div>
							<label for="password" class="sr-only">Password</label>
							<div class="relative rounded-md shadow-sm">
								<div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 secondaryColor" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
										<circle cx="8" cy="15" r="4"></circle>
										<line x1="10.85" y1="12.15" x2="19" y2="4"></line>
										<line x1="18" y1="5" x2="20" y2="7"></line>
										<line x1="15" y1="8" x2="17" y2="10"></line>
									</svg>
								</div>
								<input id="password" name="password" type="password" autocomplete="off" required class="tertiaryBackgroundColor tertiaryColor primaryBorderColor appearance-none rounded-b-md block w-full pl-10 px-3 py-2 border focus:outline-none focus:z-10 sm:text-sm" placeholder="Password">
							</div>
						</div>
					</div>

					<?php
						if(Settings::$turnstile) echo '<div class="cf-turnstile" data-sitekey="' . Settings::$turnstile_sitekey . '" data-action="login" data-theme="dark" data-language="en"></div>';
					?>

					<div class="text-center">
						<button id="btn_signin" type="submit" class="primaryButton group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none">
							Sign in
						</button>
					</div>
			 </form>
			</div>
		</div>

		<div id="dialog" class="<?php if(!isset($_SESSION["msg"])){ echo "hidden"; } ?> h-screen w-full fixed left-0 top-0 flex justify-center items-center z-10 inset-0 overflow-y-auto" aria-labelledby="dialog-title" role="dialog" aria-modal="true">
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
						<h3 class="tertiaryColor text-lg leading-6 font-medium" id="dialog-title">Error</h3>
						<div class="mt-2">
							<p class="secondaryColor text-sm" id="dialog-text"><?php if(isset($_SESSION["msg"])){ echo $_SESSION["msg"]; } ?></p>
						</div>
					</div>
				</div>
				<div class="mt-5 sm:mt-4 sm:ml-10 sm:pl-4 sm:flex">
					<button id="dialog-button" type="button" class="dangerButton inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium focus:outline-none sm:w-auto sm:text-sm">
						Okay
					</button>
				</div>
			</div>
		</div>

		<?php
			unset($_SESSION["msg"]);
		?>

		<script type="module" src="js/login.js"></script>
		<?php
			if(Settings::$turnstile) echo '<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>';
		?>
	</body>
</html>