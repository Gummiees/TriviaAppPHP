

<?php 
	include("includes/header.html");
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
	
	  $bus = trim($_POST['sea']);
	  
	  if (empty($bus)){
		$text = 'Búsqueda sin resultados';
	  	}else{
		    require ('mysqli_connect.php');
		    include ('includes/print_messages.php');
		    $q = "SELECT id_quiz,title,description,image FROM quizzes WHERE title LIKE '%".$bus."%' ORDER BY id_quiz";        
		   	$r = @mysqli_query ($dbc, $q);
		    if (mysqli_num_rows($r) > 0) {
		        $i = 0;
		        while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)){
		            $id_quiz= $row['id_quiz'];
		            $title=$row['title'];
		            $description=$row['description'];
		            $image=$row['image'];
		            if ($i%2==0 || $i==0) echo '<div class="row">'; 
		            echo '<div class="col-6" style="text-align:center;">
		                <center><a href="quiz.php?qid='.$id_quiz.'"><h3>'.$title.'</h3></a></center>
		                <p>'.$description.'</p>
		                <img src="'.$image.'" width="500px" />
		            </div>';
		            if ($i%2==1) echo '</div>'; 
		            $i++;
		        }
		    echo '</div>';
		    } else echo 'There is no quiz that contains this parameter '.$bus.' ...';
		} 
		mysqli_close($dbc);
	  }
	include("includes/footer.html");
?>