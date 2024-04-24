function getSuggestions(searchbar) {
    if (searchbar.value.length >= 3) {
        $.ajax({
            url: "index.php?cl=fcGetSuggestions",
            type: "POST",
            data: {
                searchParam: encodeURIComponent(searchbar.value),
            },
            success: function(suggestions){
                console.log(suggestions)
                suggestions = JSON.parse(suggestions);

                let suggestionBox = $('#suggestionBox');
                suggestionBox.empty();

                for (let key in suggestions) {
                    suggestionBox.append("<li><a href='#'>"+ suggestions[key].replace(searchbar.value, "<b>"+searchbar.value+"</b>") +"</a></li>");
                }

                suggestionBox.show();
            }
        });
    }
}