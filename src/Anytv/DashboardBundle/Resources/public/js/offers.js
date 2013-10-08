function offerLink(url){
    $('#offer_progress-bar').show();
    //$('#gl-tbl').hide();
    $.get(url)
    .done(function( data ) { $('#gameslist-block').html(data); });
}

function playNowLink(url, id){
    $('#play_now_link_'+id).html('');
    $.get(url)
      .done(function( data ) 
      { 
        $('#play_now_link_'+id).html(data); 
      }
    );
}

function showOffer(url){
    $('.modal-content').addClass('preloader');
    $('#profile_offer_content').html('');
    $.get(url)
    .done(function( data ) { $('#profile_offer_content').html(data); $('.modal-content').removeClass('preloader');; });
}