<?php
session_start();
$page_title = 'Login';
include ('includes/header.html');
include('includes/print_messages.php');

if (isset($errors) && !empty($errors)) foreach ($errors as $msg) echo print_message('danger', 'Error: '.$msg);
	if (!isset($_SESSION['id_user'])) {
		?>

		<div class="row">
			<div class="col-4 offset-4 form-nav">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#login">Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#signup">Sign Up</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="tab-content">
			<div class="container tab-pane active" id="login">
				<form class="form-signin" action="login.php" method="post">
					<h1 class="form-signin-heading text-center">Login <i class="fa fa-key fa-flip-horizontal" aria-hidden="true"></i></h1>
					<div class="input-group">
						<span class="input-group-addon input-group-addon-top"><i class="fa fa-envelope-o fa-fw"></i></span>
						<input type="email" id="loginInputEmail" class="form-control" placeholder="Email address" name="email" required autofocus minlength="4" maxlength="60">
					</div>
					<div class="input-group">
						<span class="input-group-addon input-group-addon-bottom"><i class="fa fa-key fa-fw"></i></span>
						<input type="password" id="loginInputPassword" class="form-control" placeholder="Password" name="pass" required minlength="4" maxlength="20">
					</div>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
				</form>
			</div>
			<div class="container tab-pane fade" id="signup">
				<form class="form-signup" action="login.php" method="post">
					<h1 class="form-signup-heading text-center">Sign Up <i class="fa fa-pencil" aria-hidden="true"></i></h1>
					<div class="input-group">
						<span class="input-group-addon input-group-addon-top"><i class="fa fa-envelope-o fa-fw"></i></span>
						<input type="email" id="signupInputEmail" class="form-control" placeholder="Email address" name="email" required autofocus minlength="4" maxlength="60">
					</div>
					<div class="input-group">
						<span class="input-group-addon input-group-addon-middle"><i class="fa fa-user fa-fw"></i></span>
						<input type="text" id="signupInputNick" class="form-control" placeholder="Username" name="nick" required autofocus minlength="4" maxlength="20">
					</div>
					<div class="input-group">
						<span class="input-group-addon input-group-addon-middle"><i class="fa fa-key fa-fw"></i></span>
						<input type="password" id="signupInputPassword1" class="form-control" placeholder="Password" name="pass1" required minlength="4" maxlength="20">
					</div>
					<div class="input-group">
						<span class="input-group-addon input-group-addon-bottom"><i class="fa fa-key fa-fw"></i></span>
						<input type="password" id="signupInputPassword2" class="form-control" placeholder="Repeat Password" name="pass2" required minlength="4" maxlength="20">
					</div>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
				</form>
			</div>
		</div>
		<?php
	} else echo print_message('danger', 'You are already logged in.');
	include ('includes/footer.html'); ?>