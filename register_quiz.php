<?php
session_start();
include('includes/print_messages.php');
require ('mysqli_connect.php');
include ('includes/header.html');

if (isset($_SESSION['id_user'])) {
  $uid = $_SESSION['id_user'];
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    if (empty($_POST['title'])) {
      $errors[] = 'You forgot to enter the quiz title.';
    } else {
      if (strlen($_POST['title']) < 5) {
        $errors[] = 'The title is too short.';
      } else if (strlen($_POST['title']) > 25) {
        $errors[] = 'The title is too long.';
      } else {
        $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
      }
    }
    if (empty($_POST['desc'])) {
      $errors[] = 'You forgot to enter the quiz description.';
    } else {
      if (strlen($_POST['desc']) > 250) {
        $errors[] = 'The description is too long.';
      }else {
        $desc = mysqli_real_escape_string($dbc, trim($_POST['desc']));
      }
    }
    if (empty($_POST['theme'])) {
      $errors[] = 'You forgot to enter the quiz theme.';
    } else {
      if (strlen($_POST['theme']) < 5) {
        $errors[] = 'The theme is too short.';
      } else if (strlen($_POST['theme']) > 25) {
        $errors[] = 'The theme is too long.';
      } else {
        $theme = mysqli_real_escape_string($dbc, trim($_POST['theme']));
      }
    }

    if (empty($errors)) {
      $q = "INSERT INTO quizzes (title, description, theme, id_user) VALUES ('$title', '$desc', '$theme', $uid)";   
      $r = @mysqli_query ($dbc, $q);
      if ($r) {
        echo print_message('success', 'Thank you. Your quiz is now ready to be played!');
      } else {
        echo print_message('danger', 'Something went wrong due to our system. Sorry for the inconvenience.');
        echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
      }
      mysqli_close($dbc);
      include ('includes/footer.html'); 
      exit();
    } else {
      foreach ($errors as $msg) {
        echo print_message('danger', $msg);
      }
    }
  }
?>
<div class="row text-center login-title">
  <div class="col-sm-12 text-center">
    <h1 style="color: #8E44AD; font-size: 4em; text-align: center !important;">Register quiz</h1>
  </div>
</div>
<script>
  var i=0;
</script>
<div class="row">
  <div class="col-sm-2"></div>
  <div class="col-sm-8">
    <form class="form-horizontal" action="register_quiz.php" method="post">
      <div class="form-group row">
        <label class="control-label col-sm-2 text-right" for="title">Title:</label>
        <div class="col-sm-10"> 
          <input type="text" class="form-control" name="title" minlength="5" maxlength="25" required id="name" placeholder="Quiz title" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
          <small class="form-text text-muted">Required. This will be the title for the quiz. It must be between 5 and 25 characters.</small>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-right" for="desc">Description:</label>
        <div class="col-sm-10"> 
          <textarea rows="5" class="form-control" name="desc" required id="desc" maxlength="250" placeholder="Description" <?php if(isset($_POST['desc'])) echo $_POST['desc'];?>></textarea>
          <small class="form-text text-muted">Required. This will be the description for the quiz. It must be less than 250 characters.</small>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-right" for="theme">Theme:</label>
        <div class="col-sm-10"> 
          <input type="text" class="form-control" name="theme" minlength="5" maxlength="25" required id="theme" placeholder="Quiz theme" value="<?php if (isset($_POST['theme'])) echo $_POST['theme']; ?>">
          <small class="form-text text-muted">Required. This will be the theme for the quiz. It must be between 5 and 25 characters.</small>
        </div>
      </div>
    </form>
  </div>
</div>
<?php
} else echo print_message('danger', 'You must be logged in to register a quiz.');
include ('includes/footer.html');
?>