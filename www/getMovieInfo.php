<?php
       
    $movie = $_GET["movie"];

    // Attempt to create connection
    $db_connection = mysqli_connect("localhost", "cs143", "", "CS143");
    if (!$db_connection) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Sorry, there was a problem connecting to our database.<br />" .
            "Please try again later.";
        exit;
    }

    // Basic information about the movie
    $query = "SELECT *
                FROM Movie
                WHERE title = '$movie';";
    $data = mysqli_query($db_connection, $query);
    if (!$data) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Oops, there was an error.<br />" .
            "Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }

    $nRows = mysqli_num_rows($data);
    if ($nRows != 1) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Oops, there was an error.<br />" .
            "Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }

    $row = mysqli_fetch_array($data, MYSQLI_ASSOC);
    $info = "";
    $info .= "<h1>ABOUT <i>" . $row["title"] . "</i></h1>";
    $info .= "<b>Title</b>: " . $row["title"] . " (" . $row["year"] . 
        ")<br />";
    $info .= "<b>Producer</b>: " . $row["company"] . "<br />";
    $info .= "<b>MPAA Rating</b>: " . $row["rating"] . "<br />";
    $id = $row["id"];


    // Director(s) of the movie
    $query = "SELECT CONCAT_WS(\" \", first, last) AS full_name
                FROM Director
                WHERE id IN (
                    SELECT did
                    FROM MovieDirector
                    WHERE mid = (
                        SELECT id
                        FROM Movie
                        WHERE title = '$movie'));";
    $data = mysqli_query($db_connection, $query);
    if (!$data) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Oops, there was an error.<br />" .
            "Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }
    $dirs = "";
    while ($row = mysqli_fetch_array($data, MYSQLI_ASSOC)) {
        $dirs .= $row["full_name"] . ", ";
    }
    $dirs = substr($dirs, 0, strlen($dirs) - 2);
    $info .= "<b>Director(s)</b>: " . $dirs . "<br />";


    // Genre(s) of the movie
    $query = "SELECT genre
                FROM MovieGenre
                WHERE mid = (
                    SELECT id
                    FROM Movie
                    WHERE title = '$movie');";
    $data = mysqli_query($db_connection, $query);
    if (!$data) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Oops, there was an error.<br />" .
            "Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }

    $genres = "";
    while ($row = mysqli_fetch_array($data, MYSQLI_ASSOC)) {
        $genres .= $row["genre"] . ", ";
    }
    $genres = substr($genres, 0, strlen($genres) - 2);
    $info .= "<b>Genre(s)</b>: " . $genres . "<br />";
    $info .= "<br />";


    // Actors in the movie
    $query = "SELECT CONCAT_WS(\" \", first, last) AS full_name, role
                FROM Actor, (
                    SELECT aid, role 
                    FROM MovieActor
                    WHERE mid = (
                        SELECT id
                        FROM Movie
                        WHERE title = '$movie')
                ) M
                WHERE id = aid;";
    $data = mysqli_query($db_connection, $query);
    if (!$data) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Oops, there was an error.<br />" .
            "Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }

    $nRows = mysqli_num_rows($data);
    if (!$nRows)
        $info .= "<i>There are no actors in this movie.</i>";
    else {
        $info .= "<b>CAST</b>:";
        $info .= "<table>";
        while ($row = mysqli_fetch_array($data, MYSQLI_ASSOC)) {
            $info .= "<tr>";
            $actor = "<td><span id=\"sideLink\" " . 
                "onclick=\"showInfo('" . $row["full_name"] . "', 'Actor');\">" 
                . $row["full_name"] . "</span></td>";
            $line = $actor . "<td>as \"" . $row["role"] . "\"</td>";
            $info .= $line;
            $info .= "</tr>";
        }
        $info .= "</table>";
    }


    // Existing user reviews of this movie
    $query = "SELECT *
                FROM Review
                WHERE mid = $id;";
    $data = mysqli_query($db_connection, $query);
    if (!$data) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Oops, there was an error.<br />" .
            "Please contact the administrator for help.";
    }
    $nRows = mysqli_num_rows($data);
    if ($nRows == 0) {
        $info .= "<br /><i>There are no reviews for this movie.  " . 
            "Be the first!</i> " .
            "<a href=\"addReview.php?movie=$movie\">Write Review?</a>";
    }
    else {
        // Get average rating of the movie
        $query = "SELECT AVG(rating) AS Average
                    FROM Review
                    WHERE mid = $id;";
        $data = mysqli_query($db_connection, $query);
        if (!$data) {
            echo "<h1 id=\"errorHead\">ERROR</h1>" . 
                "Oops, there was an error.<br />" .
                "Please contact the administrator for help.";
            mysqli_close($db_connection);
            exit;
        }
        $row = mysqli_fetch_row($data);
        $avg = round($row[0], 1);
        $info .= "<br /><b>MOVIE REVIEWS</b>:<br />";
        $info .= "Average rating: $avg / 5 by $nRows review(s)." . 
            "<br /><a href=\"addReview.php?movie=$movie\">Write Review?</a>" .
            "<br /><br />";

        // Get content of all reviews
        $query = "SELECT *
                    FROM Review
                    WHERE mid = $id;";
        $data = mysqli_query($db_connection, $query);
        if (!$data) {
            echo "<h1 id=\"errorHead\">ERROR</h1>" . 
                "Oops, there was an error.<br />" .
                "Please contact the administrator for help.";
            mysqli_close($db_connection);
            exit;
        }

        while ($row = mysqli_fetch_array($data, MYSQLI_ASSOC)) {
            $monthDay = date('M j', strtotime($row["time"]));
            $year = date('Y', strtotime($row["time"]));
            $time = date('g:i A', strtotime($row["time"]));
            $full_date = $monthDay . ", " . $year . " at " . $time;
            $comment = $row["comment"];
            if ($comment == "") {
                $info .= "On " . $full_date . ", <span class=\"reviewer\">" .
                    $row["name"] . "</span>" .
                    " rated this movie a <span class=\"ratingColor\">" . 
                    $row["rating"] . "</span>.<br /><br />";
            }
            else {
                $info .= "On " . $full_date . ", <span class=\"reviewer\">" .
                    $row["name"] . "</span>" .
                    " rated this movie a <span class=\"ratingColor\">" . 
                    $row["rating"] . "</span>.<br />";
                $info .= "\"<i>" . $comment . "</i>\"<br /><br />";
            }
        }
    }


    // Close connection
    mysqli_close($db_connection);

    echo $info;
?>
