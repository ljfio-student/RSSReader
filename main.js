$(function() {
    var entry_template = Handlebars.compile($("#entry-template").html());

    var feed = $("#feed");

    function refresh_feed() {
        feed.html("<div class=\"d-flex justify-content-center\"><div class=\"spinner-border\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></div>");

        $.ajax({
            method: "GET",
            url: "/api/rss.php",
            dataType: "json"
        }).done(function(result) {
            if (result.success) {
                $.ajax({
                    method: "GET",
                    url: "/api/content.php",
                    dataType: "json"
                }).done(function(data) {
                    if (data && data.articles) {
                        feed.html("");

                        $.each(data.articles, function(i, article) {
                            feed.append(entry_template(article));
                        });
                    }
                });
            }
        })
    }

    $("#refresh-feed").on("click", function(e) {
        e.preventDefault();

        refresh_feed();
    });

    refresh_feed();
});