<?php 
$add4_conc_sql=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();

}
echo"Rating and Review of Concerts</br>";

 echo"<table>";
$adg=$add4_conc_sql->prepare("select distinct(concert_name) from upcoming_concerts where concert_name not in 
(select concertname from review_data where r_username=?)");
  $adg->bind_param("s",$uname);
  $adg->execute();
  $adg->bind_result($conname);
  echo"<tr><td>Concert Name:</td><td><select id='conname'>";
  while($adg->fetch())
  {
     echo " <option >$conname</option>";
  }
  echo"</select></td></tr>";
  echo "<tr><td> Rating:</td><td><input type='text' id='ratng' /></td></tr>";
  echo "<tr><td> Review:</td>";
  echo"<td><select id='rev' >";
  
    echo"<option>1</option>";echo"<option>2</option>";echo"<option>3</option>";echo"<option>4</option>";echo"<option>5</option>";


  echo"</select></td></tr>";
  echo"<tr><td>Attended or not</td><td><select id=att><option>Attended</option><option>Plan to</option><option>Not attended</option>
       </select></td></tr></table>";
  echo"<input type='button' value='Submit Review' id='bt_rv'/>";

  ?>
  <html>
  <head>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
$(document).ready(function(){
  $("#bt_rv").click(function(){
  var uname=$("input#un").val();
  var cname= $("#conname option:selected").text();
  var attornot= $("#att option:selected").text();
  var rating=$("input#ratng").val();  
  var review=$("input#rev").val();
  alert(uname+cname+attornot+rating+review);
});
  });
</script>

