<?php
session_start();
include('includes/print_messages.php');
require ('mysqli_connect.php');
include ('includes/header.html');

if (isset($_SESSION['id_user'])) {
  $uid = $_SESSION['id_user'];
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    if (!isset($_POST['title']) || empty($_POST['title'])) {
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
    if (!isset($_POST['desc']) || empty($_POST['desc'])) {
      $errors[] = 'You forgot to enter the quiz description.';
    } else {
      if (strlen($_POST['desc']) > 250) {
        $errors[] = 'The description is too long.';
      }else {
        $desc = mysqli_real_escape_string($dbc, trim($_POST['desc']));
      }
    }
    if (!isset($_POST['theme']) || empty($_POST['theme'])) {
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

    //questions and answers

    for ($i=1; $i<=10; $i++) {
      if (!isset($_POST['question'.$i]) || empty($_POST['question'.$i])) {
        $errors[] = 'You forgot to enter the '.$i.' question.';
      } else $questions[$i][0] = mysqli_real_escape_string($dbc, trim($_POST['question'.$i]));
      for ($j=1; $j<=3; $j++) {
        if (!isset($_POST['answer'.$i.$j]) || empty($_POST['answer'.$i.$j])) {
          $errors[] = 'You forgot to enter the '.$j.' answer for the '.$i.' question.';
        } else $questions[$i][$j] = mysqli_real_escape_string($dbc, trim($_POST['answer'.$i.$j]));
      }
      if (!isset($_POST['radio'.$i]) || empty($_POST['radio'.$i])) {
        $errors[] = 'You forgot to mark the correct answer for the '.$i.' question.';
      } else $radios[$i] = mysqli_real_escape_string($dbc, trim($_POST['radio'.$i]));
    }

    if (empty($errors)) {
      $q = "INSERT INTO quizzes (title, description, theme, id_user) VALUES ('$title', '$desc', '$theme', $uid)";   
      $r = @mysqli_query ($dbc, $q);
      if ($r) {
        $q = "SELECT id_quiz FROM quizzes ORDER BY id_quiz DESC LIMIT 1";   
        $r = @mysqli_query ($dbc, $q);
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
        $qid = $row['id_quiz'];
        $q = "INSERT INTO questions (description, id_quiz) VALUES "; 
        for($i=1; $i<=10; $i++) {
          $desc = $questions[$i][0];
          $q .= "('$desc', $qid)";
          if ($i != 10) $q .= ", ";
          else $q .= ';';
        }

        $r = @mysqli_query ($dbc, $q);
        if ($r) {
          $q = "SELECT id_question FROM questions ORDER BY id_question DESC LIMIT 10";   
          $r = @mysqli_query ($dbc, $q);
          $q = "INSERT INTO answers (description, value, id_question) VALUES "; 
          for($i=10; $i>=1 && $row = mysqli_fetch_array($r, MYSQLI_ASSOC); $i--) {
            $qid = $row['id_question'];
            $radio = $radios[$i];
            for ($j=1; $j<=3; $j++) {
              $desc = $questions[$i][$j];

              if ($radio == $j) $q .= "('$desc', 1, $qid)";
              else $q .= "('$desc', 0, $qid)";

              if ($i!=1 || $j!=3) $q .= ", ";
            }
          }
          $q .= ';';
          $r = @mysqli_query ($dbc, $q);
          if ($r) {
            echo print_message('success', 'Thank you. Your quiz is now ready to be played!');
          } else {
            echo print_message('danger', 'Something went wrong due to our system. Sorry for the inconvenience.');
            echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
          }
        } else {
          echo print_message('danger', 'Something went wrong due to our system. Sorry for the inconvenience.');
          echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
        }
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
    <h1 class="title" style="">Register quiz <span class="fa fa-pencil" aria-hidden="true"></span></h1>
  </div>
</div>
<script>
  var i=0;
</script>
<div class="row margin-top">
  <div class="col-sm-2"></div>
  <div class="col-sm-7">
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
      <div id="add-quiz"></div>
      <div class="row">
        <div class="col-sm-3 offset-5">
          <button class="btn btn-lg btn-primary btn-block" type="submit">Send</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  window.onload = function () {
    for (var i=1; i<=10; i++) {
      document.getElementById("add-quiz").innerHTML += '<div class="form-group row"><label class="control-label col-sm-2 text-right" for="question'+i+'">Question '+i+'</label><div class="col-sm-10"> <input type="text" class="form-control" name="question'+i+'" id="question'+i+'" maxlength="250" placeholder="Question '+i+'"></div></div>';
      for (var j=1; j<=3; j++) {
        document.getElementById("add-quiz").innerHTML += '<div class="form-group row"><div class="col-sm-10 offset-sm-2">  <div class="form-row align-items-center"><div class="col-sm-11"><input type="text" class="form-control" name="answer'+i+j+'" id="answer'+i+j+'" maxlength="250" placeholder="Answer '+j+'"></div><div class="col-auto text-right"><div class="form-check disabled text-left offset-4"><label class="custom-control custom-radio"><input value="'+j+'" id="radio'+i+j+'" name="radio'+i+'" type="radio" class="custom-control-input"><span class="custom-control-indicator"></span></div></div></div></div>';
      }
    }
  }
</script>
<?php
} else echo print_message('danger', 'You must be logged in to register a quiz.');
include ('includes/footer.html');
?>