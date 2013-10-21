
	function fixDiv() {

  var $cache = $('#getFixed'); 
  if ($(window).scrollTop() > 300)
    $cache.css({'position': 'fixed', 'top': '0', 'padding-right': '150px'}); 
  else
  	$cache.css({'position': 'relative', 'padding-right': '0'});

    
}



$(window).scroll(fixDiv);
fixDiv();