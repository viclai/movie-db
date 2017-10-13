<?php
       
    $title = "'" . $_GET["title"] . "'";
    $reviewer = $_GET["name"];
    if ($reviewer == "")
        $reviewer = "'Anonymous'";
    else
        $reviewer = "'" . $reviewer . "'";
    $rating = $_GET["rating"];
    $comments = $_GET["comments"];
    if ($comments == "")
        $comments = "NULL";
    else {
        $comments = str_replace("'", "''", $comments);
        $comments = "'" . $comments . "'";
    }

    // Attempt to create connection
    $db_connection = mysqli_connect("localhost", "cs143", "", "CS143");
    if (!$db_connection) {
        echo "Sorry, there was a problem connecting to our database.<br />" .
            "Please try again later.";
        exit;
    }

    /* Attempt to insert Review */
    // First get ID of the movie
    $query = "SELECT id
                FROM Movie
                WHERE title=$title;";
    $data = mysqli_query($db_connection, $query);
    if (!$data) {
        $movie = substr($movie, 1, -1);
        echo "That movie does not exist in our database.<br />" .
            "Please <a href=\"addMovie.php\">add</a> <i>$movie</i> as " .
            "a new movie before reviewing.";
        mysqli_close($db_connection);
        exit;
    }
    $row = mysqli_fetch_row($data);
    $mid = $row[0];

    // Insert review into Review
    $query = "INSERT INTO Review(name, mid, rating, comment)
                VALUES($reviewer, $mid, $rating, $comments);";
    if (!mysqli_query($db_connection, $query)) {
        echo "There was a problem saving your review." . 
            "<br />Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }

    // Close connection
    mysqli_close($db_connection);

    echo "<h1 id=\"succHead\">Success!</h1>" . 
        "Successfully inserted your review!<br />" .
        "Wish to review another movie?  The form is ready again!";
?>
