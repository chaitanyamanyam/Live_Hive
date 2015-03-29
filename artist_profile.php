<?php
session_start();
if(isset($_REQUEST['pname'])) {
                $uname = $_REQUEST['pname'];
                $_SESSION['ouser']=$uname;
            
        } else {
            $uname=$_SESSION['artist'];
        }
$ut=$_GET['r'];

echo"<body background='$uname.jpg'></body>";
if($ut==1){
$follow=$_SESSION['uname'];
}
else{
$follow=$_SESSION['artist'];

}

echo"<div align='right'><input type='button' name='logout' value='logout' id='bttn_logout'/></div>";
echo"<input type='hidden' value=$ut id='uu'/>";
echo"<input type='hidden' value=$follow id='home'/>";
echo"<div style='color:white'>";
$mainpage=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }
   echo"<input align='left' type='button' value='Home' id='bbtn_home' />";
 $stmt=$mainpage->prepare("SELECT fullname,COR,YOB,ptype from register_page  left  join user_profile
 	using (username) where register_page.username=?");
  $stmt->bind_param("s",$uname);
  $stmt->execute();
  $stmt->bind_result($k1,$k2,$k3,$k5);
  while($stmt->fetch())
    {
    	$fname=$k1;
    	$city=$k2;
    	$yearofbirth=$k3;
      $ptype1=$k5;
      //echo $k;
    }
    echo"<h2 align='center'>PROFILE</h2>";
    echo" <table align='center' style='color:white;'>";
    echo"<tr><td>Name</td><td>$fname</td></tr>"."<tr><td>Year of Birth</td><td>$yearofbirth</td></tr>";
    echo"<tr><td>City</td><td>$city</td></tr>";

    if($uname<>$follow){
    	$ouser=$uname;
        $stmt12=$mainpage->prepare("select ptype from register_page where username=?");
        $stmt12->bind_param("s",$follow);
        $stmt12->execute();
        $stmt12->bind_result($pt);
        while($stmt12->fetch()){
          $ptype=$pt;
        }
       echo"<input type='hidden' value=$ouser id='home_bt1'/>";
       echo"<input type='hidden' value=$follow id='home_bt'/>";
    $stmt10=$mainpage->prepare("select count(*) from follow_details where followee=? and follower=?");
  $stmt10->bind_param("ss",$follow,$uname);
  $stmt10->execute();
  $stmt10->bind_result($follow_ornot);
  while($stmt10->fetch()){
  	$fn=$follow_ornot;
  }
  if($ptype=='user'){
  if( $fn==1){
  	$bad='Unfollow';
  }
  else{
  	$bad='Follow';
  }
 echo"<tr><td><strong>$ptype1</strong></td><td><input type='button' value=$bad id='like'/></td></tr>";
}
}
    
   
    echo"</table>";
  echo"<h4 align='center'>Reviews given to $fname:-</h4>";
  $stmt1=$mainpage->prepare("SELECT concertname,rating,review,review_date,r_username from review_data natural join upcoming_concerts
    where  concertname=concert_name and artist_name=? ORDER BY review_date DESC LIMIT 5");
  $stmt1->bind_param("s",$uname);
  $stmt1->execute();
  $stmt1->bind_result($c1,$c2,$c3,$c4,$c5);
  $red=0;
  while($stmt1->fetch())
    {
    	$cname=$c1;
    	$rat=$c2;
    	$rv=$c3;
      $r_date=$c4;
      $r_user=$c5;
      echo"<p align='center'>$r_user gave a Rating of $rat and Review is '$rv'
      for $cname performed by <b> $fname </b>on $r_date </p>";
        $red=$red+1;

    }
    if($red==0){
      echo"<p align='center'>No reviews given to $fname</p>";
    }
echo"<table align='center'style='color:white;'><tr><td>";
echo"<h4 align='center'>Music Interests:-</h4>";
$stmt7=$mainpage->prepare("SELECT category,subcategory from music_types natural join artist_play_music 
    where artist_name= ?");
  $stmt7->bind_param("s",$uname);
  $stmt7->execute();
  $stmt7->bind_result($mc,$msc);
  $ch=0;
  while($stmt7->fetch())
    {
    	$mty=$mc;
    	$mty1=$msc;
    	$ch=$ch+1;
     
      echo"<p align='center'>$fname plays $mty1 in $mty genre</p>";

    }

      if($ch==0){ echo"<p align='center'>Doesnot play any music type </p>";}
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
    $uname1='%'.$uname.'%';
  echo"<h4 align='center'>Concerts Posted:-</h4>";
$stmt2=$mainpage->prepare("SELECT concert_name,concert_date,venue_name,category,subcategory,vcity,artist_name
 from upcoming_concerts,venue,music_types
 where venue.venuename=venue_name and m_type=mid and (uc_username=? or concert_name like ?)
Order by concert_date DESC LIMIT 5 ");
  $stmt2->bind_param("ss",$uname,$uname1);
  $stmt2->execute();
  $stmt2->bind_result($p1,$p2,$p3,$p4,$p5,$p6,$p7);
  $add=0;
  echo"<div style='color:white;'>";
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
   echo"</div>";
    
  $king=$uname;

  echo"</div>";
 

?>
<html>
<head>

  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>

$(document).ready(function(){
  //EDIT BUTTON DESCRIPTION
$('#bbtn_home').click(function(){
  var uk=$("input#uu").val();
  var uname=$("input#home").val();
  
 if(uk==1){
    var url1 = "profile.php?uname=" + encodeURIComponent(uname);
   window.location.href = url1;
 }
 else{
  	var url1 = "artist_home.php?uname=" + encodeURIComponent(uname);
   window.location.href = url1;

}
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
$('#bttn_logout').click(function(){
   var uname=$("input#user_id").val(); 
   var ut=1;
   $.post('logout.php',{uname:uname,ut:ut},function(data){
            }); 
   var url1 = "login.php?";
   window.location.href = url1;


});


});
</script>
</html>
</head>