$(function() {
    var entry_template = Handlebars.compile($("#entry-template").html());

    var feed = $("#feed");

    $.ajax({
        method: 'GET',
        url: "/api/content.php",
        dataType: "json"
    }).done(function(data) {
        if (data && data.articles) {
            $.each(data.articles, function(i, article) {
                feed.append(entry_template(article));
            });
        }
    });
});