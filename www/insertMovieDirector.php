<?php
       
    $director = "'" . $_GET["director"] . "'";
    $movie = "'" . $_GET["movie"] . "'";
    
    // Attempt to create connection
    $db_connection = mysqli_connect("localhost", "cs143", "", "CS143");
    if (!$db_connection) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Sorry, there was a problem connecting to our database.<br />" .
            "Please try again later.";
        exit;
    }

    /* Attempt to insert director with movie */
    // First find the ID of the director
    $query = "SELECT id
                FROM (SELECT id, first, last
                        FROM Director
                        HAVING CONCAT_WS(\" \", first, last) = $director) D;";
    $data = mysqli_query($db_connection, $query);
    if (!$data) {
        $director = substr($director, 1, -1);
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "That director does not exist in our database.<br />" . 
            "Please add $director as a new director first.";
        mysqli_close($db_connection);
        exit;
    }
    $row = mysqli_fetch_row($data);
    $did = $row[0];

    // Then find the ID of the movie
    $query = "SELECT id
                FROM Movie
                WHERE title = $movie;";
    $data = mysqli_query($db_connection, $query);
    if (!$data) {
        $movie = substr($movie, 1, -1);
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "That movie does not exist in our database.<br />" .
            "Please <a href=\"addMovie.php\">add</a> <i>$movie</i> as " .
            "a new movie first.";
        mysqli_close($db_connection);
        exit;
    }
    $row = mysqli_fetch_row($data);
    $mid = $row[0];

    // Finally insert director and movie together into MovieDirector
    $query = "INSERT INTO MovieDirector(mid, did)
                VALUES($mid, $did);";
    if (!mysqli_query($db_connection, $query)) {
        $director = substr($director, 1, -1);
        $movie = substr($movie, 1, -1);
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "There was a problem adding $director with <i>$movie</i> to our " .
            "database.<br />Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }

    // Close connection
    mysqli_close($db_connection);

    echo "<h1 id=\"succHead\">Success!</h1>" . 
        "Successfully added!<br />" .
        "Have a director direct another movie?  The form is ready again!";

?>
