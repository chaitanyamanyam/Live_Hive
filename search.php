<?php
echo"<input type='hidden' value='svarma9' id='user_id'/>";
echo " <div align='right'> <strong>Enter Keyword</strong><input type='text' id='txt_search'/>";
echo"<input type='button' id='id_search' name='id_search' value='Search'/></div>";
?>
<html>
<head>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
$(document).ready(function(){
  //EDIT BUTTON DESCRIPTION
$("#id_search").click(function(){
	var sr_txt=$("input#txt_search").val();
	var uname=$("input#user_id").val();
	//alert(sr_txt + uname);
	 var url = "search_results.php?name=" + encodeURIComponent(uname) + "&txt=" + encodeURIComponent(sr_txt);
        window.location.href = url;

});
});
</script>
</head>
</html>