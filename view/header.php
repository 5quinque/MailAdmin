<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags always come first -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">

		<title>Ryan's Mail Admin</title>

		<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<style>
		</style>
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="/mailadmin/">
						<img alt="Brand" src="/favicon.ico" width="20px" height="20px">
					</a>
				</div>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="/mailadmin/">Home</a></li>
					<?php 
					if ($this->model->admin->isLogged()) {
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->model->admin->username; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">Account</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="?action=logout">Logout</a></li>
						</ul>
					</li>
					<?php } ?>
				</ul>
			</div>
		</nav>
		<div class="container">
			<div class="row row-offcanvas row-offcanvas-left">

