-- Create database
CREATE DATABASE Trivial;

-- Create table 

-- Create table Quiz
CREATE TABLE quizzes
(
	id_quiz MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(25) NOT NULL UNIQUE KEY,
	description VARCHAR(60) NOT NULL,
	theme VARCHAR(25) NOT NULL
);

-- Create table Questions and Answers
CREATE TABLE questions_answers
(
	id_qa MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	description VARCHAR(60) NOT NULL,
	value TINYINT(1)  NULL,
	id_b MEDIUMINT UNSIGNED NULL,
	id_quiz MEDIUMINT UNSIGNED NOT NULL,
	CONSTRAINT FK_father FOREIGN KEY (id_b) REFERENCES questions_answers(id_qa),
	CONSTRAINT FK_quiz FOREIGN KEY (id_quiz) REFERENCES quizzes(id_quiz)
);

-- Create table Users
CREATE TABLE users
(
	id_user MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nick VARCHAR(20) NOT NULL UNIQUE KEY,
	pass CHAR(40) NOT NULL,
	email VARCHAR(60) NOT NULL UNIQUE KEY
);

-- Inserts

-- Users
INSERT INTO users (nick,pass,email) VALUES ("root","root","root@trivial.com");
-- Quizzes
INSERT INTO quizzes (title,description,theme) VALUES
("Quiz de videojuegos","Este quiz tiene varias preguntas sobre videojuegos de todos los géneros. ¿Te atreves?","Videojuegos"),
("Quiz de memes","Este quiz tiene varias preguntas sobre memes en general. REEEEEEE","Memes");
-- Questions
-- Videogames
-- 1
INSERT INTO questions_answers(id_qa,Description,Value,id_b, id_quiz) VALUES 
(1,"¿Cuál de estos videojuegos salio primero en el mercado?",null,null,1),
(2,"Tetris.",0,1,1),
(3,"Pong.",0,1,1),
(4,"Nought and Crosses.",1,1,1),
-- 2
(5,"¿Que relación tienen Mario y Wario?",null,null,1),
(6,"Son amigos.",1,5,1),
(7,"Pareja de hecho.",0,5,1),
(8,"Enemigos.",0,5,1),
-- 3
(9,"¿Cuál de estas peliculas no se ha convertido en un videojuego?",null,null,1),
(10,"Matrix.",0,9,1),
(11,"Easy Rider.",1,9,1),
(12,"Star Wars: La Amenaza Fantasma.",0,9,1),
-- 4
(13,"¿Que empresa desarollo el juego 'Crash Bandicoot' para PSOne ?",null,null,1),
(14,"Bandai.",0,13,1),
(15,"Square Enix.",0,13,1),
(16,"Naughty Dog.",1,13,1),
-- 5
(17,"¿Cuál es la compañia que creo Steam?",null,null,1),
(18,"Sony.",0,17,1),
(19,"Valve.",1,17,1),
(20,"Blitzzard.",0,17,1),
-- 6
(21,"¿En cual juego sale el personaje 'Phara'?",null,null,1),
(22,"League Of Legends.",0,21,1),
(23,"League Of Angels",0,21,1),
(24,"Overwatch.",1,21,1),
-- 7
(25,"¿En que juego sale la 'Ciudad de Balamb'?",null,null,1),
(26,"Final Fantasy VII.",0,25,1),
(27,"Dragon Quest IV.",0,25,1),
(28,"Final Fantasy VII.",1,25,1),
-- 8
(29,"¿Cuales son los tres Pokemons iniciales en la segunda generación?",null,null,1),
(30,"Chikorita, Charmander y Totodile.",0,29,1),
(31,"Chikorita, Cyndaquil y Totodile.",1,29,1),
(32,"Chikorita, Cyndaquil y Squirtle.",0,29,1),
-- 9
(33,"¿Cuál es el nivel más alto en Rocket League",null,null,1),
(34,"Señor de los cohetes.",1,33,1),
(35,"Rey de los cohetes.",0,33,1),
(36,"El dios supremo de los cohetes.",1,33,1),
-- 10
(37,"¿En que año salio Counter Striker?",null,null,1),
(38,"1999.",1,37,1),
(39,"2000.",0,37,1),
(40,"2004.",0,37,1),

-- Memes
-- 1
(50,"Smile, Sweet, Sister, Sadistic, Suprise, ...",null,null,2),
(51,"Service",1,50,2),
(52,"Spicy",0,50,2),
(53,"Super.",1,50,2),
-- 2
(54,"Somebody ...",null,null,2),
(55,"is here!",0,54,2),
(56,"likes you",0,54,2),
(57,"once told me.",1,54,2),
-- 3
(58,"|, |l, ||, |_",null,null,2),
(59,"get straight",0,58,2),
(60,"is this a loss reference?",1,58,2),
(61,"is this a jojo's reference?",0,58,2),
-- 4
(62,"To Be Fair, You Have To Have a Very High IQ to Understand ...",null,null,2),
(63,"Stranger Things",0,62,2),
(64,"Rick and Morty",1,62,2),
(65,"Evangelion",0,62,2),
-- 5
(66,"Take off your jacket",null,null,2),
(67,"Man's no hot",1,66,2),
(68,"But... here?",0,66,2),
(69,"What the fuck",0,66,2),
-- 6
(70,"Sayori",null,null,2),
(71,"Hang there",1,70,2),
(72,"I love you",0,70,2),
(73,"B...Bakka! >///<",0,70,2),
-- 7
(74,"When I say go, be ready to throw... Go!",null,null,2),
(75,"Okay, now let's punch it.",0,74,2),
(76,"Just follow my moves, and sneak around.",0,74,2),
(77,"Thorw it on him not me! Uhg, let's try something else.",1,74,2),
-- 8
(78,"I'll have two number 9s ...",null,null,2),
(79,", a number 9 large, a number 2 with extra dip, a number 3, two number 45s, one with cheese, and a large soda.",0,74,2),
(80,", a number 9 large, a number 6 with extra dip, a number 7, two number 45s, one with cheese, and a large soda.",1,74,2),
(81,", a number 9 large, a number 4 with extra dip, a number 5, two number 45s, one with cheese, and a large soda.",0,74,2),
-- 9
(82,"When I say go, be ready to throw... Go!",null,null,2),
(83,"Okay, now let's punch it.",0,82,2),
(84,"Just follow my moves, and sneak around.",0,82,2),
(85,"Thorw it on him not me! Uhg, let's try something else.",1,82,2)