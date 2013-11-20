function changeConversionStatus(url, id){
    $('#conversion_'+id).html('');
    $.get(url)
    .done(function( data ) { $('#conversion_'+id).html(data); });
}


    
   

