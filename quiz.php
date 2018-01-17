<?php
/*
This page is used to visualize and do the quiz.
*/
session_start ();
require ('mysqli_connect.php');
include("includes/header.html");
include('includes/print_messages.php');
//if the session is started, there will appear an error.
if (isset($_SESSION['id_user'])) {
  //if the number of the quizz given in the url is incorrect, it will show an error.
  if (isset($_GET['qid']) && is_numeric($_GET['qid'])) {
    $qid = $_GET['qid'];
    $q = "SELECT title, description FROM quizzes WHERE id_quiz=$qid"; // Selects the title and the description of the quizz.
    $r = @mysqli_query ($dbc, $q);
    $num = mysqli_num_rows($r);
    if ($num == 1) { // if the quizz exists in the database, it will process it, if not, an error will appear.
      $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
      $quiz_title = $row['title'];
      $quiz_desc = $row['description'];
?>

<!-- title and description of the quizz -->
<div class="row">
  <div class="jumbotron text-center col-10 offset-1">
    <h1><?php echo $quiz_title;?></h1> 
    <p><?php echo $quiz_desc;?></p>
  </div>
</div>
<hr>

<!-- questions and answers of the quizz -->
<div class="row">
  <div class="col-8 offset-2 text-center">
    <form action="results.php?qid=<?php echo $qid;?>" method="POST">

      <div id="print-here"></div>
<script>

  /* for generate the quizz itself (its questions and answers), JS and PHP is combined. 
  PHP is used to get the values from the database and create the variables for the js in the server part,
  while in JS when the webpage is loaded in the user part, those variables are used to generate the quizz with the questions and answers.
  */

  <?php
  // selects the questions from the quizz.
    $q = "SELECT id_question, description FROM questions WHERE id_quiz=$qid";
    $r = @mysqli_query ($dbc, $q);
    $num = mysqli_num_rows($r);
    if ($num > 0) {
      echo 'const preguntas = ['; // creates a variable for the js script used afterwards.
      for($j=1; $j<=$num; $j++) { // for each question, it process it and it gets the answers of those and process it.
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
        $id_question = $row['id_question'];
        $question = $row['description'];
        $question = str_replace("'", '"', $question);
        echo "['$question', ";
        // selects the answers from the question
        $q1 = "SELECT description, value FROM answers WHERE id_question=$id_question";
        $r1 = @mysqli_query ($dbc, $q1);
        $n1 = mysqli_num_rows($r1);
        if ($n1 > 0) {
          for($i=1; $i<=$n1; $i++) {
            $row1 = mysqli_fetch_array($r1, MYSQLI_ASSOC);
            $answer = $row1['description'];
            echo "'$answer'";
            if ($i!=$n1) echo ",";
          }
          echo "]";
          if ($j!=$num)echo ",";
        }
      }
      echo '];';
    }
  ?>
  var actual = 0;
  var respuestas = [];
  window.onload = function () {
    generateQuestion();
  }

  /*
  This function generates the actual question with its answers, printing it in the page. That way the user can't read the next questions or the next answers.
  */
  function generateQuestion() {
    if (actual === preguntas.length - 1) {
      document.getElementById('print-here').innerHTML = '<div id="pregunta'+actual+'"><fieldset id="fieldset'+actual+'" class="form-group"></fieldset><div class="row"><button type="submit" class="btn btn-primary btn-lg btn-block" onclick="nextQuestion()">Finish</button></div></div></form></div>';
    } else {
      document.getElementById('print-here').innerHTML = '<div id="pregunta'+actual+'"><fieldset id="fieldset'+actual+'" class="form-group"></fieldset><div class="row"><button type="button" class="btn btn-primary btn-lg btn-block" onclick="nextQuestion()">Next</button></div></div></form></div>';
    }
    preguntas[actual].forEach((respuesta, j) => {
      if (j===0) document.getElementById('fieldset'+actual).innerHTML += "<legend>"+respuesta+"</legend>";
      else document.getElementById('fieldset'+actual).innerHTML += "<div class='form-check disabled text-left offset-4'><label class='custom-control custom-radio'><input value='"+respuesta+"' id='radio"+j+"' name='radio"+actual+"' type='radio' class='custom-control-input'><span class='custom-control-indicator'></span><span class='custom-control-description'>"+respuesta+"</span></label></div>";
    });
  }

  /*
  This function saves the answers the user has chose in the variable 'respuestas' and then process the css to make this question and it answers desappear, putting there the next questions with the answers.
  */

  function nextQuestion () {
    for (var i=1; i<preguntas[actual].length; i++) {
      if (document.getElementById('radio'+i).checked) {
        respuestas.push(document.getElementById('radio'+i).value);
      }
    }
    if (typeof respuestas[actual] !== 'undefined') {
      actual++;
      if (actual < preguntas.length) {
        generateQuestion();
        document.getElementById('pregunta'+actual).style.clear = 'both';
        document.getElementById('pregunta'+actual).style.display = 'block';
        if (actual === preguntas.length - 1) {
          document.getElementById('fieldset'+actual).innerHTML += "<input type='hidden' value='"+respuestas.join('¬')+"' name='respuestas'/>";
        }
      }
    } else {
      alert('You must check one first.');
    }
  }
</script>
</div>
<?php
    } else echo print_message('danger', 'Quiz not found in our database.'); // in case the quizz does not exists in the database.
    mysqli_free_result ($r);
  } else echo print_message('danger', 'No quiz selected.'); // in case the qid given in the url is not correct.
} else echo print_message('danger', 'You are not logged in.'); // in case is not logged in.
include("includes/footer.html");
?>