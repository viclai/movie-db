<!DOCTYPE html>
<html>
    <head>
        <title>MovieDB | New Review</title>
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
                <h1>New Movie Review</h1>
                <span class="ast">*</span> <i>= Required Field</i>
                <br />
                <table>
                    <tr>
                        <td>Movie Title:</td>
                        <td>
                            <input type="text" id="movie" autocomplete="off"
                                maxlength="100" list="movieSug"
                                value="<?php 
                                            if (isset($_GET["movie"]))
                                                echo $_GET["movie"];
                                        ?>" />&nbsp;
                            <span class="ast">*</span>
                            <span id="errmov"></span>
                            <datalist id="movieSug"></datalist>
                        </td>
                    </tr>
                    <tr>
                        <td>Reviewer Name:</td>
                        <td>
                            <input type="text" id="reviewer" autocomplete="off"
                                maxlength="20" value="Anonymous" />
                        </td>
                    </tr>
                    <tr>
                        <td>Rating:</td>
                        <td>
                            <select id="rating">
                                <option value=""></option>
                                <option value="5">5 - Excellent</option>
                                <option value="4">4 - Good</option>
                                <option value="3">3 - Okay</option>
                                <option value="3">2 - Not Worth</option>
                                <option value="1">1 - Hate It</option>
                            </select>&nbsp;
                            <span class="ast">*</span>
                            <span id="errrate"></span>
                        </td>
                    </tr>
                </table>
                Comments:
                <textarea placeholder="Please limit to 500 characters." 
                    id="comments" cols="60" rows="8" maxlength="500"></textarea>
                <br /><br />
                <div class="center">
                    <input type="submit" value="Submit" class="newAdd"
                        onclick="addRow('Review');" />
                </div>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div id="submissionStat">
                
            </div>
        </div>

    </body>

</html>

