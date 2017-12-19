<?php
require ('mysqli_connect.php');
include("includes/header.html");
include('includes/print_messages.php');

//comprobar que está logueado

if (isset($_GET['qid']) && is_numeric($_GET['qid'])) {
	$qid = $_GET['qid'];
	$q = "SELECT title, description FROM quizzes WHERE id_quiz=$qid";
	// INNER JOIN questions_answers AS QA ON Q.id_quiz = QA.id_quiz
	$r = @mysqli_query ($dbc, $q);
	$num = mysqli_num_rows($r);
	if ($num == 1) {
		$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$quiz_title = $row['title'];
		$quiz_desc = $row['description'];			
?>
<div class="row">
	<div class="jumbotron text-center col-10 offset-1">
	  <h1 style="font-size: 4em;"><?php echo $quiz_title;?></h1> 
	  <p style="font-size: 1.5em;"><?php echo $quiz_desc;?></p>
	</div>
</div>
<hr>

<?php 
		//coger todas las preguntas
		$q = "SELECT id_question, description FROM questions WHERE id_quiz=$qid";
		$r = @mysqli_query ($dbc, $q);
		$num = mysqli_num_rows($r);
		if ($num > 0) {
			echo '<div class="form-quiz"><form action="quiz.php" method="POST">';
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$id_question = $row['id_question'];
				$question = $row['description'];
				//imprimir la pregunta
				echo '<fieldset class="form-group"><legend>'.$question.'</legend>';

				//coger todas las respuestas de esa pregunta
				$q1 = "SELECT description, value FROM answers WHERE id_question=$id_question";
				$r1 = @mysqli_query ($dbc, $q1);
				$n1 = mysqli_num_rows($r1);
				if ($n1 > 0) {
					while ($row1 = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
						$answer = $row1['description'];
						//imprimir la respuesta
						echo '<div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="optionsRadios1" id="optionsRadios1" value="option1" checked>'.$answer.'</label></div>';
					}
				}
				echo '</fieldset>';
			}
?>
	  <input type="submit" class="btn btn-success" />
	</form>
</div>
<hr>
<?php
		} else echo print_message('danger', 'No questions found for this quiz.');
	} else echo print_message('danger', 'Quiz not found on our database.');
	mysqli_free_result ($r);
} else echo print_message('danger', 'No quiz selected.');
	include("includes/footer.html");
?>