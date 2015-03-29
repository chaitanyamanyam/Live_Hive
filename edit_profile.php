<html>
<head>
 
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script >
$(document).ready(function(){
  //EDIT BUTTON DESCRIPTION
$("#edit").click(function(){

  if($(this).prop("value")=="Edit Description")
  {
  $("#edit").prop('value','Make Changes');
  $('textarea[id="Txtarea_edit"]').prop('disabled',false).focus();

 
}
else
{
  $("#edit").prop('value','Edit Description');
  $('textarea[id="Txtarea_edit"]').prop('disabled',true).focus();
  var uname=$("input#errors").val();
  var test = $("#Txtarea_edit").val();
  $.post('description_edit.php',{content:test,uname:uname},function(data){

            });
}
});
//EDIT BUTTON FULLNAME
$("#edit_fname").click(function(){

  if($(this).prop("value")=="Edit Full Name")
  {
  $("#edit_fname").prop('value','Make Changes');
  $('textarea[id="Txtarea_fname"]').prop('disabled',false).focus();

 
}
else
{
  $("#edit_fname").prop('value','Edit Full Name');
  $('textarea[id="Txtarea_fname"]').prop('disabled',true).focus();
  var uname=$("input#errors").val();
  var test = $("#Txtarea_fname").val();
  $.post('fullname_edit.php',{fname:test,uname:uname},function(data){
            window.location.reload();
            });
}
});
//EDIT CITY BUTTON
$("#edit_city").click(function(){

  if($(this).prop("value")=="Edit City")
  {
  $("#edit_city").prop('value','Make Changes');
  $('textarea[id="Txtarea_city"]').prop('disabled',false).focus();

 
}
else
{
  $("#edit_city").prop('value','Edit City');
  $('textarea[id="Txtarea_city"]').prop('disabled',true).focus();
  var uname=$("input#errors").val();
  var test= $("#Txtarea_city").val();
  $.post('city_edit.php',{city:test,uname:uname},function(data){

            });
}
});
$("#dislike").click(function(){
  var uname=$("input#errors").val();
  var cat= $("input#category").val();
  var subcat=$("input#subcategory").val();
  $.post('music_dislike.php',{cat:cat,subcat:subcat,uname:uname},function(data){
         window.location.reload();
            });

});
$("#Unfollow").click(function(){
  var uname=$("input#errors").val();
  var flw= $("input#follower_value").val();
  $.post('unfollow_user.php',{flw:flw,uname:uname},function(data){
         window.location.reload();
            });

});
$("#change_password").click(function(){
  var uname=$("input#errors").val();
  var pwd=$("input#c_password").val();
  var oldpwd= $("input#o_password").val();
  var newpwd=$("input#n_password").val();
  if(pwd==oldpwd){
     $.post('password_change.php',{pwd:newpwd,uname:uname},function(data){
         alert("Password Changed");
         window.location.reload();
            });
  }
  else{
    alert("Old Pwd not entered properly");
    window.location.reload();
  }
 

});
 $('#bttn_logout').click(function(){
   var uname=$("input#user_id").val(); 
   var ut=0;
   $.post('logout.php',{uname:uname,ut:ut},function(data){
            }); 
   var url1 = "login.php?";
   window.location.href = url1;


});

$("#ch_bbtn").click(function(){
  var un=$("input#errors").val();
  var clr=$("#set_color option:selected").text();
   $( "body").css( "background-color", clr );

    $.session.set(un, clr);
  
 

});
$("#go_home").click(function(){
  var uname=$("input#errors").val();
  var url1 = "profile.php?uname=" + encodeURIComponent(uname);
   window.location.href = url1;

});
});
</script>
  <b><h3><p style='text-align:center'>EDIT PROFILE</p></b></h3>

<?php
ini_set('display_errors','off');

echo"<div align='right'><input type='button' name='logout' value='logout' id='bttn_logout'/></div>";
 $editsql=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();

}

$uname=trim($_GET['pname']);
 
$stmt4=$editsql->prepare("SELECT fullname,cor,password,yob,emailid from register_page where username=?");
  $stmt4->bind_param("s",$uname);
  $stmt4->execute();
  $stmt4->bind_result($fname1,$city1,$password1,$dob1,$emailid1);
  while($stmt4->fetch()){
  $fname=$fname1;
  $city=$city1;
  $password=$password1;
  $dob=$dob1;
  $emailid=$emailid1;
  }
  
echo"<input type='button' value='Home' id='go_home'style='text-align:left'/>"."</br>"; 
  //FULLNAME EDITING
  echo "<b>Fullname</b>"."</br>";
  echo"<textarea disabled id='Txtarea_fname' rows='2'cols='20' style='float:left;margin: 0px;
  vertical-align:bottom;font-size:14px;'> $fname</textarea>";
  echo"<input type='button' name='bttn_fname'id ='edit_fname' value='Edit Full Name'
  style='display: block; margin-left: 0px;margin-center: 10px; height: 30px; font-size:12px;
  padding: 0px; float:left;'></input>";
  echo"</br>"."</br>"."</br>";
  ///CITY EDITING

  echo "<b>City</b>"."</br>";
  echo"<textarea disabled id='Txtarea_city' rows='1'cols='15' style='float:left;margin: 0px;
  vertical-align:bottom;font-size:14px;'> $city</textarea>";
  echo"<input type='button' name='bttn_city'id ='edit_city' value='Edit City'
  style='display: block; margin-left: 0px;margin-center: 10px; height: 30px; font-size:12px;
  padding: 0px; float:left;'></input>";
  echo"</br>"."</br>"."</br>";
 $stmt=$editsql->prepare("SELECT description from user_profile where username=?");
  $stmt->bind_param("s",$uname);
  $stmt->execute();
  $stmt->bind_result($returned);
  while($stmt->fetch())
  {
   $text_got=$returned;
}
//DESCRIPTION 
echo "<input type='hidden' value='$uname' id='errors' />";
echo "<input type='hidden' value='$uname id='errors1' />";
echo"</br>"."<b>Description</b>"."</br>";
echo "<textarea disabled id='Txtarea_edit'rows='4' cols='50'style='height:80px;
float:left;margin: 0px;vertical-align:bottom;font-size:14px;' >$text_got</textarea>";
echo'&nbsp;&nbsp;';
echo"<input type ='button'  name='Bttn' value='Edit Description'
style='display: block; margin-left: 0px;margin-center: 10px; height: 30px; font-size:12px;
padding: 0px; float:left;' id='edit' ></input>";
echo'&nbsp;&nbsp;';
echo'&nbsp;&nbsp;';
echo"</br>";
echo"</br>";
echo"</br>";
echo"</br>";
echo"</br>"."</br>";
//PASSWORD CHANGING
echo"<b>CHANGE PASSWORD</b>"."</br>";
echo"<input type='hidden' value='$password' id='c_password'/>";
echo"Enter Old Password   "."<input type='password' value='$oldpwd' name='old_password'id ='o_password'/>";
echo"Enter New  Password  "."<input type='password' value='$newpwd' name='new_password'id ='n_password'/>";
echo"     <input type='button' value='Change Password' id='change_password'/>"."</br>";
 //MUSIC DISLIKES
$stmt1=$editsql->prepare("SELECT category,subcategory , fullname from user_like_music natural join music_types 
  natural join register_page where username=?");
  $stmt1->bind_param("s",$uname);
  $stmt1->execute();
  $stmt1->bind_result($category,$subcategory,$fullname);
  $i=0;
  echo"</br>";
  echo"<b>Music Interests </b>"."</br>";

  echo"<table>";
  while($stmt1->fetch())
  {
   $interest=$fullname." likes ". $category ."-". $subcategory;
   echo "<input type='hidden' value=$category id='category' />"; 
   echo "<input type='hidden' value=$subcategory id='subcategory' />";
   echo "<tr><td><p style='float:left;margin: 0px;;font-size:14px;'>$interest</p> </td>";
   echo"<td><input type ='button'  name='Bttn' value='Dislike'
   style='display: block; margin-left: 10px;margin-center: 10px; height: 30px; font-size:12px;
   padding: 0px; float:left;vertical-align:text-bottom;' id='dislike' ></input>"."</br></td></tr>";
   
}
echo"</table>";
 ///REVIEWS
  echo"";
  echo "<b>Reviews :-</b>";
  $stmt2=$editsql->prepare("SELECT rating,review,concertname,venue_name,concert_date from
  review_Data natural join upcoming_concerts where concertname=concert_name and r_username=? LIMIT 5");
  $stmt2->bind_param("s",$uname);
  $stmt2->execute();
  $stmt2->bind_result($rating,$review,$concertname,$venue_name,$concert_date);
  echo"</br>";
  echo"</br>";
  while($stmt2->fetch()){
    $datetime = explode(" ",$concert_date);
    $date = $datetime[0];
    $time = $datetime[1];
    echo $fullname." gave a rating of ".$rating." and reviewed - ".'"'.$review .'"'." to the concert "."<b> $concertname </b>"
    ." held at ".$venue_name." on ".$date." at ".$time."</br>";
}
  echo "</br>";
  echo "<b>$fullname follows :- </b></br>";
  // FOLLOWS
  $stmt3=$editsql->prepare("select follower from follow_details where followee = ?");
  $stmt3->bind_param("s",$uname);
  $stmt3->execute();
  $stmt3->bind_result($follower);
  echo "<table>";
  while($stmt3->fetch())
  {
    echo "<tr><td>$follower</td>";
    echo" <input type ='hidden' value='$follower' id='follower_value'/>";
    echo"<td> <input type='button' value='Unfollow' id='Unfollow'/> </td> </tr>";


  }
  echo " </table>";
?>
<b>Background Color</b>
<table>
  <tr><td>
<select id="set_color">
<option value="#B55C69">red</option>
<option value="gray">gray</option>
<option value="white">white</option>
<option value="#79A460">green<option>
</select>
</td><td><input type='button' value='Change'id='ch_bbtn'></td>
</tr></table>

</body> 
</head>
</html>

