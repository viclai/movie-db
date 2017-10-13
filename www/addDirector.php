<!DOCTYPE html>
<html>
    <head>
        <title>MovieDB | New Director</title>
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
                <div id="formSwitchSect">
                    <h1>New Director</h1>
                    <span class="ast">*</span> <i>= Required Field</i>
                    <br /><br />
                    <input type="button" class="switch" 
                        onclick="switch2MovieDirector();" 
                        value="Add director for a movie" />
                    <br />
                    <table>
                        <tr>
                            <td>First name:</td>
                            <td>
                                <input type="text" id="firstname" 
                                    autocomplete="off" maxlength="20" />&nbsp;
                                <span class="ast">*</span>
                                <span id="errfirst"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Last name:</td>
                            <td>
                                <input type="text" id="lastname" 
                                    autocomplete="off" maxlength="20" />&nbsp;
                                <span class="ast">*</span>
                                <span id="errlast"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Sex:</td>
                            <td>
                                <input type="radio" id="sexM" value="male">Male
                                <input type="radio" id="sexF" value="female">
                                Female
                            </td>
                        </tr>
                        <tr>
                            <td>Date of birth:</td>
                            <td>
                                <input type="date" id="birth" 
                                    autocomplete="off" />
                                <span class="nowrap">
                                    <i>Format: yyyy-mm-dd</i>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Date of death 
                                <span class="nowrap">(if applicable)</span>:
                            </td>
                            <td>
                                <input type="date" id="death" 
                                    autocomplete="off" />
                                <span class="nowrap">
                                    <i>Format: yyyy-mm-dd</i>
                                </span>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <div class="center">
                        <input type="submit" value="Add"  class="newAdd"
                            onclick="addRow('Director');" />
                    </div>
                </div>
                <div id="otherFormSect" hidden>
                    <h1>New Director in a Movie</h1>
                    <span class="ast">*</span> <i>= Required Field</i>
                    <br /><br />
                    <input type="button" class="switch" 
                        onclick="switch2Director();" 
                        value="Add new director" />
                    <br />
                    <table>
                        <tr>
                            <td>Director:</td>
                            <td>
                                <input type="text" id="director" 
                                    list="directorSug" 
                                    autocomplete="off" />&nbsp;
                                <span class="ast">*</span>
                                <span id="errdir"></span>
                                <datalist id="directorSug"></datalist>
                            </td>
                        </tr>
                        <tr>
                            <td>Movie:</td>
                            <td>
                                <input type="text" id="movie" list="movieSug"
                                    autocomplete="off" />&nbsp;
                                <span class="ast">*</span>
                                <span id="errmov"></span>
                                <datalist id="movieSug"></datalist>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <div class="center">
                        <input type="submit" value="Add" class="newAdd"
                            onclick="addRow('MovieDirector');" />
                    </div>
                </div>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div id="submissionStat">
                
            </div>
        </div>

    </body>

</html>

