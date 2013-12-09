function affiliateLink(url, status){
    $('#'+status+'-affiliate_progress-bar').show();
    $.get(url)
    .done(function( data ) { $('#country-'+status+'-affiliates-block').html(data); });
}

function referrerLink(url){
    $('#affiliate-referrer_progress-bar').show();
    $.get(url)
    .done(function( data ) { $('#affiliate-referrals-block').html(data); });
}

