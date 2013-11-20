function showTab(url){
    $('#profile-tabs-progress-bar').show();
    $('#profile-tab-results').hide();
    $.get(url)
    .done(function( data ) { $('#profile_tab_content').html(data); });
}

function submitForm(form, url){
    $('#profile-tabs-progress-bar').show();
    $('#profile-tab-results').hide();
    $.ajax({
           type: "POST",
           url: url,
           data: $(form).serialize(), 
           success: function(data)
           {
               $('#profile_tab_content').html(data);
           }
         });

    return false; 
}

function showOffer(url){
    $('.modal-content').addClass('preloader');
    $('#profile_offer_content').html('');
    $.get(url)
    .done(function( data ) { $('#profile_offer_content').html(data); $('.modal-content').removeClass('preloader');; });
}

$(document).ready(function(){
      $("a#cpy-ref-btn").zclip({
        path:'/bundles/anytvmain/js/zclip/ZeroClipboard.swf',
        copy:$('#ref-lnk').val(),
        beforeCopy:function(){
          $('#ref-lnk').css('background','#2dc575');
          $('#ref-lnk').css('color','white');
          // $(this).css('color','orange');
        },
        afterCopy:function(){
          $('#ref-link').css('background','green');
          // $(this).css('color','purple');
          $(this).innerHTML("COPIED");
          $(this).next('.check').show();
        }
      });
    });
    
    
   

