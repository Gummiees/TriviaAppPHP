<?php
require ('mysqli_connect.php');
include ('includes/header.html');
include ('includes/print_messages.php');
?>
<?php
if(isset($_POST["submit"])){

$title = mysqli_real_escape_string($dbc, trim($_POST['title']));

$name = mysqli_real_escape_string($dbc, trim($_POST['name']));

$message = mysqli_real_escape_string($dbc, trim($_POST['message']));
$q="INSERT INTO message (title, name, message) VALUES ('$title','$name','$message')";
$r = @mysqli_query ($dbc, $q);
    echo print_message("success","the message was successfully send");

}
?>
<form class="mp" name="mp" method="post" action="">
<p>Title:<br>
    <input type="text" name="title" id="title" required maxlength="100" minlength="5" placeholder="title" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
  </p>
  <p>User:<br>
    <input type="text" name="name" id="name" required maxlength="20" minlength="5" placeholder="name" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>">
  </p>
  <p>Menssage:<br>
    <textarea name="message" id="message" cols="45" rows="5" required maxlength="250" minlength="5" placeholder="message"></textarea>
  </p>
  <p>
    <input type="submit" name="submit" id="submit" value="submit">
  </p>
</form>

<?php
include ('includes/footer.html');
?>