<?php
require ('mysqli_connect.php');
include ('includes/header.html');
$q = "INSERT INTO comentarios(descripcion) VALUES ('$descripcion')";
$r = @mysqli_query ($dbc, $q);
?>
<?php
if(isset($_POST["submit"])){
$titulo = $_POST["title"];
$nombre = $_POST["id_user"];
$mensaje = $_POST["message"];
$query = mysql_query("INSERT INTO submit (title, id_user, message) VALUES ('$title','$id_user','$message')") or die(mysql_error());
echo '<script>alert("The message has been sent successfully ")</script>';
}
?>
<form name="mp" method="post" action="">
  <p>User:<br>
    <input type="text" name="id_user" id="id_user">
  </p>
  <p>Menssage:<br>
    <textarea name="Menssage" id="Menssage" cols="45" rows="5"></textarea>
  </p>
  <p>
    <input type="submit" name="submit" id="submit" value="submit">
  </p>
</form>