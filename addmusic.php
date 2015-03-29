<?php
session_start();
$uname=$_SESSION['uname'];

echo"<input type='hidden' value=$uname id='errors'/>";
echo"<input type='hidden' value=$uname id='user_id'/>";
$addmsc=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }
   

echo"<h3 align='center'>ADD MUSIC TYPES</h3>";
echo"<input type='button' value='Home' id='go_home'style='text-align:left'/>";  

echo"<div align='right'><input type='button' name='logout' value='logout' id='bttn_logout'/></div>";

echo"Select music type from drop down button,$uname</br>";
$stmt=$addmsc->prepare("select 
category,subcategory,music_types.mid from music_types where mid not in(
select music_types.mid from
 music_types natural join user_like_music where  username=?);
");
  $stmt->bind_param("s",$uname);
  $stmt->execute();
  $stmt->bind_result($category,$subcategory,$mid);
  echo"<select id='genre1'>";
  while($stmt->fetch())
    { 
    	echo"<option value=$mid> $category - $subcategory</option>";
  
    }
    echo"<input type='button' value='add' id='add_msc'/>";
echo"</select></br>";
$stmt1=$addmsc->prepare("select category,subcategory,user_like_music.mid from music_types,user_like_music where user_like_music.mid= music_types.mid
 and username=?");
 $stmt1->bind_param("s",$uname);
  $stmt1->execute();
  $stmt1->bind_result($category1,$subcategory1,$mid1);
  echo"</br> Currently User Interests</br>";
  $y=0;
  while($stmt1->fetch())
    { 

      echo"$uname likes $subcategory1 in $category1 genre</br>";
    }
    $stmt1->close();
$stmt20=$addmsc->prepare("select category,
	subcategory,user_like_music.mid from music_types,user_like_music where user_like_music.mid= music_types.mid
 and username=?");
 $stmt20->bind_param("s",$uname);
  $stmt20->execute();
  $stmt20->bind_result($category2,$subcategory2,$mid2);
    echo"</br> To Unlike Music Types</br>";
echo"<select id='genre2'>";
  while($stmt20->fetch())
    { 
    	echo"<option value=$mid2> $category2 - $subcategory2</option>";
  
    }
    echo"<input type='button' value='Dislike' id='rmv_msc'/>";
    echo"</select>";
?>
<html>
<head>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
$(document).ready(function(){
  //EDIT BUTTON DESCRIPTION$("#id_search").click(function(){
$("#add_msc").click(function(){
	var mid= $("#genre1 option:selected").val();
	var uname=$("input#user_id").val();
	var k=1;
    $.post('admpf.php',{uname:uname,mid:mid,k:k},function(data){
        alert(data);
    	location.reload();
            });

});
$("#rmv_msc").click(function(){
	var mid= $("#genre2 option:selected").val();
	var uname=$("input#user_id").val();
	var k=0;
    $.post('admpf.php',{uname:uname,mid:mid,k:k},function(data){
        alert(data);
    	location.reload();
           });

});
$('#bttn_logout').click(function(){
   var uname=$("input#user_id").val(); 
   var ut=0;
   $.post('logout.php',{uname:uname,ut:ut},function(data){
            }); 
   var url1 = "login.php?";
   window.location.href = url1;


});
$("#go_home").click(function(){
  var uname=$("input#errors").val();
  var url1 = "profile.php?uname=" + encodeURIComponent(uname);
   window.location.href = url1;

});

});
</script>
</head>
</html>