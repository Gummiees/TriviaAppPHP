<?php 
session_start();

// if there is an existing session with the id_user it will destroy it
if (isset($_SESSION['id_user']))  {
	require ('includes/login_functions.inc.php');
	$_SESSION = array();
	session_destroy();
	setcookie ('PHPSESSID', '', time()-3600);
	redirect_user('index.php?log=2');
} else {
	// if there was not session, it will print an error message saying it is not logged in.
	include('includes/print_messages.php');
	echo print_message('danger', 'You are not logged in.');
}
?>