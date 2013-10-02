var selected_item = null;

function faqCategory(url){
    $.get(url)
    .done(function( data ) { $('#faqlist-block').html(data); });
}

function showFaq(id){
    if(selected_item){
      $('#faq_answer_'+selected_item).hide('slow');    
    }
    selected_item = id;
    $('#faq_answer_'+id).show('slow');
}