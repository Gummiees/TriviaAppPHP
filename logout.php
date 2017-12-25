<?php 
session_start();

if (isset($_SESSION['id_user']))  {
	require ('includes/login_functions.inc.php');
	$_SESSION = array();
	session_destroy();
	setcookie ('PHPSESSID', '', time()-3600);
	redirect_user('index.php?log=2');
} else {
	include('includes/print_messages.php');
	echo print_message('danger', 'You are not logged in.');
}
?>