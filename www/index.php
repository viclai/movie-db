<!DOCTYPE html>
<html>
    <head>
        <title>MovieDB | Home</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="css/main.css" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/xmlRequest.js"></script>
    </head>

    <body>
        
        <div class="flexbox-container" id="menu">
            <div id="addActor">
                <a href="addActor.php">
                    <img class="imgButton" src="images/add-actor.gif" 
                        alt="Add Actor" 
                        title="Add a new actor" />
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

        <div id="contentContain">
            <a href="index.php">
                <img id="titleImg" src="images/title.gif" alt="MovieDB"
                    title="Welcome to MovieDB!" />
            </a>
            <form id="searchForm" method="get" action="search.php">
                <input type="text" list="sug" id="searchIn" autocomplete="off"
                    placeholder="Search for movies, actors, and actresses" 
                    name="searchQ" autofocus />
                <input type="submit" value="DB Search" id="searchButton" />
                <!-- Datalist supported on IE 10.0+, Firefox 4.0+, 
                    Chrome 20.0+, Opera 9.0+, and Edge 12.0+ -->
                <datalist id="sug"></datalist>
            </form>
        </div>

    </body>
</html>
