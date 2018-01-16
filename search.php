<?php
include("includes/header.html");
$text = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	
  $bus = trim($_POST['sea']);
  
  if (empty($bus)){
	$text = 'Búsqueda sin resultados';
  }else{
	require ("mysqli_connect.php");
	//Contulta para la base de datos, se utiliza un comparador LIKE para acceder a todo lo que contenga la cadena a buscar
	$sql = "SELECT title FROM quizzes WHERE title LIKE '%".$bus."%' ORDER BY id_quiz";
	//Ejecución de la consulta
	$resul= mysqli_query($dbc,$sql); 
    //Si hay resultados...
	if (mysqli_num_rows($resul) > 0){
		while($fila = mysqli_fetch_assoc($resul)){ 
            $text .= '<h2>'.$fila['title'] .'</h2><br/>';
		}
	  
	}else{
		$text = "No existe nada con ".$bus."...";
	}
	mysqli_close($dbc);
  }
  echo $text;
}
include("includes/footer.html");
?>