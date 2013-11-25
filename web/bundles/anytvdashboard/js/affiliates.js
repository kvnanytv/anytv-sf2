function affiliateLink(url, status){
    $('#'+status+'-affiliate_progress-bar').show();
    $.get(url)
    .done(function( data ) { $('#country-'+status+'-affiliates-block').html(data); });
}