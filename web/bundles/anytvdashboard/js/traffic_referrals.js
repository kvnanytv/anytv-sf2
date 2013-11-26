function trafficReferralLink(url){
    $('#traffic_referral_progress-bar').show();
    $.get(url)
    .done(function( data ) { $('#affiliate-traffic-referrals-block').html(data); });
}

function trafficReferralYoutubeVideosLink(url){
    $('#affiliate-youtube-videos_progress-bar').show();
    $.get(url)
    .done(function( data ) { $('#affiliate-youtube-videos-block').html(data); });
}