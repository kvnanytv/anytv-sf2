</div>
<!-- /.page-wrap -->
<footer>
  <div class="container">
    <div class="cpyrght-txt">
      Copyright 2013 any.TV Limited | All Rights Reserved    
    </div>
    <div class="sm-icons">
    	<ul>
        <li><a href=""><i class="icon-youtube icon-large" title="YouTube Channel"></i></a></li> 
        <li><a href=""><i class="icon-facebook icon-large" title="Facebook"></i></a></li>
        <li><a href=""><i class="icon-twitter icon-large" title="Twitter"></i></a></li>
     </ul>
   </div>
 </div>
</footer>
<!-- /footer -->


</body>

<script src="assets/js/jquery.js"></script>  
<script src="js/zclip/jquery.zclip.js"></script>   
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/tinynav/tinynav.min.js"></script>
<script src="js/zclip/jquery.zclip.js"></script>

<script>
  $(function () {
    $("#nav").tinyNav();
  });
</script>
<script>
  $('a#cpy-ref-btn').zclip({
    path:'js/ZeroClipboard.swf',
    copy:function(){return $('input#ref-lnk').val();}
  });



  $(document).ready(function(){
    $("a#cpy-ref-btn").zclip({
      path:'js/zclip/ZeroClipboard.swf',
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
</script>

</html>