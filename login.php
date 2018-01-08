<?php #login.php #3
// This page processes the login form submission.
// The script now uses sessions.

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Need two helper files:
	require ('includes/login_functions.inc.php');
	require ('mysqli_connect.php');
		
	if ("login" == $_POST['type']) {
		list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['pass']);
		if ($check) {
			session_start();
			$_SESSION['id_user'] = $data['id_user'];
			$_SESSION['nick'] = $data['nick'];
			redirect_user('index.php?log=1');	
		} else $errors = $data;
	} else if ("signup" == $_POST['type']){
		list ($check, $errors) = check_signup($dbc, $_POST['email'], $_POST['nick'], $_POST['pass1'], $_POST['pass2']);
		if ($check) redirect_user('login.php?signup=1');
	}
	mysqli_close($dbc);

} // End of the main submit conditional.

// Create the page:
include ('includes/login_page.inc.php');

?>