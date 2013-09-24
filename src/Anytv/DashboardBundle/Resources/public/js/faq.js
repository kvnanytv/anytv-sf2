function faqCategory(url){
    $.get(url)
    .done(function( data ) { $('#faqlist-block').html(data); });
}

function showFaq(question){
    //$('.answer :visible').hide();
    $(question).parent().next().toggle();
}