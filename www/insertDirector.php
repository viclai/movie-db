<?php
       
    $first = "'" . $_GET["first"] . "'";
    $last = "'" . $_GET["last"] . "'";
    $birth = $_GET["birth"];
    if ($birth == "")
        $birth = "NULL";
    else
        $birth = "'" . $birth . "'";
    $death = $_GET["death"];
    if ($death == "")
        $death = "NULL";
    else
        $death = "'" . $death . "'";

    // Attempt to create connection
    $db_connection = mysqli_connect("localhost", "cs143", "", "CS143");
    if (!$db_connection) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Sorry, there was a problem connecting to our database.<br />" .
            "Please try again later.";
        exit;
    }

    /* Attempt to insert director */
    // First increment id in MaxPersonID
    $query = "UPDATE MaxPersonID
                SET id = id + 1;";
    if (!mysqli_query($db_connection, $query)) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Oops, there was an error.<br />" .
            "Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }

    // Then get unqiue ID from MaxPersonID
    $query = "SELECT *
                FROM MaxPersonID;";
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

    // Finally insert director information into Director
    $query = "INSERT INTO Director(id, last, first, dob, dod)
                VALUES($id, $last, $first, $birth, $death);";
    if (!mysqli_query($db_connection, $query)) {
        $first = substr($first, 1, -1);
        $last = substr($last, 1, -1);
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "There was a problem adding $first $last to our database.<br />" .
            "Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }

    // Check that 'dob' and 'dod' attributes are not 0000-00-00
    $query = "SELECT dob, dod
                FROM Director
                WHERE first=$first AND last=$last;";
    $data = mysqli_query($db_connection, $query);
    if (!$data) {
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "Oops, there was an error.<br />" .
            "Please contact the administrator for help.";
        mysqli_close($db_connection);
        exit;
    }
    $row = mysqli_fetch_array($data, MYSQLI_ASSOC);
    if ($row["dob"] == "0000-00-00") {

        $query = "DELETE FROM Director
                    WHERE id=$id;";
        if (!mysqli_query($db_connection, $query)) {
            echo "<h1 id=\"errorHead\">ERROR</h1>" . 
                "Oops, there was an error.<br />" .
                "Please contact the administrator for help.";
            mysqli_close($db_connection);
            exit;
        }
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "You entered an invalid birth date.<br />" .
            "Please separate year, month, and day by a delimiter such " . 
            "as '-'.<br />The following are some acceptable formats.<br />" .
            "<i>yyyy-mm-dd, yyyy/mm/dd, yyyymmdd</i>";
        mysqli_close($db_connection);
        exit;
    }
    elseif ($row["dod"] == "0000-00-00") {

        $query = "DELETE FROM Director
                    WHERE id=$id;";
        if (!mysqli_query($db_connection, $query)) {
            echo "<h1 id=\"errorHead\">ERROR</h1>" . 
                "Oops, there was an error.<br />" .
                "Please contact the administrator for help.";
            mysqli_close($db_connection);
            exit;
        }
        echo "<h1 id=\"errorHead\">ERROR</h1>" . 
            "You entered an invalid date of death.<br />" .
            "Please separate year, month, and day by a delimiter such " . 
            "as '-'.<br />The following are some acceptable formats.<br />" .
            "<i>yyyy-mm-dd, yyyy/mm/dd, yyyymmdd</i>";
        mysqli_close($db_connection);
        exit;
    }

    // Close connection
    mysqli_close($db_connection);

    $first = substr($first, 1, -1);
    $last = substr($last, 1, -1);
    echo "<h1 id=\"succHead\">Success!</h1>" . 
        "Successfully inserted $first $last as a director!<br />" .
        "Have another director to add?  The form is ready again!";
?>
