<?php
session_start ();
include("includes/header.html");
include('includes/print_messages.php');
if (isset($_SESSION['id_user'])) {
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['qid']) && isset($_POST['respuestas'])) {
		require ('mysqli_connect.php');

		$res_usr = $_POST['respuestas'];
		$res_usr = preg_split("/¬+/", $res_usr);
		$radio = 'radio'.(count($res_usr));
		$res_usr[] = $_POST[$radio];

		$qid = $_GET['qid'];
		$uid = $_SESSION['id_user'];

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
		$incorrectas = 0;
		$preg = 0;
		foreach ($questions as $key => $question) {
?>

<div class="row">
	<div class="col-6 offset-3 respuestas">
			<h3><?php echo $question;?></h3>
<?php
	unset($answers);
	$q = "SELECT A.description, A.value FROM answers AS A INNER JOIN questions AS Q
	ON Q.id_question = A.id_question WHERE Q.id_question=$key";
	$r = @mysqli_query ($dbc, $q);
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$answers[$row['description']] = $row['value'];
	}
	foreach ($answers as $answer => $value) {
		if (0 == $value && $res_usr[$preg] == $answer) {
		 echo '<div class="row respuesta-incorrecta"><div class="col-1 text-center"><i class="fa fa-times" aria-hidden="true"></i></div>';
			$incorrectas++;
		} else if (1 == $value) {
			echo '<div class="row respuesta-correcta"><div class="col-1 text-center"><i class="fa fa-check" aria-hidden="true"></i></div>';
		} else {
			echo '<div class="row"><div class="col-1 text-center"><i class="fa fa-circle-o" aria-hidden="true"></i></div>';
		}
?>
				<div class="col-11 text-left respuesta"><?php echo $answer;?></div>
			</div>
			<?php } ?>
	</div>
</div>

<?php
			$preg++;
		}
		$media = 1 - ($incorrectas/count($questions));
		$q = "INSERT INTO statistics (id_user, id_quiz, average) VALUES ($uid, $qid, $media)";
		$r = @mysqli_query ($dbc, $q);
?>
<div class="row" style="margin-top: 50px;">
	<div class="col-4 offset-4">
		<button class="btn btn-lg btn-primary btn-block" type="button" onclick="Redirect()">See my statistics</button>
	</div>
</div>
<script>
		function Redirect () {
			window.location.href="user_stats.php?uid=<?php echo $uid;?>";
		}
</script>
<?php
	} else echo print_message('danger', 'You cannot access results unless you finished a quiz.');
} else echo print_message('danger', 'You are not logged in.');
include("includes/footer.html");
?>