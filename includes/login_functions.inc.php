<?php
// This page defines two functions used by the login/logout process.

/* This function determines an absolute URL and redirects the user there.
 * The function takes one argument: the page to be redirected to.
 * The argument defaults to index.php.
 */
function redirect_user ($page = 'index.php') {

	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	
	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');
	
	// Add the page:
	$url .= '/' . $page;
	
	// Redirect the user:
	header("Location: $url");
	exit(); // Quit the script.

} // End of redirect_user() function.


/* This function validates the form data (the email address and password).
 * If both are present, the database is queried.
 * The function requires a database connection.
 * The function returns an array of information, including:
 * - a TRUE/FALSE variable indicating success
 * - an array of either errors or the database result
 */
function check_login($dbc, $email = '', $pass = '') {

	$errors = array(); // Initialize error array.

	// Validate the email address:
	if (empty($email)) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($email));
	}

	// Validate the password:
	if (empty($pass)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($pass));
	}

	if (empty($errors)) { // If everything's OK.

		// Retrieve the user_id and first_name for that email/password combination:
		$q = "SELECT id_user, nick FROM users WHERE email='$e' AND pass=SHA1('$p')";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		
		// Check the result:
		if (mysqli_num_rows($r) == 1) {

			// Fetch the record:
			$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
	           echo $row['nick'];
			// Return true and the record:
			return array(true, $row);
			
		} else { // Not a match!
			$errors[] = 'The email address and password entered do not match those on file.';
		}
		
	} // End of empty($errors) IF.
	
	// Return false and the errors:
	return array(false, $errors);

} // End of check_login() function.


/* This function validates the form data (email, nick, passwords).
 * If they are present and the passwords match, the database is queried.
 * The function requires a database connection.
 * The function returns an array of information, including:
 * - a TRUE/FALSE variable indicating success
 * - an array of either errors or the database result
 */
function check_signup($dbc, $email = '', $nick = '', $pass1 = '', $pass2 = '') {

	$errors = array();

	//Validations

	if (empty($email)) $errors[] = 'You forgot to enter your email address.';
	else $e = mysqli_real_escape_string($dbc, trim($email));

	if (empty($nick)) $errors[] = 'You forgot to enter the nick.';
	else $n = mysqli_real_escape_string($dbc, trim($nick));

	if (empty($pass1)) $errors[] = 'You forgot to enter the password.';
	else {
		// check if both passwords match, no need to check if pass2 is empty because if it was it would not enter the condition here.
		if ($pass1 != $pass2) $errors[] = 'Passwords do not match.';
		else $p = mysqli_real_escape_string($dbc, trim($pass1));
	}

	if (empty($errors)) {

		// checks if there is no username with the same email or nickname
		$q = "SELECT id_user FROM users WHERE email='$e' OR nick='$n'";
		$r = @mysqli_query ($dbc, $q);
		// if there is none it will make the insert of the new user in the table 'users'.
		if (mysqli_num_rows($r) === 0) {
			$q = "INSERT INTO users(email, nick, pass) VALUES ('$e', '$n', SHA1('$p'))";	
			$r = @mysqli_query ($dbc, $q); 
			$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
			return array(true, null);
		} else $errors[] = 'The email address or nick is already registered.'; // if there is already some user with the same nickname or email it will throw an error.
	}
	return array(false, $errors);
}