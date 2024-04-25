let hideTimer;
let searchbar = $('#searchParam');
let suggestionBox = $('#suggestionBox');

suggestionBox.parent().attr('onfocusout', 'hideSuggestions()');

// Hide suggestions with a slight delay
function hideSuggestions() {
    hideTimer = setTimeout(function() {
        suggestionBox.hide();
    }, 200);
}

// Cancel the hide timer if the input is focused again
searchbar.on('focus', function() {
    clearTimeout(hideTimer);
});

// Show suggestions when the input is clicked
searchbar.on('click', function() {
    if (suggestionBox.children().length > 0) {
        suggestionBox.show();
    }
});

function getSuggestions(searchbar) {
    if (searchbar.value.length >= 3) {
        $.ajax({
            url: "index.php/?cl=fcGetSuggestions",
            type: "POST",
            data: {
                searchParam: encodeURIComponent(searchbar.value),
            },
            success: function(suggestions){
                suggestions = JSON.parse(suggestions);

                suggestionBox.empty();

                for (let key in suggestions) {
                    let article = suggestions[key];

                    suggestionBox.append("" +
                        "<li onclick=\"window.location.href = $(this).children().first().attr('href')\">" +
                            "<img src='"+ article.image +"'>" +
                            "<a href='" + article.href + "'>" + highlightSearchedValue(searchbar.value, article.title) + "</a>" +
                        "</li>");
                }

                if (suggestionBox.children().length === 0) {
                    suggestionBox.append('<p class="no-suggestions">Keine Artikel zu "'+ searchbar.value +'" gefunden</p>');
                }

                suggestionBox.show();
            }
        });
    } else {
        suggestionBox.empty();
        suggestionBox.hide();
    }
}

function highlightSearchedValue(needle, haystack) {
    let regex = new RegExp(needle, 'gi');

    return haystack.replace(regex, function (match) {
        return '<b>' + match + '</b>';
    });
}