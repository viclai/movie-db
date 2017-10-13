# Queries to test the dataset

-- Retrieves the full names (first and last) of all actors in the movie 
-- "Die Another Day"
SELECT CONCAT_WS(" ", first, last) AS Full_Name
FROM Actor, MovieActor
WHERE id = aid AND mid = (
    SELECT id
    FROM Movie
    WHERE title='Die Another Day');

-- Returns the number of actors who acted in more than 1 movie
SELECT COUNT(aid) AS Number_of_Actors_in_Multiple_Movies
FROM (
    SELECT aid
    FROM MovieActor
    GROUP BY aid
    HAVING COUNT(mid) >= 2) A;

-- Returns the average number of actors in a movie (in MovieDatabase)
SELECT AVG(nActors) AS Average_Number_of_Actors_in_a_Movie
FROM (
    SELECT COUNT(aid) AS nActors
    From MovieActor
    GROUP BY mid) tb;
