<?php

//echo $uk;
ini_set('display_errors', 'off');
$uname=trim($_GET['name1']);
$ptype=trim($_GET['ptype']);

echo"<input type='hidden' value=$ptype id='pty' />";
echo"<input type='hidden' value=$uname id='un' />";
$add1_conc_sql=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();

}
  
$stmt10=$add1_conc_sql->prepare("SELECT fullname from register_page where username=?");
  $stmt10->bind_param("s",$uname);
  $stmt10->execute();
  $stmt10->bind_result($funame);
  while($stmt10->fetch()){
    $fullname=$funame;
  }
echo"<b><h3><p style='text-align:center'>ADD CONCERT</p></b></h3>";

echo"<div align='right'><input type='button' name='logout' value='logout' id='bttn_logout'/></div>";
echo"<input type='button' value='Home' id='go_home'style='text-align:left'/>"."</br>";  
echo "Please enter the following details, " .$fullname."</br></br>";


echo"<b>Add Concert</b>";
echo"<table>";
echo"<tr>";
echo "<td>Name of Concert  </td><td><input type='text' id='concert_name'/>*</td></tr>";
if($ptype=='user'){
echo "<tr><td>Artist Name "."</td>"."";
$stmt1=$add1_conc_sql->prepare("SELECT ausername from artist_profile");
  $stmt1->execute();
  $stmt1->bind_result($artist_username);
  $i=0;
  echo"<td><select id='aname'>";
  while($stmt1->fetch())
  {
     $arus='artist'.$i;
     echo "  <option value='$artist_username'>$artist_username</option>";
     $i=$i+1;
  }
  echo"</select></td></tr>";
}
  echo "<tr><td>City - Venue      </td>			";
  $stmt2=$add1_conc_sql->prepare("SELECT vcity,venuename from venue");
  $stmt2->execute();
  $stmt2->bind_result($venue_city,$venuename);
  $j=0;
  echo"<td><select id='select_vcity' >";
  while($stmt2->fetch())
  {
     $vc='city'.$i;
     $venue_city_name=$venue_city ." - ". $venuename;
     echo " <option value='$venue_city_name'>$venue_city_name</option>";
     $i=$i+1;
  }  
echo "</select></td></tr>";
echo "<tr><td>Genre	</td>		";
if($ptype=='user'){
  $stmt3=$add1_conc_sql->prepare("SELECT category,subcategory from music_types");
  $stmt3->execute();
  $stmt3->bind_result($c_category,$c_subcategory);
  $j=0;
}else{
   $stmt3=$add1_conc_sql->prepare("SELECT category,subcategory from music_types natural join artist_play_music where
    artist_name=?");
  $stmt3->bind_param("s",$uname);
  $stmt3->execute();
  $stmt3->bind_result($c_category,$c_subcategory);
  $j=0;
}
  echo"<td><select id='a_cgenre'>";
  while($stmt3->fetch())
  {
     $cat='cat'.$j;
     $category_subcategory=$c_category." - ".$c_subcategory;
     echo " <option value='$category_subcategory'>$category_subcategory</option>";
     $j=$j+1;
  }
echo "</select></td></tr>";
echo "<tr><td>Price</td>  "."<td><input type='text' id='a_cprice'name='price' onkeypress='return checkNum();' />*</td></tr>"; 
echo "<tr><td>Availability </td>"."<td><input type='text' id='a_cavailability'name= 'availability' onkeypress='return checkNum();' />* </td></tr>";




?>
<html>
<head>
	<div class="demo">
 <tr><td>   
Date:</td><td>
    <select id="month" name="month">
        <option value="01">January</option> 
        <option value="02">February</option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
    </select>
    <select id="day" name="day">
        <option value="01">1</option>
        <option value="02">2</option>
        <option value="03">3</option>
        <option value="04">4</option>
        <option value="05">5</option>
        <option value="06">6</option>
        <option value="07">7</option>
        <option value="08">8</option>
        <option value="09">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
    </select>
    <select id="year" name="year">
        <option value="2011">2011</option>
        <option value="2012">2012</option>
        <option value="2013">2013</option>
        <option value="2014">2014</option>
        <option value="2015">2015</option>
    </select>
    <input type="hidden" id="datepicker" />
  </td></tr>
<body onload='init()'>
<tr><td>Time:</td>
                  <td>
                        <select id='hours' name='hours' onchange="setTimeStamp()"></select>
                 
                        <select id='minutes' name='minutes' onchange="setTimeStamp()"></select>
                  *</td>
            </tr></br></body>
</table>
<input type='button' value='Submit' name='add_conc_submit' id='add_conc_submit'><font size ="2">(Enter Details with asterisk)
</font></input>
</div>
	<script type="text/javascript">
function checkNum()
{
 
if ((event.keyCode > 47 && event.keyCode < 58)  )
   return true;
else{
	return false;
} 
}
</script>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
$(document).ready(function(){
  //EDIT BUTTON DESCRIPTION
$("#add_conc_submit").click(function(){
  var ac_uname=$("input#un").val();
  var ptype=$("input#pty").val();
  var ac_cn= $("input#concert_name").val();
  if(ptype=='user'){
  var ac_aname=$("#aname option:selected").text();
} else{
  ac_aname=ac_uname;
}
  var ac_vcity= $("#select_vcity option:selected").text();
  var ac_genre=$("#a_cgenre option:selected").text();
  var ac_price=$("input#a_cprice").val();
  var ac_availability=$("input#a_cavailability").val();
  var ac_day=$("#day option:selected").val();
  var ac_month=$("#month option:selected").val();
  var ac_year=$("#year option:selected").text();
  var ac_hr=$("#hours option:selected").text();
  var ac_min=$("#minutes option:selected").text();
  var ac_time=ac_hr+":"+ac_min+":"+"00";
  var ac_date=ac_year+"/"+ac_month+"/"+ac_day;
  var add_conc_combined= ac_uname+"-"+ac_cn+"-"+ac_aname+"-"+ac_vcity+"-"+ac_genre
               +"-"+ac_price+"-"+ac_availability+"-"+ac_date+"-"+ac_time;
           if((ac_cn !== '') && (ac_availability!=='')&& (ac_price!=='')&& (ac_hr!=='00'))
           {
            $.post('add_con_db.php',{com:add_conc_combined},function(data){
            alert(data);
           window.location.reload();
        
            });
           } 
           else
           {
           alert("Please Enter All Fields Properly");
           
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

$("#go_home").click(function(){
  var uname=$("input#un").val();
  var ptype=$("input#pty").val();
  if(ptype=='user'){
var url1 = "profile.php?uname=" + encodeURIComponent(uname);
   window.location.href = url1;
}
else{
  var url1 = "artist_home.php?uname=" + encodeURIComponent(uname);
   window.location.href = url1;
}
});
});

</script>
<script>
var minutesStep = 1;

//      The time objects
var minutesObj = document.getElementById( 'minutes' );      
var hoursObj = document.getElementById( 'hours' );      

function init(){
      var minute =0;
      var value;
      while( minute<60){
            value =  minute<10 ? '0' + minute : minute;
            minutesObj.options[ minutesObj.options.length ] = new Option( value, value);
            minute+= minutesStep;
            }

      for (ind=0; ind<24; ind++){
            value =  ind<10 ? '0' + ind : ind;
            hoursObj.options[ hoursObj.options.length ] = new Option( value, value);
            }
      }
      function setTimeStamp(){
      document.getElementById( 'timeStamp').value = hoursObj.value +':'+ minutesObj.value;      
      }    
</script>

