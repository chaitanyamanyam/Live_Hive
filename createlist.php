<?php
$createnewlist=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }
$aa=$_GET['lcname'];
$i=0;

echo"<input type='hidden' value=$aa id='errors'/>";

echo"<div align='right'><input type='button' name='logout' value='logout' id='bttn_logout'/></div>";
echo "<input type='button' value='Home' id='go_home'/>"."</br>";  
echo"List Creation Form";
 echo"<table align='left'>";
echo"<tr><td>Listname </td><td><input type='text' id='uname' /></td><br>";
echo"<tr><td>Genre</td><td>"; 

$stmt=$createnewlist->prepare("select category,subcategory,mid from music_types ");
  $stmt->execute();
  $stmt->bind_result($category,$subcategory,$mid);
  echo"<select id='genre'>";
  while($stmt->fetch())
    { 
    	echo"<option value=$mid> $category - $subcategory</option>";
  
    }
echo"</select></td></tr>";
echo"<tr> <td> List ID  </td><td>";
echo"<select id ='num'>";
while($i<15){
	echo"<option value=$i>$i</option>";
	$i=$i+1;

}
echo"</select></td></tr>";

echo"</table>";
echo"<input  type='button' value='Submit' id='cl'/></br></br></br></br></br>";
echo"Select List name</br>";
$stmt1=$createnewlist->prepare("select listname,concert_name from list_details,recommended_list where lid=listid and listmoderator=?");
  $stmt1->bind_param("s",$aa);
  $stmt1->execute();
  $stmt1->bind_result($lname,$cname);
  $i=0;
  echo"<select id='all1'>";
  while($stmt1->fetch())
    { 
        $mix=$lname.".".$cname;
    	echo"<option value=$mix>$lname->$cname</option>";

    }

echo"</select>";
echo"<input type='button' id ='change1' value='Edit Concert name' /></br>";

 echo "<textarea disabled id='Txtarea_edit1'rows='1' cols='20'style='height:30px;
float:left;margin: 0px;vertical-align:bottom;font-size:14px;' ></textarea>";


echo"</br></br><strong>Add Concert</strong>";
$stmt4=$createnewlist->prepare("select listname,listid from list_details where listmoderator=?");
  $stmt4->bind_param("s",$aa);
  $stmt4->execute();
  $stmt4->bind_result($lname1,$lid);
  echo"</br><select id='li'>";
  while($stmt4->fetch())
    { 
    	echo"<option value=$lid>$lname1</option>";

    }
    echo"</select>";
    $stmt4=$createnewlist->prepare("select concert_name from upcoming_concerts");
  $stmt4->execute();
  $stmt4->bind_result($cname);
  echo"</br><select id='conc'>";
  while($stmt4->fetch())
    { 
    	echo"<option value=$cname>$cname</option>";

    }
    echo"</select>";
    echo"<input type='button' id='add_conc_list' value='Add Concert to list'/>";
?>

<html>
<head>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
$(document).ready(function(){
  //EDIT BUTTON DESCRIPTION$("#id_search").click(function(){
$("#cl").click(function(){
	var un=$("input#uname").val();
    var ac_vcity= $("#genre option:selected").val();
    var id= $("#num option:selected").text();

	$.post('add_new_list.php',{uname:un,genre:ac_vcity,num:id},function(data){
		alert(data);
            }); 

});
$("#change1").click(function(){
    alert("hello");
    var mix=$("#all1 option:selected").val();
    alert(mix);
    $("#Txtarea_edit1").val()=mix;
	if($(this).prop('value')=="Edit Concert name")
	{
 
		$("#change1").prop('value','Submit Changes');
        $('textarea[id="Txtarea_edit1"]').prop('disabled',false).focus();

}	else{
		$("#change1").prop('value','Edit Concert name');
        $('textarea[id="Txtarea_edit1"]').prop('disabled',true).focus();
         var test= $("#Txtarea_edit1").val();
         alert(test);
        
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
$("#add_conc_list").click(function(){
 
    var cname= $("#conc option:selected").val();

    var lname= $("#li option:selected").val();
    $.post('add_newconc_list.php',{cname:cname,lname:lname},function(data){
		alert(data);
		location.reload();
            }); 


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