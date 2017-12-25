<?php
session_start();
include('includes/print_messages.php');
$page_title = 'Login';
include ('includes/header.html');

// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
	echo '<h1>Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p>';
}
if (!isset($_SESSION['id_user'])) {
// Display the form:
?>

<form class="form-signin" action="login.php" method="post">
  <h1 class="form-signin-heading">Login</h1>
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus minlength="4" maxlength="60" >
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="pass" required minlength="4" maxlength="20" >
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>

<?php
	} else echo print_message('danger', 'You are already logged in.');
include ('includes/footer.html'); ?>