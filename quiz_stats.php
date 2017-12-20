<?php
include("includes/header.html");
include('includes/print_messages.php');
if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
	require ('mysqli_connect.php');
?>


<?php 
include("includes/footer.html");
?>