function offerLink(url){
    $.get(url)
    .done(function( data ) { $('#gameslist-block').html(data); });
}