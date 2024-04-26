let hideTimer;
let searchbar = $('#searchParam');
let suggestionBox = $('#suggestionBox');
let suggestionBoxArticles = $('#suggestionBoxArticles');
let suggestionBoxCategories = $('#suggestionBoxCategories');

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

// Show suggestions when the input is clicked and the suggestionBox has children
searchbar.on('click', function() {
    if (suggestionBoxArticles.children().length > 0 || suggestionBoxCategories.children().length > 0) {
        suggestionBox.show();
    }
});

function getSuggestions(searchbar) {
    if (searchbar.value.length >= 3) {
        $.ajax({
            url: shoproot + "index.php/?cl=fcGetSuggestions",
            type: "POST",
            data: {
                searchParam: encodeURIComponent(searchbar.value),
            },
            success: function(suggestions){
                suggestions = JSON.parse(suggestions);

                suggestionBoxArticles.empty();
                suggestionBoxCategories.empty();

                for (let key in suggestions.articles) {
                    let article = suggestions.articles[key];

                    suggestionBoxArticles.append("" +
                        "<li onclick=\"window.location.href = $(this).children('a').first().attr('href')\">" +
                            "<img src='"+ article.image +"' class='suggestion-img' height='30' alt>" +
                            "<a href='" + article.href + "'>" + highlightSearchedValue(searchbar.value, article.title) + "</a>" +
                        "</li>");
                }

                for (let key in suggestions.categories) {
                    let category = suggestions.categories[key];

                    suggestionBoxCategories.append(
                        "<li onclick=\"window.location.href = $(this).children('a').first().attr('href')\">" +
                            "<a href='" + category.href + "'>" + highlightSearchedValue(searchbar.value, category.title) + "</a>" +
                        "</li>"
                    );
                }

                if (suggestionBoxArticles.children().length === 0) {
                    suggestionBoxArticles.append('<p class="no-suggestions">Keine Artikel zu "'+ searchbar.value +'" gefunden</p>');
                }

                if (suggestionBoxArticles.children().length > 0 && suggestionBoxCategories.children("li").length > 0) {
                    suggestionBoxArticles.addClass('seperator');
                } else {
                    suggestionBoxArticles.removeClass('seperator')
                }

                suggestionBox.show();
            }
        });
    } else {
        suggestionBoxCategories.empty();
        suggestionBoxArticles.empty();
        suggestionBox.hide();
    }
}

function highlightSearchedValue(needle, haystack) {
    let regex = new RegExp(needle, 'gi');

    return haystack.replace(regex, function (match) {
        return '<b>' + match + '</b>';
    });
}