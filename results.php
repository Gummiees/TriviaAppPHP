<?php
include("includes/header.html");
include('includes/print_messages.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['qid']) && isset($_POST['respuestas'])) {
	require ('mysqli_connect.php');
	$res_usr = $_POST['respuestas'];
	$res_usr = preg_split("/¬+/", $res_usr);
	$res_usr[] = $_POST['radio9'];

	$qid = $_GET['qid'];

	$q = "SELECT title FROM quizzes WHERE id_quiz=$qid";
  $r = @mysqli_query ($dbc, $q);
  $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
  $quiz_title = $row['title'];
?>
<div class="row">
  <div class="jumbotron text-center col-10 offset-1">
    <h1><?php echo $quiz_title;?></h1> 
    <p>Here are your results!</p>
  </div>
</div>
<hr>

<?php

	$q = "SELECT Qt.description, Qt.id_question FROM questions AS Qt INNER JOIN quizzes AS Qz
	ON Qz.id_quiz = Qt.id_quiz WHERE Qz.id_quiz=$qid";
	$r = @mysqli_query ($dbc, $q);
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$questions[$row['id_question']] = $row['description'];
	}

	$cont = 0;
	$preg = 0;
	foreach ($questions as $key => $question) {
?>

<div class="row">
	<div class="col-6 offset-3 respuestas">
			<h3><?php echo $question;?></h3>
<?php
	$answers = '';
	$q = "SELECT A.description, A.value FROM answers AS A INNER JOIN questions AS Q
	ON Q.id_question = A.id_question WHERE Q.id_question=$key";
	$r = @mysqli_query ($dbc, $q);
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$answers[$row['description']] = $row['value'];
	}
	foreach ($answers as $answer => $value) {
		if (0 == $value && $res_usr[$preg] == $answer) {
		 echo '<div class="row respuesta-incorrecta"><div class="col-1 text-right"><i class="fa fa-times" aria-hidden="true"></i></div>';
		} else if (1 == $value) {
			echo '<div class="row respuesta-correcta"><div class="col-1 text-right"><i class="fa fa-check" aria-hidden="true"></i></div>';
		} else {
			echo '<div class="row"><div class="col-1 text-right"></div>';
		}
?>
				<div class="col-11 text-left respuesta"><?php echo $answer;?></div>
			</div>
			<?php $cont++;} ?>
	</div>
</div>

<?php
	$preg++;}
} else echo print_message('danger', 'You cannot access results unless you finished a quiz.');
include("includes/footer.html");
?>