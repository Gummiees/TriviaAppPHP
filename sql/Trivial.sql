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

CREATE TABLE stadistics_user (
	id_stad_usr MEDIUMINT(8) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    id_quiz MEDIUMINT(8) UNSIGNED NOT NULL,
    average DECIMAL(5,4) UNSIGNED NOT NULL,
    date DATETIME NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_id_quiz FOREIGN KEY (id_quiz) REFERENCES quizzes(id_quiz) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE stadistics_quiz (
	id_stad_quiz MEDIUMINT(8) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    id_user MEDIUMINT(8) UNSIGNED NOT NULL,
    average DECIMAL(5,4) UNSIGNED NOT NULL,
    date DATETIME NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_id_user FOREIGN KEY (id_user) REFERENCES users(id_user) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Inserts

-- Users
INSERT INTO users (nick,pass,email) VALUES
("root",SHA1("root"),"root@trivial.com"),
("test",SHA1("test"),"test@test.com");
-- Quizzes
INSERT INTO quizzes (id_quiz, title, description, theme) VALUES
(1, "Videogames quiz","This quiz has different questions about videogames of all types of genres. Are you ready for the challenge?","Videogames"),
(2, "Memes quiz","This quiz has various questions about general memes. REEEEEEE","Memes");
-- Questions
-- Videogames
-- 1
INSERT INTO questions(id_question, description, id_quiz) VALUES 
(1, "Which of those videogames came out first on the market?", 1),
(2, "What relation have Mario and Wario?", 1),
(3, "Which of those films does not have a videogame?", 1),
(4, "Which business developed the game 'Crash Bandicoot' for PSOne?", 1),
(5, "Which company created Steam?", 1),
(6, "In which game appears the character 'Phara'?", 1),
(7, "In which game appears the city 'Balamb Town'?", 1),
(8, "Which are the three initial Pokemons in the second generation?", 1),
(9, "Which is the highest level in Rocket League?", 1),
(10, "In what year came out Counter Strike?", 1),
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
(4,"They are friends.",1,2),
(5,"They are a couple.",0,2),
(6,"Enemies.",0,2),
(7,"Matrix.",0,3),
(8,"Easy Rider.",1,3),
(9,"Star Wars: The Phantom Menace.",0,3),
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
(21,"Final Fantasy VIII.",1,7),
(22,"Chikorita, Charmander and Totodile.",0,8),
(23,"Chikorita, Cyndaquil and Totodile.",1,8),
(24,"Chikorita, Cyndaquil and Squirtle.",0,8),
(25,"Rocketeer.",1,9),
(26,"King of the rockets.",0,9),
(27,"God of the rockets.",0,9),
(28,"1999.",1,10),
(29,"2000.",0,10),
(30,"2004.",0,10),
(31,"Service",1,11),
(32,"Spicy",0,11),
(33,"Super",0,11),
(34,"is here!",0,12),
(35,"likes you",0,12),
(36,"once told me",1,12),
(37,"get straight",0,13),
(38,"is this a loss reference?",1,13),
(39,"is this a jojos reference?",0,13),
(40,"Stranger Things",0,14),
(41,"Rick and Morty",1,14),
(42,"Evangelion",0,14),
(43,"Man is no hot",1,15),
(44,"But... here?",0,15),
(45,"What the fuck",0,15),
(46,"Hang there",1,16),
(47,"I love you",0,16),
(48,"B...Bakka! >///<",0,16),
(49,"Okay, now lets punch it.",0,17),
(50,"Just follow my moves, and sneak around.",0,17),
(51,"Throw it on him not me! Uhg, lets try something else.",1,17),
(52,"a number 9 large, a number 2 with extra dip, a number 3, two number 45s, one with cheese, and a large soda.",0,18),
(53,"a number 9 large, a number 6 with extra dip, a number 7, two number 45s, one with cheese, and a large soda.",1,18),
(54,"a number 9 large, a number 4 with extra dip, a number 5, two number 45s, one with cheese, and a large soda.",0,18);