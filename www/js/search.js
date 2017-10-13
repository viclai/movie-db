$(function() {

    $('#back').click(function() {

        var pageNo = $('.page:visible').attr('id');
        pageNo = pageNo.substring(1);
        var prevPage = parseInt(pageNo) - 1;
        if (document.getElementById("p" + prevPage)) {

            $("#p" + pageNo).hide();
            $("#p" + prevPage).show();
            document.getElementById("curPage").innerHTML = prevPage;
        }
    });

    $('#next').click(function() {

        var pageNo = $('.page:visible').attr('id');
        pageNo = pageNo.substring(1);
        var nextPage = parseInt(pageNo) + 1;
        if (document.getElementById("p" + nextPage)) {

            $("#p" + pageNo).hide();
            $("#p" + nextPage).show();
            document.getElementById("curPage").innerHTML = nextPage;
        }
    });
});
