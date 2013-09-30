function offerLink(url){
    $('#offer_progress-bar').show();
    $('#gl-tbl').hide();
    $.get(url)
    .done(function( data ) { $('#gameslist-block').html(data); });
}