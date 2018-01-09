-- Create database
CREATE DATABASE Trivial;

-- Create table 

-- Create table Quiz
CREATE TABLE quizzes
(
	id_quiz MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(25) NOT NULL UNIQUE KEY,
	description VARCHAR(250) NOT NULL,
	theme VARCHAR(25) NOT NULL
);

-- Create table Questions and Answers
CREATE TABLE questions
(
	id_question MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	description VARCHAR(250) NOT NULL,
	id_quiz MEDIUMINT(8) UNSIGNED NOT NULL,
	CONSTRAINT FK_quiz FOREIGN KEY (id_quiz) REFERENCES quizzes(id_quiz)
);

CREATE TABLE answers
(
	id_answer MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	description VARCHAR(250) NOT NULL,
	value TINYINT(1) NOT NULL,
	id_question MEDIUMINT(8) UNSIGNED NOT NULL,
	CONSTRAINT FK_question FOREIGN KEY (id_question) REFERENCES questions(id_question)
);
-- Create table Users
CREATE TABLE users
(
	id_user MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nick VARCHAR(20) NOT NULL UNIQUE KEY,
	pass CHAR(40) NOT NULL,
	email VARCHAR(60) NOT NULL UNIQUE KEY
);

-- Inserts

-- Users
INSERT INTO users (nick,pass,email) VALUES ("root","root","root@trivial.com");
-- Quizzes
INSERT INTO quizzes (id_quiz, title, description, theme) VALUES
(1, "Quiz de videojuegos","Este quiz tiene varias preguntas sobre videojuegos de todos los géneros. ¿Te atreves?","Videojuegos"),
(2, "Quiz de memes","Este quiz tiene varias preguntas sobre memes en general. REEEEEEE","Memes");
-- Questions
-- Videogames
-- 1
INSERT INTO questions(id_question, description, id_quiz) VALUES 
(1, "¿Cuál de estos videojuegos salio primero en el mercado?", 1),
(2, "¿Que relación tienen Mario y Wario?", 1),
(3, "¿Cuál de estas peliculas no se ha convertido en un videojuego?", 1),
(4, "¿Que empresa desarollo el juego 'Crash Bandicoot' para PSOne?", 1),
(5, "¿Cuál es la compañia que creo Steam?", 1),
(6, "¿En cual juego sale el personaje 'Phara'?", 1),
(7, "¿En que juego sale la 'Ciudad de Balamb'?", 1),
(8, "¿Cuales son los tres Pokemons iniciales en la segunda generación?", 1),
(9, "¿Cuál es el nivel más alto en Rocket League?", 1),
(10, "¿En que año salio Counter Strike?", 1),
(11,"Smile, Sweet, Sister, Sadistic, Suprise, ...",2),
(12,"Somebody ...",2),
(13,"|, |l, ||, |_",2),
(14,"To Be Fair, You Have To Have a Very High IQ to Understand ...",2),
(15,"Take off your jacket",2),
(16,"Sayori",2),
(17,"When I say go, be ready to throw... Go!",2),
(18,"I'll have two number 9s, ...",2);

INSERT INTO answers(id_answer, description, value, id_question) VALUES
(1, "Tetris.",0,1),
(2, "Pong.",0,1),
(3, "Nought and Crosses.",1,1),
(4,"Son amigos.",1,2),
(5,"Pareja de hecho.",0,2),
(6,"Enemigos.",0,2),
(7,"Matrix.",0,3),
(8,"Easy Rider.",1,3),
(9,"Star Wars: La Amenaza Fantasma.",0,3),
(10,"Bandai.",0,4),
(11,"Square Enix.",0,4),
(12,"Naughty Dog.",1,4),
(13,"Sony.",0,5),
(14,"Valve.",1,5),
(15,"Blitzzard.",0,5),
(16,"League Of Legends.",0,6),
(17,"League Of Angels",0,6),
(18,"Overwatch.",1,6),
(19,"Final Fantasy VII.",0,7),
(20,"Dragon Quest IV.",0,7),
(21,"Final Fantasy VII.",1,7),
(22,"Chikorita, Charmander y Totodile.",0,8),
(23,"Chikorita, Cyndaquil y Totodile.",1,8),
(24,"Chikorita, Cyndaquil y Squirtle.",0,8),
(25,"Señor de los cohetes.",1,9),
(26,"Rey de los cohetes.",0,9),
(27,"El dios supremo de los cohetes.",1,9),
(28,"1999.",1,10),
(29,"2000.",0,10),
(30,"2004.",0,10),
(31,"Service",1,11),
(32,"Spicy",0,11),
(33,"Super.",1,11),
(34,"is here!",0,12),
(35,"likes you",0,12),
(36,"once told me.",1,12),
(37,"get straight",0,13),
(38,"is this a loss reference?",1,13),
(39,"is this a jojo's reference?",0,13),
(40,"Stranger Things",0,14),
(41,"Rick and Morty",1,14),
(42,"Evangelion",0,14),
(43,"Man's no hot",1,15),
(44,"But... here?",0,15),
(45,"What the fuck",0,15),
(46,"Hang there",1,16),
(47,"I love you",0,16),
(48,"B...Bakka! >///<",0,16),
(49,"Okay, now let's punch it.",0,17),
(50,"Just follow my moves, and sneak around.",0,17),
(51,"Thorw it on him not me! Uhg, let's try something else.",1,17),
(52,"a number 9 large, a number 2 with extra dip, a number 3, two number 45s, one with cheese, and a large soda.",0,18),
(53,"a number 9 large, a number 6 with extra dip, a number 7, two number 45s, one with cheese, and a large soda.",1,18),
(54,"a number 9 large, a number 4 with extra dip, a number 5, two number 45s, one with cheese, and a large soda.",0,18);