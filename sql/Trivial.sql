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
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (1,"¿Cuál de estos videojuegos salio primero en el mercado?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (2,"Tetris.",0,1)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (3,"Pong.",0,1)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (4,"Nought and Crosses.",1,1)
-- 2
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (5,"¿Que relación tienen Mario y Wario?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (6,"Son amigos.",1,5)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (7,"Pareja de hecho.",0,5)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (8,"Enemigos.",0,5)
-- 3
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (9,"¿Cuál de estas peliculas no se ha convertido en un videojuego?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (10,"Matrix.",null,9)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (11,"Easy Rider.",null,9)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (12,"Star Wars: La Amenaza Fantasma.",null,9)
-- 4
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (13,"¿Que empresa desarollo el juego "Crash Bandicoot" para PSOne ?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (14,"Bandai.",0,13)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (15,"Square Enix.",0,13)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (16,"Naughty Dog.",1,13)
-- 5
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (17,"¿Cuál es la compañia que creo Steam?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (18,"Sony.",0,17)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (19,"Valve.",1,17)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (20,"Blitzzard.",0,17)
-- 6
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (21,"¿En cual juego sale el personaje "Phara"?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (22,"League Of Legends.",0,21)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (23,"League Of Angels",0,21)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (24,"Overwatch.",1,21)
-- 7
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (25,"¿En que juego sale la "Ciudad de Balamb"?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (26,"Final Fantasy VII.",0,25)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (27,"Dragon Quest IV.",0,25)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (28,"Final Fantasy VII.",1,25)
-- 8
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (29,"¿Cuál de estas peliculas no se ha convertido en un videojuego?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (30,"Matrix.",null,29)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (31,"Easy Rider.",null,29)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (32,"Star Wars: La Amenaza Fantasma.",null,29)
-- 9
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (33,"¿Cuál de estas peliculas no se ha convertido en un videojuego?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (34,"Matrix.",null,33)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (35,"Easy Rider.",null,33)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (36,"Star Wars: La Amenaza Fantasma.",null,33)
-- 10
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (37,"¿Cuál de estas peliculas no se ha convertido en un videojuego?",null,null)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (38,"Matrix.",null,37)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (39,"Easy Rider.",null,37)
INSERT INTO questions_answers(id_qa,Description,Value,id_b) VALUES (40,"Star Wars: La Amenaza Fantasma.",null,37)
