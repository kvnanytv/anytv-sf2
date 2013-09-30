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

