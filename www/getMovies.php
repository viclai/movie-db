<?php
       
    $q = $_GET["q"];
    $suggestions = "";

    if ($q != "") {

        // Attempt to create connection
        $db_connection = mysqli_connect("localhost", "cs143", "", "CS143");
        if (!$db_connection) {
            echo "-1";
            exit;
        }
        
        $keywords = $q;
        $keywords = str_replace(" ", "%", $keywords);
        $keywords .= "%";
        $keywords = "%" . $keywords;
        $search = "SELECT title
                    FROM Movie
                    WHERE title LIKE LOWER('" . $keywords . "')
                    ORDER BY title
                    LIMIT 4;";
        $data = mysqli_query($db_connection, $search);
        if (!$data) {
            echo "-1";
            mysqli_close($db_connection);
            exit;
        }

        // Only display 4 options at a time
        while ($row = mysqli_fetch_row($data))
            $suggestions .= "<option value='$row[0]' />";

        // Close connection
        mysqli_close($db_connection);
    }
    
    echo $suggestions;
?>
