<?php
session_start();
echo"<h4 align='center'> Add Review</h4>";
$add2_sql=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();

}
$uname=$_SESSION['uname'];
echo"<input type='hidden' value=$uname id ='un'/>";

echo"<div align='right'><input type='button' name='logout' value='logout' id='bttn_logout'/></div>";
echo"<input type='button' value='Home' id='go_home'style='text-align:left'/>"."</br>";  
echo"<table>";
$adg=$add2_sql->prepare("select distinct(concert_name) from upcoming_concerts where concert_name not in 
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
  echo "<tr><td> Review:</td><td><input type='text' id='review' /></td></tr>";
  echo "<tr><td> Rating:</td>";
  echo"<td><select id='rat' >";
  
    echo"<option>1</option>";echo"<option>2</option>";echo"<option>3</option>";echo"<option>4</option>";echo"<option>5</option>";

  echo"</select></td></tr>";
  echo"<tr><td>Attended or not</td><td><select id=att><option>Attended</option><option>Plan to</option><option>Not attended</option>
       </select></td></tr></table>";
  echo"<input type='button' value='Submit Review' id='bt_rv'/>";
  echo"<hr thickness='80px'>";
  echo"Reviews given by $uname:-";
  $adg1=$add2_sql->prepare("select review,rating,concertname,review_date,attornot
   from review_data where r_username=? Order by review_date DESC");
  $adg1->bind_param("s",$uname);
  $adg1->execute();
  $adg1->bind_result($rev,$rati,$cnamet,$r_date,$attnt);
  echo"<table>";
  echo"<tr><th>Concert Name:</th><th>Review Date</th><th> Rating</th><th>Review </th><th>Status of Attendance</th></tr>";
  while($adg1->fetch())
  {
     echo "<tr><td>$cnamet</td><td>$r_date</td><td>$rati</td><td>$rev</td><td>$attnt</td></tr> ";
  }
  echo"</table>";
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
  var rating=$("#rat option:selected").text();  
  var review=$("input#review").val();
  if(review!=''){
   $.post('add_rv.php',{uname:uname,att:attornot,cname:cname,rat:rating,rv:review},function(data){
            alert(data);
            location.reload();
            });
}
else{
	alert("Enter Review");
}
});
  
$("#go_home").click(function(){
  var uname=$("input#errors").val();
  var url1 = "profile.php?uname=" + encodeURIComponent(uname);
   window.location.href = url1;

});
  $('#bttn_logout').click(function(){
   var uname=$("input#user_id").val(); 
   var ut=0;
   $.post('logout.php',{uname:uname,ut:ut},function(data){
            }); 
   var url1 = "login.php?";
   window.location.href = url1;


});
  });
</script>