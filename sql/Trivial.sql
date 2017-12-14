-- Create database
CREATE DATABASE Trivial
GO
-- Create table Questions and Answers
CREATE TABLE questions_answers
(
	id_qa MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Description VARCHAR(60) NOT NULL,
	Value BIT NULL,
	id_b INT NULL
)
GO
-- Create table 

-- Create table Users
CREATE TABLE users
(
	id_user MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Nick VARCHAR(20) NOT NULL,
	Pass CHAR(40) NOT NULL,
	Email VARCHAR(60) NOT NULL
)
GO
--
CONSTRAINT PK_Id PRIMARY KEY (Id_qa),
CONSTRAINT FK_father FOREIGN KEY (id_b) REFERENCES questions_answers)
-- Users
 INSERT INTO users (Nick,Pass,Email) VALUES ("root","root","root@trivial.com")
-- Questions
-- Videogames
-- 1
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (1,"�Cu�l de estos videojuegos salio primero en el mercado?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (2,"Tetris.",0,1)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (3,"Pong.",0,1)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (4,"Nought and Crosses.",1,1)
-- 2
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (5,"�Que relaci�n tienen Mario y Wario?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (6,"Son amigos.",1,5)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (7,"Pareja de hecho.",0,5)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (8,"Enemigos.",0,5)
-- 3
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (9,"�Cu�l de estas peliculas no se ha convertido en un videojuego?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (10,"Matrix.",null,9)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (11,"Easy Rider.",null,9)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (12,"Star Wars: La Amenaza Fantasma.",null,9)
-- 4
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (13,"�Que empresa desarollo el juego "Crash Bandicoot" para PSOne ?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (14,"Bandai.",0,13)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (15,"Square Enix.",0,13)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (16,"Naughty Dog.",1,13)
-- 5
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (17,"�Cu�l es la compa�ia que creo Steam?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (18,"Sony.",0,17)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (19,"Valve.",1,17)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (20,"Blitzzard.",0,17)
-- 6
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (21,"�En cual juego sale el personaje "Phara"?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (22,"League Of Legends.",0,21)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (23,"League Of Angels",0,21)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (24,"Overwatch.",1,21)
-- 7
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (9,"�En que juego sale la "Ciudad de Balamb"?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (10,"Final Fantasy VII.",0,9)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (11,"Dragon Quest IV.",0,9)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (12,"Final Fantasy VII.",1,9)
-- 8
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (9,"�Cu�l de estas peliculas no se ha convertido en un videojuego?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (10,"Matrix.",null,9)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (11,"Easy Rider.",null,9)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (12,"Star Wars: La Amenaza Fantasma.",null,9)
-- 9
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (9,"�Cu�l de estas peliculas no se ha convertido en un videojuego?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (10,"Matrix.",null,9)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (11,"Easy Rider.",null,9)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (12,"Star Wars: La Amenaza Fantasma.",null,9)
-- 10
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (9,"�Cu�l de estas peliculas no se ha convertido en un videojuego?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (10,"Matrix.",null,9)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (11,"Easy Rider.",null,9)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (12,"Star Wars: La Amenaza Fantasma.",null,9)
