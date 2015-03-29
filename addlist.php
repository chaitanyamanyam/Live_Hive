<?php
session_start();
 //$mod=$_GET['lcname'];
$uname=$_SESSION['uname'];
$mod=$_GET["lname"];
echo"<input type='hidden' value=$uname id='get_un'/>";
$createlist=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }
   echo"<input type='button' value='Home' id='bt_home1'  />";
   echo"<h4>Lists under $mod</h4>"."</br>";
   $stmt=$createlist->prepare("select recommended_list.concert_name,concert_date,venue_name,vcity,artist_name from  
   list_details,upcoming_concerts,venue,recommended_list 
   	 where 
   	upcoming_concerts.concert_name=recommended_list.concert_name and 
   	venue_name=venuename and lid=listid and  listname =? ");
  $stmt->bind_param("s",$mod);
  $stmt->execute();
  $stmt->bind_result($cname,$cdate,$vname,$vcity,$aname);
  $k=0;
  echo"<strong>Number->Concert Name</strong></br></br>";
  while($stmt->fetch())
    { 
    	$k=$k+1;
    	echo $k."->$cname :- to be held on $cdate at $vname in $vcity by <strong>$aname</strong> "."</br>";
       
    }
    if($k==0)
    {
    	echo"No Lists under user";
    }
?>

<html>
<head>

  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>

$(document).ready(function(){
$('#bt_home1').click(function(){

  var uname=$("input#get_un").val();
  
  var url1 = "profile.php?name=" + encodeURIComponent(uname) ;
   window.location.href = url1;

});
});
</script>

</head>
</html> 