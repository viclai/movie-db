<?php
       
    $actor = "'" . $_GET["actor"] . "'";
    $movie = "'" . $_GET["movie"] . "'";
    $role = $_GET["role"];
    if ($role == "")
        $role = "NULL";
    else
        $role = "'" . $_GET["role"] . "'";
    
    // Attempt to create connection
    $db_connection = mysqli_connect("localhost", "cs143", "", "CS143");
    if (!$db_connection) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Sorry, there was a problem connecting to our database.<br />" .
            "Please try again later.";
        exit;
    }

    /* Attempt to insert actor with movie */
    // First find the ID of the actor
    $query = "SELECT id
                FROM (SELECT id, first, last
                        FROM Actor
                        HAVING CONCAT_WS(\" \", first, last) = $actor) A;";
    $data = mysqli_query($db_connection, $query);
    if (!$data) {
        $actor = substr($actor, 1, -1);
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "That actor does not exist in our database.<br />" . 
            "Please add $actor as a new actor first.";
        mysqli_close($db_connection);
        exit;
    }
    $row = mysqli_fetch_row($data);
    $aid = $row[0];

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

    // Finally insert actor and movie together into MovieActor
    $query = "INSERT INTO MovieActor(mid, aid, role)
                VALUES($mid, $aid, $role);";
    if (!mysqli_query($db_connection, $query)) {
        $actor = substr($actor, 1, -1);
        $movie = substr($movie, 1, -1);
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "There was a problem adding $actor with <i>$movie</i> to our " .
            "database." .
            "<br />Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }

    // Close connection
    mysqli_close($db_connection);

    echo "<h1 id=\"succHead\">Success!</h1>" . 
        "Successfully added!<br />" .
        "Have an actor appear in another movie?  The form is ready again!";

?>
