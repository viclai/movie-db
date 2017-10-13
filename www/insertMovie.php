<?php
       
    $title = "'" . $_GET["title"] . "'";
    $company = "'" . $_GET["company"] . "'";
    $year = $_GET["year"];
    $rating = $_GET["rating"];
    if ($rating == "")
        $rating = "NULL";
    else
        $rating = "'" . $rating . "'";
    $genres = $_GET["genres"];

    // Attempt to create connection
    $db_connection = mysqli_connect("localhost", "cs143", "", "CS143");
    if (!$db_connection) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Sorry, there was a problem connecting to our database.<br />" .
            "Please try again later.";
        exit;
    }

    /* Attempt to insert movie */
    // First increment id in MaxMovieID
    $query = "UPDATE MaxMovieID
                SET id = id + 1;";
    if (!mysqli_query($db_connection, $query)) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Oops, there was an error.<br />" .
            "Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }

    // Then get unqiue ID from MaxMovieID
    $query = "SELECT *
                FROM MaxMovieID;";
    $data = mysqli_query($db_connection, $query);
    if (!$data) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Oops, there was an error.<br />" .
            "Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }
    $row = mysqli_fetch_row($data);
    $id = $row[0];

    // Finally insert movie information into movie
    $query = "INSERT INTO Movie(id, title, year, rating, company)
                VALUES($id, $title, $year, $rating, $company);";
    if (!mysqli_query($db_connection, $query)) {
        $title = substr($title, 1, -1);
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "There was a problem adding <i>$title</i> to our database." . 
            "<br />Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }

    // Insert genres (if any)
    $selectedGenres = split("\|", $genres);
    for ($i = 0; $i < sizeof($selectedGenres); $i++) {
        if ($selectedGenres[$i] == "")
            continue;
        $query = "INSERT INTO MovieGenre(mid, genre)
                    VALUES($id, '" . $selectedGenres[$i] . "');";
        if (!mysqli_query($db_connection, $query)) {
            echo "<h1 id=\"errorHead\">ERROR</h1>" . 
                "Oops, there was an error.<br />" .
                "Please contact the administrator for help.";
            mysqli_close($db_connection);
            exit;
        }
    }

    // Close connection
    mysqli_close($db_connection);

    $title = substr($title, 1, -1);
    echo "<h1 id=\"succHead\">Success!</h1>" . 
        "Successfully inserted <i>$title</i>!" .
        "<br />Have another movie to add? Fill in the form again!";
?>
