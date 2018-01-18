<?php
/*
This function is used to show a message with an specific design from bootstrap. That way it saves some code.
The parameters are the type of the message, and the message itself.
The function returns the message to echo in the desired page.
*/
function print_message($type, $message) {
	return "<div class='alert alert-$type alert-dismissible show text-center' role='alert'>$message<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
}
?>