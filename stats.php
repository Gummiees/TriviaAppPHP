<?php
session_start();
include("includes/header.html");
include('includes/print_messages.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  require ('mysqli_connect.php');
  require ('includes/login_functions.inc.php');

  $nicks [] = $_POST['nick'];
  $i = 0;
  while (isset($_POST['nick'.$i])) {
    $nicks [] = $_POST['nick'.$i];
    $i++;
  }

  //check if all the nicks exists in our database
  foreach ($nicks as $key => $nick) {
    $q = "SELECT id_user FROM users WHERE nick='$nick'";   
    $r = @mysqli_query ($dbc, $q);
    $num = mysqli_num_rows($r);
    if (0 === $num) {
      $error = "The username '$nick' was not found.";
      break;
    } else {
      $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
      $uids [] = $row['id_user'];
    }
  }

  if (!isset($error)) {
    $link = "user_stats.php?";
    foreach ($uids as $key => $uid) {
      if (0 === $key) $link .= "uid=$uid";
      else $link .= "&uid$key=$uid";
    }
    redirect_user($link);
  } else echo print_message('danger', "Error: $error");
}

?>
<div class="row text-center login-title">
  <div class="col-sm-12 text-center">
    <h1 style="font-size: 4em; text-align: center !important;">See and compare stats</h1>
  </div>
</div>
<script>
  var i=0;
</script>
<div class="row" style="margin-top: 20px;">
  <div class="col-sm-2 offset-5">
    <form class="form-horizontal" action="stats.php" method="post">
      <div class="form-group row">
        <div class="col-sm-12">
          <div class="input-group"> 
            <input type="text" class="form-control" name="nick" required id="nick" maxlength="20" placeholder="Username" value="<?php if (isset($_POST['nick'])) echo $_POST['nick']; ?>">
            <div class="input-group-btn">
              <button class="btn btn-primary" type="button" onclick="addUsers()"><span class="fa fa-plus" style="font-size:1.2em;"></span></button>
            </div>
          </div>
        </div>
        <div class="col-sm-2 text-left">
          
        </div>
      </div>
      <div id="add-users"></div>
      <div class="form-group row">
        <div class="col-sm-12 text-right">
          <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>  

<script>
  function addUsers() {
  document.getElementById("add-users").innerHTML += '<div class="form-group row"><div class="col-sm-12"><input type="text" class="form-control" name="nick'+i+'" id="nick'+i+'" maxlength="20" placeholder="Username '+(i+2)+'"></div></div>';
  i++;
  }
</script>

<?php
include("includes/footer.html");
?>