<?php
session_start();
if(isset($_REQUEST['pname'])) {
                $uname = $_REQUEST['pname'];
                $_SESSION['ouser']=$uname;
            
        } else {
            $uname=$_GET['pname'];
        }
$yu=$_GET['k'];
if($yu==0){
	$arr=0;
}
else{
	$arr=1;
}
echo"<input type='hidden' value=$uname id='uu'/>";
$mainpage=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }

   echo"<input align='left' type='button' value='Home' id='bbtn_home' />"."<div align='right'><input type='button' name='logout' value='logout' id='bttn_logout'/></div>";

 $stmt=$mainpage->prepare("SELECT fullname,COR,YOB,rank,ptype from register_page  left  join user_profile
 	using (username) where register_page.username=?");
  $stmt->bind_param("s",$uname);
  $stmt->execute();
  $stmt->bind_result($k1,$k2,$k3,$returned,$k5);
  while($stmt->fetch())
    {
    	$fname=$k1;
    	$city=$k2;
    	$yearofbirth=$k3;
      $rank=$returned;
      $ptype=$k5;
      echo"<input type='hidden' id='rank' value=$rank />";
      //echo $k;
    }
    if($rank='null'){
    	$rank=6;
    }
    echo"<h2 align='center'>PROFILE</h2>";
    echo" <table align='center'>";
    echo"<tr><td>Name</td><td>$fname</td></tr>"."<tr><td>Year of Birth</td><td>$yearofbirth</td></tr>";
    echo"<tr><td>City</td><td>$city</td></tr>"."<tr><td>Rank</td><td>$rank</td></tr>";
    echo"<input type='hidden' value=$arr id='yu'/>";
    if($uname<>$_SESSION['uname'] ){

    	if($arr==0)
    	{
    		$yn=1;
    		echo"<input type='hidden' value=$yn id='yu'/>";

    	}
    	$ouser=$uname;
        $k=$_SESSION['uname'];
       echo"<input type='hidden' value=$ouser id='home_bt1'/>";
   
       echo"<input type='hidden' value=$k id='home_bt'/>";
    $stmt10=$mainpage->prepare("select count(*) from follow_details where followee=? and follower=?");
  $stmt10->bind_param("ss",$k,$uname);
  $stmt10->execute();
  $stmt10->bind_result($follow_ornot);
  while($stmt10->fetch()){
  	$fn=$follow_ornot;
  }

  if($yn!=1){
  if( $fn==1){
  	$bad='Unfollow';
  }
  else{
  	$bad='Follow';
  }
 echo"<tr><td><strong>$ptype</strong></td><td><input type='button' value=$bad id='like'/></td></tr>";
}
}
    
   
    echo"</table>";
  echo"<h4 align='center'>$uname Reviews given:-</h4>";
  $stmt1=$mainpage->prepare("SELECT concertname,rating,review,review_date,attornot from review_data 
  	where r_username=? LIMIT 5");
  $stmt1->bind_param("s",$uname);
  $stmt1->execute();
  $stmt1->bind_result($c1,$c2,$c3,$c4,$c5);
  while($stmt1->fetch())
    {
    	$cname=$c1;
    	$rat=$c2;
    	$rv=$c3;
      $r_date=$c4;
      $attornot=$c5;
      if($attornot==''){
      	$attornot='Not Attended';
      }
      echo"<p align='center'>Gave a Rating of $rat and Review is '$rv'
      for $cname on $r_date and $fname $attornot it</p>";

    }
echo"<table align='center'><tr><td>";
echo"<h4 align='center'>Music Interests:-</h4>";
$stmt7=$mainpage->prepare("SELECT category,subcategory from music_types natural join user_like_music 
  	where username=?");
  $stmt7->bind_param("s",$uname);
  $stmt7->execute();
  $stmt7->bind_result($mc,$msc);
  $ch=0;
  while($stmt7->fetch())
    {
    	$mty=$mc;
    	$mty1=$msc;
    	$ch=$ch+1;
     
      echo"<p align='center'>$fname likes $mty1 in $mty</p>";

    }

      if($ch==0){ echo"<p align='center'> No Music Interests </p>";}
 echo"</td><td>";
    echo"<h4 align='center'>Follows:-</h4>";
$stm66=$mainpage->prepare("SELECT artistname from  user_like_artist 
  	where username=?");
  $stm66->bind_param("s",$uname);
  $stm66->execute();
  $stm66->bind_result($amam);
  $er=0;
  while($stm66->fetch())
    {
    	$am1=$amam;
    	
       $er=$er+1;

      echo"<p align='center'>$fname likes $am1</p>";

    }
    If($er==0){  echo"<p align='center'> Currently not </br>following anyone </p>";}
    echo"</td><td>";
     echo"<h4 align='center'>List of followers:-</h4>";
  $stmt3=$mainpage->prepare("select followee from follow_details where follower =? LIMIT 5");
  $stmt3->bind_param("s",$uname);
  $stmt3->execute();
  $stmt3->bind_result($f1);
  $f=0;
  while($stmt3->fetch())
    {
    	$follow=$f1;
          echo "<a href='user_profile.php?pname=" . $follow . "''>$follow</a>"."</br>";
       $f=$f+1;
    }
    if($f==0){
    	echo"<p align='center'>No Followers</p>";
    }
    echo"</td></tr></table>";
  echo"<h4 align='center'>Concerts Posted:-</h4>";
$stmt2=$mainpage->prepare("SELECT concert_name,concert_date,venue_name,category,subcategory,vcity,artist_name
 from upcoming_concerts,venue,music_types
 where venue.venuename=venue_name and m_type=mid and uc_username=?
Order by concert_date DESC LIMIT 5 ;");
  $stmt2->bind_param("s",$uname);
  $stmt2->execute();
  $stmt2->bind_result($p1,$p2,$p3,$p4,$p5,$p6,$p7);
  $add=0;
  while($stmt2->fetch())
    {
    	$cname=$p1;
    	$cdate=$p2;
    	$vname=$p3;
        $cat=$p4;
        $scat=$p5;
        $vcity=$p6;
        $aname=$p7;
     
      echo"<p align='center'>Posted a concert '$cname' to be performed by $aname on $cdate at $vname in $vcity in the genre of $cat and subcategory
             of $scat  </p>";
       $add=$add+1;

    }
    if($add==0){
    	echo"<p align='center'>No concerts posted by $fname</p>";
    }

    
  $king=$uname;

    echo"<h4 align='center'>Lists created:</h4>";
  $stmt80=$mainpage->prepare("SELECT distinct(listname)	,category,subcategory,list_created from list_details,recommended_list,
    music_types 
   where mtype = mid and listid = lid and listmoderator = ? ORDER BY list_created DESC ");
  $stmt80->bind_param("s",$uname);
  $stmt80->execute();
  $stmt80->bind_result($w1,$w2,$w3,$w4);
  $check=0;
  while($stmt80->fetch())
    {
    $lname=$w1;
    $lcat=$w2;
    $lscat=$w3;
    $lcrea=$w4;
     echo"<p align='center'>List name is <a href='addlist.php?lname=" . $lname . "'>$lname</a> 
     in the genre of $lcat in subcategory $lscat created on
     $lcrea </p>";
       $check=$check+1;

    }
    if($check==0){
    echo"<p align='center'>No Lists created</p>";
    }
 

?>
<html>
<head>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>

$(document).ready(function(){
  //EDIT BUTTON DESCRIPTION
$('#bbtn_home').click(function(){
  var a_u=$("input#yu").val();
  var uname=$("input#home_bt").val();
  if(a_u==1){
  	var url1 = "artist_home.php?uname=" + encodeURIComponent(uname);
   window.location.href = url1;
  }
  else{
  var url1 = "profile.php?uname=" + encodeURIComponent(uname) ;
   window.location.href = url1;
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
$('#like').click(function(){
  var uname=$("input#home_bt").val(); 
  var ouser=$("input#home_bt1").val();

  var kin=$("#like").val();
  if(kin=='Follow'){
  	var we=0;
  $.post('like.php',{uname:uname,ouser:ouser,feb:we},function(data){
		alert(data);

         $("#like").prop('value','Unfollow');
         location.reload();
            }); 
}
else{
    var we=1;
	$.post('like.php',{uname:uname,ouser:ouser,feb:we},function(data){
		alert(data);

         $("#like").prop('value','follow');
         location.reload();
            }); 


}
});


});
</script>
</html>
</head>