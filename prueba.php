<?php
require ('mysqli_connect.php');
include("includes/header.html");
include('includes/print_messages.php');

if (isset($_GET['qid']) && is_numeric($_GET['qid'])) {
  $qid = $_GET['qid'];
  $q = "SELECT title, description FROM quizzes WHERE id_quiz=$qid";
  $r = @mysqli_query ($dbc, $q);
  $num = mysqli_num_rows($r);
  if ($num == 1) {
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    $quiz_title = $row['title'];
    $quiz_desc = $row['description'];
?>
<div class="row">
  <div class="jumbotron text-center col-10 offset-1">
    <h1><?php echo $quiz_title;?></h1> 
    <p><?php echo $quiz_desc;?></p>
  </div>
</div>
<hr>
<div class="form-quiz" style="margin-left: 20px;">
  <!--<form action="quiz.php" method="POST">-->

    <div id="print-here"></div>

<script>
  <?php
    $q = "SELECT id_question, description FROM questions WHERE id_quiz=$qid";
    $r = @mysqli_query ($dbc, $q);
    $num = mysqli_num_rows($r);
    if ($num > 0) {
      echo 'const preguntas = [';
      for($j=1; $j<=$num; $j++) {
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
        $id_question = $row['id_question'];
        $question = $row['description'];
        $question = str_replace("'", '"', $question);
        echo "['$question', ";
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

  function generateQuestion() {
    document.getElementById('print-here').innerHTML = '<div id="pregunta'+actual+'"><fieldset id="fieldset'+actual+'" class="form-group"></fieldset><button class="btn btn-primary" onclick="nextQuestion()">Next</button></div></div>';
    preguntas[actual].forEach((respuesta, j) => {
      if (j===0) document.getElementById('fieldset'+actual).innerHTML += "<legend>"+respuesta+"</legend>";
      else document.getElementById('fieldset'+actual).innerHTML += "<div class='form-check disabled'><label class='custom-control custom-radio'><input value='"+respuesta+"' id='radio"+j+"' name='radio"+actual+"' type='radio' class='custom-control-input'><span class='custom-control-indicator'></span><span class='custom-control-description'>"+respuesta+"</span></label></div>";
    });
  }

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
        } else {
        respuestas.forEach((element, index) => {
          console.log(element);
        });
        var JSONrespuestas = JSON.stringify(respuestas);
        $.post("includes/results.php",{ respuestas:JSONrespuestas});
      }
    } else {
      alert('You must check one first.');
    }
  }
</script>
<?php
  } else echo print_message('danger', 'Quiz not found on our database.');
  mysqli_free_result ($r);
} else echo print_message('danger', 'No quiz selected.');
include("includes/footer.html");
?>