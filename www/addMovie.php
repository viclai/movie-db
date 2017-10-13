<!DOCTYPE html>
<html>
    <head>
        <title>MovieDB | New Movie</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <link rel="stylesheet" href="css/new-entry.css" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/xmlRequest.js"></script>
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
                        autocomplete="off" name="searchQ" />
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
            <div id="formInfo">
                <h1>New Movie</h1>
                <span class="ast">*</span> <i>= Required Field</i>
                <br />
                <table>
                    <tr>
                        <td>Title:</td>
                        <td>
                            <input type="text" id="title" autocomplete="off" 
                                maxlength="100"/>&nbsp;
                            <span class="ast">*</span>
                            <span id="errmov"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company:</td>
                        <td>
                            <input type="text" id="company" autocomplete="off"
                                maxlength="50" />
                        </td>
                    </tr>
                    <tr>
                        <td>Year:</td>
                        <td>
                            <input type="text" id="year" autocomplete="off" />
                        </td>
                    </tr>
                    <tr>
                        <td>MPAA Rating:</td>
                        <td>
                            <select id="rating">
                                <option value="none"></option>
                                <?php

                                    // Attempt to create connection
                                    $db_connection = 
                                    mysqli_connect("localhost", "cs143", 
                                        "", "CS143");
                                    if (!$db_connection)
                                        exit;

                                    $query = "SELECT DISTINCT rating
                                                FROM Movie
                                                ORDER BY rating;";
                                    $data = mysqli_query($db_connection, 
                                        $query);
                                    if (!$data) {
                                        mysqli_close($db_connection);
                                        exit;
                                    }

                                    while ($row = mysqli_fetch_row($data)) {
                                        echo "<option value=\"" . $row[0] . 
                                            "\">" . $row[0] . "</option>";
                                    }

                                    // Close connection
                                    mysqli_close($db_connection);

                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
                Genre(s): (select all that apply)
                <?php

                    // Attempt to create connection
                    $db_connection = 
                        mysqli_connect("localhost", "cs143", "", "CS143");
                    if (!$db_connection)
                        exit;
            
                    $query = "SELECT DISTINCT genre
                                FROM MovieGenre
                                ORDER BY genre;";
                    $data = mysqli_query($db_connection, $query);
                    if (!$data) {
                        mysqli_close($db_connection);
                        exit;
                    }

                    $newRow = 0;
                    echo "<table id=\"genreTab\">";
                    while ($row = mysqli_fetch_row($data)) {
                        if ($newRow == 0)
                            echo "<tr>";
                        echo "<td><span class=\"nowrap\">" . 
                            "<input type=\"checkbox\" class=\"genre\" " . 
                            "value=\"" . $row[0] . "\">" . $row[0] . 
                            "</span></td>";
                        $newRow++;
                        if ($newRow == 4) {
                            $newRow = 0;
                            echo "</tr>";
                        }
                    }
                    if ($newRow != 0)
                        echo "</tr>";
                    echo "</table>";

                    // Close connection
                    mysqli_close($db_connection);

                ?>
                <br /><br />
                <div class="center">
                    <input type="submit" value="Add" class="newAdd"
                        onclick="addRow('Movie');" />
                </div>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div id="submissionStat">
                
            </div>
        </div>

    </body>

</html>

