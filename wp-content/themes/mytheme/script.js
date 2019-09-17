$ = jQuery;
var mafs = $('#filter-search');
var mafsForm = mafs.find('form');

mafsForm.submit(function(e){
    e.preventDefault();
    if(mafsForm.find('#search').val().length !== 0) {
        var search = mafsForm.find('#search').val();
    }
    if(mafsForm.find('#year').val().length !== 0) {
        var year = mafsForm.find('#year').val();
    }
    if(mafsForm.find('#month').val().length !== 0) {
        var month = mafsForm.find('#month').val();
    }

    var data = {
        action : 'filter_search',
        search : search,
        year : year,
        month : month,

    };
    $.ajax({
        url : ajax_url,
        data : data,
        success : function(response) {
            mafs.find("#fitler_search_results").empty();
            if(response) {
                for(var i = 0 ;  i < response.length ; i++) {
                    var html  = "<div id='post-" + response[i].id + "'>";

                    html += "  <h1><a href='" + response[i].permalink + "'>" + response[i].title + "</a></h1>";
                    html += "  <div>" + response[i].thumbnail + "</div>";
                    html += "<em>" + response[i].date + "</em>";
                    html += "<em>" + response[i].author + "</em>";
                    html += "<div>" + response[i].category + "</div>";
                    html += "<div>" + response[i].excerpt + "</div>";
                    html += "</div>";
                    mafs.find("#fitler_search_results").append(html);
                }
            } else {
                var html  = "<div class='no-result'>No matching result found. Try a different filter or search keyword</div>";
                mafs.find("#fitler_search_results").append(html);
            }
        }
    });

});