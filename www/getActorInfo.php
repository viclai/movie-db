<?php
       
    $actor = $_GET["actor"];

    // Attempt to create connection
    $db_connection = mysqli_connect("localhost", "cs143", "", "CS143");
    if (!$db_connection) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Sorry, there was a problem connecting to our database.<br />" .
            "Please try again later.";
        exit;
    }

    // Basic information about the actor
    $query = "SELECT *
                FROM Actor
                HAVING CONCAT_WS(\" \", first, last) = '$actor';";
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
    $info .= "<h1>ABOUT " . $row["first"] . " " . $row["last"] . "</h1>";
    $info .= "<b>Full name</b>: " . $row["first"] . " " . $row["last"] . 
        "<br />";
    $info .= "<b>Gender</b>: " . $row["sex"] . "<br />";
    $info .= "<b>Date of Birth</b>: " . $row["dob"] . "<br />";
    $info .= "<b>Date of Death</b>: " . $row["dod"] . "<br />";
    $info .= "<br />";

    // Acted in...
    $query = "SELECT title, role
                FROM Movie, (
                    SELECT mid, role 
                    FROM MovieActor
                    WHERE aid = (
                        SELECT id
                        FROM (
                            SELECT id, first, last
                            FROM Actor
                            HAVING CONCAT_WS(\" \", first, last) = '$actor'
                        ) M
                    )) A
                WHERE id = mid;";
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
        $info .= "<i>No movies acted in.</i>";
    else {
        $info .= "<b>MOVIES ACTED IN</b>:<br />";
        $info .= "<table>";
        while ($row = mysqli_fetch_array($data, MYSQLI_ASSOC)) {
            $info .= "<tr>";
            $movie = "<span id=\"sideLink\" onclick=\"showInfo('" . 
                $row["title"] . "', 'Movie');\"><i>" . $row["title"] . 
                "</i></span></td>";
            $line = "<td>\"" . $row["role"] . "\"</td><td>in " . 
                $movie;
            $info .= $line;
            $info .= "</tr>";
        }
        $info .= "</table>";
    }

    // Close connection
    mysqli_close($db_connection);

    echo $info;
?>
