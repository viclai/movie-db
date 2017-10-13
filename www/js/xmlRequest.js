$(function() {

    $("#searchIn").keyup(function(e) {

        var key = e.which;
        if (key != 37 && key != 38 && key != 39 && key != 40 && 
            key != 255 && key != 13 && key != 0) {
            var input = $("#searchIn").val();
            loadSuggestions(input);
        }
    });

    $("#actor").keyup(function(e) {

        var key = e.which;
        if (key != 37 && key != 38 && key != 39 && key != 40 && 
            key != 255 && key != 13 && key != 0) {
            var input = $("#actor").val();
            loadActors(input);
        }
    });

    $("#movie").keyup(function(e) {

        var key = e.which;
        if (key != 37 && key != 38 && key != 39 && key != 40 && 
            key != 255 && key != 13 && key != 0) {
            var input = $("#movie").val();
            loadMovies(input);
        }
    });

    $("#director").keyup(function(e) {

        var key = e.which;
        if (key != 37 && key != 38 && key != 39 && key != 40 && 
            key != 255 && key != 13 && key != 0) {
            var input = $("#director").val();
            loadDirectors(input);
        }
    });
});

function loadDirectors(str) {

    var xmlhttp;
    if (window.XMLHttpRequest) // IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    else // IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

    xmlhttp.onreadystatechange = function() {

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            var rtn = xmlhttp.responseText;
            if (rtn !== "-1")
                document.getElementById("directorSug").innerHTML = rtn;
        }
    }

    xmlhttp.open("GET", "getDirectors.php?q=" + str, true);
    xmlhttp.send();
}

function loadMovies(str) {

    var xmlhttp;
    if (window.XMLHttpRequest) // IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    else // IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

    xmlhttp.onreadystatechange = function() {

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            var rtn = xmlhttp.responseText;
            if (rtn !== "-1")
                document.getElementById("movieSug").innerHTML = rtn;
        }
    }

    xmlhttp.open("GET", "getMovies.php?q=" + str, true);
    xmlhttp.send();
}

function loadActors(str) {

    var xmlhttp;
    if (window.XMLHttpRequest) // IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    else // IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

    xmlhttp.onreadystatechange = function() {

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            var rtn = xmlhttp.responseText;
            if (rtn !== "-1")
                document.getElementById("actorSug").innerHTML = rtn;
        }
    }

    xmlhttp.open("GET", "getActors.php?q=" + str, true);
    xmlhttp.send();
}

function loadSuggestions(str) {

    var xmlhttp;
    if (window.XMLHttpRequest) // IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    else // IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

    xmlhttp.onreadystatechange = function() {

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            var rtn = xmlhttp.responseText;
            if (rtn !== "-1")
                document.getElementById("sug").innerHTML = rtn;
        }
    }

    xmlhttp.open("GET", "getSuggestions.php?q=" + str, true);
    xmlhttp.send();
}

function showInfo(name, type) {

    var safeName = name.replace(/&/g, "%26");

    var xmlhttp;
    if (window.XMLHttpRequest) // IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    else // IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

    xmlhttp.onreadystatechange = function() {

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            var rtn = xmlhttp.responseText;
            var key = rtn.substring(4, 9);
            document.getElementById("selectedTable").innerHTML = rtn;
            if (key !== "ABOUT") {
                $("#selectedTable").css("border", "solid 1px red");
                $("#selectedTable").css("border-radius", "10px");
            }
            else {
                $("#selectedTable").css("border", "solid 1px blue");
                $("#selectedTable").css("border-radius", "10px");
            }
        }
    }

    document.getElementById("selectedTable").innerHTML = 
        "<img src=\"images/loading-x.gif\" alt=\"Loading...\" " + 
            "id=\"loadingImg\" />";

    if (type == "Movie")
        xmlhttp.open("GET", "getMovieInfo.php?movie=" + safeName, true);
    else
        xmlhttp.open("GET", "getActorInfo.php?actor=" + safeName, true);
    xmlhttp.send();
}

function addRow(type) {

    var qStr;
    var xmlhttp;
    var hasError = false;
    if (type == "Actor" || type == "Director") {
        
        var first = document.getElementById("firstname").value;
        if (first == "") {

            // Handle error
            $("#firstname").css("border-color", "red");
            document.getElementById("errfirst").innerHTML = "REQUIRED";
            hasError = true;
        }
        else {

            $("#firstname").css("border-color", "inherit");
            document.getElementById("errfirst").innerHTML = "";
        }

        var last = document.getElementById("lastname").value;
        if (last == "") {

            // Handle error
            $("#lastname").css("border-color", "red");
            document.getElementById("errlast").innerHTML = "REQUIRED";
            hasError = true;
        }
        else {

            $("#lastname").css("border-color", "inherit");
            document.getElementById("errlast").innerHTML = "";
        }

        if (hasError)
            return;

        var sex = "";
        if (document.getElementById("sexM").checked)
            sex = "Male";
        if (document.getElementById("sexF").checked)
            sex = "Female";
        var birth = document.getElementById("birth").value;
        var death = document.getElementById("death").value;

        qStr = "first=" + first + "&last=" + last + "&sex=" + sex +
            "&birth=" + birth + "&death=" + death;

        if (window.XMLHttpRequest) // IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        else // IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                var rtn = xmlhttp.responseText;
                document.getElementById("submissionStat").innerHTML = rtn;
                var key = rtn.substring(18, 26);
                if (key == "Success!") {

                    $("#submissionStat").css("border", "solid 1px blue");
                    $("#submissionStat").css("border-radius", "10px");
                    // Clear input
                    document.getElementById("firstname").value = "";
                    document.getElementById("lastname").value = "";
                    document.getElementById("sexM").checked = false;
                    document.getElementById("sexF").checked = false;
                    document.getElementById("birth").value = "";
                    document.getElementById("death").value = "";
                }
                else {

                    $("#submissionStat").css("border", "solid 1px red");
                    $("#submissionStat").css("border-radius", "10px");
                }
             }
        }

        document.getElementById("submissionStat").innerHTML = 
            "<img src=\"images/loading-x.gif\" alt=\"Loading...\" " + 
                "id=\"loadingImg\" />";

        if (type == "Actor")
            xmlhttp.open("GET", "insertActor.php?" + qStr, true);
        else // type == "Director"
            xmlhttp.open("GET", "insertDirector.php?" + qStr, true);
    }
    else if (type == "Movie") {

        var title = document.getElementById("title").value;
        if (title == "") {

            // Handle error
            $("#title").css("border-color", "red");
            document.getElementById("errmov").innerHTML = "REQUIRED";
            hasError = true;
        }
        else {

            $("#title").css("border-color", "inherit");
            document.getElementById("errmov").innerHTML = "";
        }

        if (hasError)
            return;

        var company = document.getElementById("company").value;
        var year = document.getElementById("year").value;
        var rating = $("#rating option:selected").text();
        var genres = "";
        var checkedElements = document.getElementsByClassName("genre");
        for (var i = 0; checkedElements[i]; i++) {
            if (checkedElements[i].checked)
                genres += checkedElements[i].value + "|";
        }

        qStr = "title=" + title + "&company=" + company + "&year=" + year +
            "&rating=" + rating + "&genres=" + genres;

        if (window.XMLHttpRequest) // IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        else // IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                var rtn = xmlhttp.responseText;
                document.getElementById("submissionStat").innerHTML = rtn;
                var key = rtn.substring(18, 26);
                if (key == "Success!") {

                    $("#submissionStat").css("border", "solid 1px blue");
                    $("#submissionStat").css("border-radius", "10px");
                    // Clear all input in case user wants to add another
                    document.getElementById("title").value = "";
                    document.getElementById("company").value = "";
                    document.getElementById("year").value = "";
                    document.getElementById("rating").selectedIndex = 0;
                    for (var i = 0; checkedElements[i]; i++)
                        checkedElements[i].checked = false;
                }
                else {

                    $("#submissionStat").css("border", "solid 1px red");
                    $("#submissionStat").css("border-radius", "10px");
                }
             }
        }

        document.getElementById("submissionStat").innerHTML = 
            "<img src=\"images/loading-x.gif\" alt=\"Loading...\" " + 
                "id=\"loadingImg\" />";

        xmlhttp.open("GET", "insertMovie.php?" + qStr, true);
    }
    else if (type == "MovieActor") {

        var actor = document.getElementById("actor").value;
        if (actor == "") {

            // Handle error
            $("#actor").css("border-color", "red");
            document.getElementById("erract").innerHTML = "REQUIRED";
            hasError = true;
        }
        else {

            $("#actor").css("border-color", "inherit");
            document.getElementById("erract").innerHTML = "";
        }

        var movie = document.getElementById("movie").value;
        if (movie == "") {

            // Handle error
            $("#movie").css("border-color", "red");
            document.getElementById("errmov").innerHTML = "REQUIRED";
            hasError = true;
        }
        else {

            $("#movie").css("border-color", "inherit");
            document.getElementById("errmov").innerHTML = "";
        }

        if (hasError)
            return;

        var role = document.getElementById("role").value;

        qStr = "actor=" + actor + "&movie=" + movie + "&role=" + role;

        if (window.XMLHttpRequest) // IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        else // IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                var rtn = xmlhttp.responseText;
                document.getElementById("submissionStat").innerHTML = rtn;
                var key = rtn.substring(18, 26);
                if (key == "Success!") {

                    $("#submissionStat").css("border", "solid 1px blue");
                    $("#submissionStat").css("border-radius", "10px");
                    // Clear all input
                    document.getElementById("actor").value = "";
                    document.getElementById("movie").value = "";
                    document.getElementById("role").value = "";
                }
                else {

                    $("#submissionStat").css("border", "solid 1px red");
                    $("#submissionStat").css("border-radius", "10px");
                }
             }
        }

        document.getElementById("submissionStat").innerHTML = 
            "<img src=\"images/loading-x.gif\" alt=\"Loading...\" " + 
                "id=\"loadingImg\" />";

        xmlhttp.open("GET", "insertMovieActor.php?" + qStr, true);
    }
    else if (type == "MovieDirector") {

        var director = document.getElementById("director").value;
        if (director == "") {

            // Handle error
            $("#director").css("border-color", "red");
            document.getElementById("errdir").innerHTML = "REQUIRED";
            hasError = true;
        }
        else {

            $("#director").css("border-color", "inherit");
            document.getElementById("errdir").innerHTML = "";
        }

        var movie = document.getElementById("movie").value;
        if (movie == "") {

            // Handle error
            $("#movie").css("border-color", "red");
            document.getElementById("errmov").innerHTML = "REQUIRED";
            hasError = true;
        }
        else {

            $("#movie").css("border-color", "inherit");
            document.getElementById("errmov").innerHTML = "";
        }

        if (hasError)
            return;

        qStr = "director=" + director + "&movie=" + movie;

        if (window.XMLHttpRequest) // IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        else // IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                var rtn = xmlhttp.responseText;
                document.getElementById("submissionStat").innerHTML = rtn;
                var key = rtn.substring(18, 26);
                if (key == "Success!") {

                    $("#submissionStat").css("border", "solid 1px blue");
                    $("#submissionStat").css("border-radius", "10px");
                    // Clear all input
                    document.getElementById("director").value = "";
                    document.getElementById("movie").value = "";
                }
                else {

                    $("#submissionStat").css("border", "solid 1px red");
                    $("#submissionStat").css("border-radius", "10px");
                }
             }
        }

        document.getElementById("submissionStat").innerHTML = 
            "<img src=\"images/loading-x.gif\" alt=\"Loading...\" " + 
                "id=\"loadingImg\" />";

        xmlhttp.open("GET", "insertMovieDirector.php?" + qStr, true);
    }
    else { // type == "Review"

        var movie = document.getElementById("movie").value;
        if (movie == "") {

            // Handle error
            $("#movie").css("border-color", "red");
            document.getElementById("errmov").innerHTML = "REQUIRED";
            hasError = true;
        }
        else {

            $("#movie").css("border-color", "inherit");
            document.getElementById("errmov").innerHTML = "";
        }

        var name = document.getElementById("reviewer").value;

        var rating = $("#rating option:selected").val();
        if (rating == "") {

            // Handle error
            $("#rating").css("border-color", "red");
            document.getElementById("errrate").innerHTML = "REQUIRED";
            hasError = true;
        }
        else {

            $("#rating").css("border-color", "inherit");
            document.getElementById("errrate").innerHTML = "";
        }

        if (hasError)
            return;

        var comments = document.getElementById("comments").value;

        qStr = "title=" + movie + "&name=" + name + "&rating=" + rating +
            "&comments=" + comments;

        if (window.XMLHttpRequest) // IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        else // IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                var rtn = xmlhttp.responseText;
                document.getElementById("submissionStat").innerHTML = rtn;
                var key = rtn.substring(18, 26);
                if (key != "Success!") {

                    $("#submissionStat").css("border", "solid 1px red");
                    $("#submissionStat").css("border-radius", "10px");
                }
                else {

                    $("#submissionStat").css("border", "solid 1px blue");
                    $("#submissionStat").css("border-radius", "10px");
                    // Clear input
                    document.getElementById("movie").value = "";
                    document.getElementById("reviewer").value = "Anonymous";
                    document.getElementById("rating").selectedIndex = 0;
                    document.getElementById("comments").value = "";
                }
            }
        }

        document.getElementById("submissionStat").innerHTML = 
            "<img src=\"images/loading-x.gif\" alt=\"Loading...\" " + 
                "id=\"loadingImg\" />";

        xmlhttp.open("GET", "insertReview.php?" + qStr, true);
    }
    xmlhttp.send();
}

function switch2MovieActor() {
    document.getElementById("firstname").value = "";
    document.getElementById("lastname").value = "";
    document.getElementById("sexM").checked = false;
    document.getElementById("sexF").checked = false;
    document.getElementById("birth").value = "";
    document.getElementById("death").value = "";
    $("#formSwitchSect").hide();

    $("#otherFormSect").show();
}

function switch2Actor() {
    document.getElementById("actor").value = "";
    document.getElementById("movie").value = "";
    document.getElementById("role").value = "";
    $("#otherFormSect").hide();

    $("#formSwitchSect").show();
}

function switch2MovieDirector() {
    switch2MovieActor();
}

function switch2Director() {
    document.getElementById("director").value = "";
    document.getElementById("movie").value = "";
    $("#otherFormSect").hide();

    $("#formSwitchSect").show();
}
