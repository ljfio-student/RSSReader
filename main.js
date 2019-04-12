$(function() {
    var entry_template = Handlebars.compile($("#entry-template").html());

    var feed = $("#feed");

    function refresh_content() {
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

        refresh_content();
    });

    var feed_template = Handlebars.compile($("#feed-template").html());

    var feeds = $("#feeds");

    function refresh_feeds() {
        feeds.html("");

        $.ajax({
            method: "GET",
            url: "/api/feeds.php",
            dataType: "json"
        }).done(function(data) {
            if (data && data.feeds) {
                $.each(data.feeds, function(i, feed) {
                    feeds.append(feed_template(feed));
                });
            }
        });
    }

    $("#show-feeds").on("click", function(e) {
        e.preventDefault();

        refresh_feeds();

        $("#feed-modal").modal("show");
    });

    $("#new-feed-form").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "/api/feeds.php",
            contentType: "json",
            data: $("#new-feed-form").serializeArray(),
            dataType: "json"
        }).done(function(result) {
            if (result && result.success) {
                refresh_feeds();
            }
        });
    })

    refresh_content();
});