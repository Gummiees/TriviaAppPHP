-- Create database
CREATE DATABASE Trivial;

-- Create table 

-- Create table Quiz
CREATE TABLE quizzes
(
	id_quiz MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(25) NOT NULL,
	description VARCHAR(60) NOT NULL,
	theme VARCHAR(25) NOT NULL
);

-- Create table Questions and Answers
CREATE TABLE questions_answers
(
	id_qa MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	description VARCHAR(60) NOT NULL,
	value BIT NULL,
	id_b MEDIUMINT UNSIGNED NULL,
	id_quiz MEDIUMINT UNSIGNED NOT NULL,
	CONSTRAINT FK_father FOREIGN KEY (id_b) REFERENCES questions_answers(id_qa),
	CONSTRAINT FK_quiz FOREIGN KEY (id_quiz) REFERENCES quizzes(id_quiz)
);

-- Create table Users
CREATE TABLE users
(
	id_user MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nick VARCHAR(20) NOT NULL,
	pass CHAR(40) NOT NULL,
	email VARCHAR(60) NOT NULL
);

-- Inserts

-- Users

 INSERT INTO users (nick,pass,email) VALUES ("root","root","root@trivial.com");

-- Quizzes

 INSERT INTO quizzes (title,description,theme) VALUES ("Quiz de videojuegos","Este quiz tiene varias preguntas sobre videojuegos de todos los géneros. ¿Te atreves?","Videojuegos");

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
(40,"2004.",0,37,1)