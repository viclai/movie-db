<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php
                if (!isset($_GET["searchQ"]))
                    echo "DB Search";
                else
                    echo $_GET["searchQ"] . " - DB Search"; 
            ?>
        </title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <link rel="stylesheet" href="css/search.css" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/xmlRequest.js"></script>
        <script src="js/search.js"></script>
    </head>

    <body>

        <div class="flexbox-container" id="topBar">
            <div id="logoSection">
                <a href="index.php">
                    <img id="titleImg" src="images/title.gif" alt="MovieDB"
                        title="MovieDB" />
                </a>
            </div>
            <div id="searchBar">
                <form id="searchForm" method="get" action="search.php">
                    <input type="text" list="sug" id="searchIn" 
                        autocomplete="off" name="searchQ" 
                        value="<?php 
                                    if (isset($_GET["searchQ"]))
                                        echo $_GET["searchQ"];
                                ?>" />
                    <input type="submit" value="DB Search" id="searchButton" />
                    <datalist id="sug"></datalist>
                </form>
            </div>
        </div>

        <div class="flexbox-container" id="menu">
            <div id="srch">
                <a href="index.php">
                    <img class="imgButton" src="images/search.gif" 
                        alt="Search" title="New search" />
                </a>
            </div>
            <div id="addActor">
                <a href="addActor.php">
                    <img class="imgButton" src="images/add-actor.gif" 
                        alt="Add Actor" title="Add a new actor" />
                </a>
            </div>
            <div id="addDir">
                <a href="addDirector.php">
                    <img class="imgButton" src="images/add-director.gif" 
                        alt="Add Director" title="Add a new director" />
                </a>
            </div>
            <div id="addMovie">
                <a href="addMovie.php">
                    <img class="imgButton" src="images/add-movie.gif" 
                        alt="Add Movie" title="Add a new movie" />
                </a>
            </div>
            <div id="reviewMovie">
                <a href="addReview.php">
                    <img class="imgButton" src="images/review-movie.gif" 
                        alt="Review Movie" title="Write a movie review" />
                </a>
            </div>
        </div>

        <div class="flexbox-container" id="content">
            <div id="results">
                <h1>Search Results</h1>
                <?php

                    /* Process search input */
                    if (isset($_GET["searchQ"]))
                        $q = $_GET["searchQ"];
                    else
                        $q = "";
                    $results = "";

                    if ($q != "") {

                        // Attempt to create connection
                        $db_connection = 
                            mysqli_connect("localhost", "cs143", "", "CS143");
                        if (!$db_connection) {
                            echo "Connection error";
                            exit;
                        }
        
                        $keywords = $q;
                        $keywords = str_replace(" ", "%", $keywords);
                        $keywords .= "%";
                        $keywords = "%" . $keywords;
                        $search = 
                            "(SELECT CONCAT_WS(\" \", first, last) as Res,
                            sex as Which
                            FROM Actor
                            HAVING Res LIKE LOWER('" . $keywords . "'))
                            UNION
                            (SELECT title, company
                            FROM Movie
                            WHERE title LIKE LOWER('" . $keywords . "'))
                            ORDER BY Res;";

                        $data = mysqli_query($db_connection, $search);
                        if (!$data) {
                            echo "No results found!";
                            exit;
                        }

                        $nRows = mysqli_num_rows($data);
                        if (!$nRows) {
                            echo "No results found!";
                        }
                        else {
                            if ($nRows == 1)
                                echo "$nRows result found.<br />";
                            else
                                echo "$nRows results found.<br />";

                            $nomore = false;
                            $pageNo = 1;
                            while (1) {
                                if ($nomore)
                                    break;
                                $row = 
                                    mysqli_fetch_array($data, MYSQLI_ASSOC);
                                if (!$row)
                                    break;

                                if ($pageNo == 1) {
                                    echo "<div id=\"p" . $pageNo . 
                                        "\" class=\"page\"><ul>";
                                }
                                else {
                                    echo "<div id=\"p" . $pageNo . 
                                        "\" class=\"page\" hidden><ul>";
                                }
                                $pageNo++;
                                $i = 0;
                                for ( ; $i < 5; $i++) {
                                    if ($i != 0) {
                                        $row = 
                                            mysqli_fetch_array($data, 
                                                MYSQLI_ASSOC);
                                    }
                                    if (!$row) {
                                        $normore = true;
                                        break;
                                    }

                                    $which = "";
                                    $type = "";
                                    if ($row["Which"] != "Female" && 
                                        $row["Which"] != "Male" &&
                                        $row["Which"] != "") {

                                        $type = "Movie";
                                        $which = "<i>Movie</i>";
                                    }
                                    elseif ($row["Which"] == "Female") {
                                        $type = "Actress";
                                        $which = "<i>Actress</i>";
                                    }
                                    elseif ($row["Which"] == "Male") {
                                        $type = "Actor";
                                        $which = "<i>Actor</i>";
                                    }
                                    else {
                                        $type = "Unknown";
                                        $which = "<i>Unknown</i>";
                                    }

                                    $click = 
                                        "<span onclick=\"showInfo('" . 
                                        $row["Res"] . "', '" . $type . "');\">" .
                                        $row["Res"] . "</span>";

                                    echo "<li>" . $click . "<br />" . 
                                        $which . "</li>";
                                }
                                echo "</ul></div>";
                            }
                            echo "<br />";
                            echo "<input type=\"button\" class=\"navBut\" " .
                                "id=\"back\" " . 
                                "value=\"Back\" />";
                            echo "<input type=\"button\" class=\"navBut\" " .
                                "id=\"next\" " .
                                "value=\"Next\" />";
                            $nPages = ceil($nRows / 5);
                            echo "&nbsp;&nbsp;<span id=\"curPage\">1</span> of"
                                . " $nPages";
                        }

                        // Close connection
                        mysqli_close($db_connection);
                    }
                    else
                        echo "<i>No keywords were entered.</i>";

                ?>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div id="selectedTable">
                
            </div>
        </div>

    </body>

</html>
