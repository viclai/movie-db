# Statements that violate constraints

-- Violates primary key constraint where every tuple in Movie has a unique id
INSERT INTO Movie
    VALUES(272, 'Minions', 2015, 'PG', 'Illumination');
-- ERROR 1062 (23000): Duplicate entry '272' for key 'PRIMARY'

-- Violates primary key constraint where every tuple in Actor has a unique id
INSERT INTO Actor
    VALUES(1, 'Steinfield', 'Hailee', 'Female', '1996-12-11', NULL);
-- ERROR 1062 (23000): Duplicate entry '1' for key 'PRIMARY'

-- Violates CHECK constraint of sex being either 'Female' or 'Male
INSERT INTO Actor
    VALUES(69001, 'Minion', 'Bob', 'It', '2006-10-12', NULL);

-- Violates CHECK constraint of date of birth being earlier than date of death
INSERT INTO Actor
    VALUES(69001, 'Shackleford', 'Rusty', '2015-10-17', '1997-11-24');

-- Violates primary key constraint where every tuple in Director has a unique
-- id
INSERT INTO Director
    VALUES(37146, 'Fincher', 'David', '1962-8-28', NULL);
-- ERROR 1062 (23000): Duplicate entry '37146' for key 'PRIMARY'

-- Violates CHECK constraint of date of birth being earlier than date of death
INSERT INTO Director
    VALUES(69001, 'Quon', 'Brian', '1994-12-25', '1972-12-25');

-- Violates the referential constraint where every mid in MovieGenre should
-- map to an existing id in Movie
INSERT INTO MovieGenre
    VALUES(5000, 'Romance');
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key
-- constraint fails ('CS143'. 'MovieGenre', CONSTRAINT 'MovieGenre_ibfk_1'
-- FOREIGN KEY ('mid') REFERENCES 'Movie' ('id'))

-- Violates the referential constraint where every mid in MovieDirector should
-- map to an existing id in Movie
INSERT INTO MovieDirector
    VALUES(5000, 112);
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key
-- constraint fails ('CS143'. 'MovieDirector', CONSTRAINT 'MovieDirector_ibfk_1'
-- FOREIGN KEY ('mid') REFERENCES 'Movie' ('id'))

-- Violates the referential constraint where every did in MovieDirector should
-- map to an existing id in Director
INSERT INTO MovieDirector
    VALUES(3, 69001);
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key
-- constraint fails ('CS143'. 'MovieDirector', CONSTRAINT 'MovieDirector_ibfk_2'
-- FOREIGN KEY ('did') REFERENCES 'Director' ('id'))

-- Violates the referential constraint where every mid in MovieActor should
-- map to an existing id in Movie
INSERT INTO MovieActor
    VALUES(5000, 10208, 'Dog');
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key
-- constraint fails ('CS143'. 'MovieActor', CONSTRAINT 'MovieActor_ibfk_1'
-- FOREIGN KEY ('mid') REFERENCES 'Movie' ('id'))

-- Violates the referential constraint where every aid in MovieActor should
-- map to an existing id in Actor
INSERT INTO MovieActor
    VALUES(100, 69100, 'Cat');
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key
-- constraint fails ('CS143'. 'MovieActor', CONSTRAINT 'MovieActor_ibfk_2'
-- FOREIGN KEY ('aid') REFERENCES 'Actor' ('id'))

-- Violates the referential constraint where every mid in Review should map
-- to an existing id in Movie
INSERT INTO Review
    VALUES('William', NULL, 6000, 5, 'Terrible');
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key
-- constraint fails ('CS143'. 'Review', CONSTRAINT 'Review_ibfk_1'
-- FOREIGN KEY ('mid') REFERENCES 'Movie' ('id'))
