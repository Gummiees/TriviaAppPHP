<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['qid'])) {
	$respuestas=json_decode($_POST['respuestas']);
	forEach ($respuestas as $i => $respuesta) {
	  var_dump($respuesta);
	  $respuestas[$i] = mysqli_real_escape_string($dbc, $respuesta);
	}

	$qid = $_GET['qid'];
	$q = "SELECT A.value, A.description FROM quizzes AS Qz INNER JOIN
		(questions AS Qt INNER JOIN answers AS A ON Qt.id_question = A.id_question)
	ON Qz.id_quiz = Qt.id_quiz WHERE Qz.id_quiz=$qid";
	// INNER JOIN questions_answers AS QA ON Q.id_quiz = QA.id_quiz
	$r = @mysqli_query ($dbc, $q);
	$num = mysqli_num_rows($r);
	if ($num > 0) {
		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			$answer = $row['answer'];
			$value = $row['value'];
		}
	}
}
?>