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

function fixDiv() {

  var $cache = $('#getFixed'); 
  if ($(window).scrollTop() > 350)
    $cache.css({'position': 'fixed', 'top': '0', 'padding-right': '150px', 'padding-top': '20px'}); 
  else
  	$cache.css({'position': 'relative', 'padding-top': '0'});

    
}

$(window).scroll(fixDiv);
fixDiv();