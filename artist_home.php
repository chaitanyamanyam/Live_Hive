<?php
session_start();
$pname=trim($_GET["uname"]);
$pname1=$_SESSION['artist'];
$_SESSION['artist']=$pname;
echo"<input type='hidden' value=$pname id='user_id'/>";
echo " <div align='right'> <strong>Enter Keyword</strong><input type='text' id='txt_search'/>";
echo"<input type='button' id='id_search' name='id_search' value='Search'/></div>";
echo "<input type='hidden' value=$pname name='pname' />";
echo "<input type='button' id='bttn_edit' value='Edit Profile'/>"; 
echo"<input type='button' id='add_conc' value='add Concerts'/>";
echo"<input type='button' id='u_pf' value='Profile'/>";
echo"<div align='right'><input type='button' name='logout' value='logout' id='bttn_logout'/></div>";
echo"</br>"."</br>"."</br>";
echo "Welcome back  to Artist, ". $pname."</br>";
 $profsql1=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }
  $nw=$profsql1->prepare("SELECT count(*) from artist_profile where ausername= ?");
  $nw->bind_param("s",$pname);
  $nw->execute();
  $nw->bind_result($returned);
  while($nw->fetch())
    {
      $p=$returned;
      echo"<input type='hidden' id='nw' value=$p />";
    }

    echo"<p><b>What's on your mind???</b></p>";
    echo"<textarea id='Txtarea_post' rows='3'cols='30' style='float:left;margin: 0px;
  vertical-align:bottom;font-size:14px;'></textarea><input type='button' value='Submit Post' id='bttn_post'/></br></br></br>";
 

 echo"</br><b>Posts by your Followers</b></br>";
  $stmt33=$profsql1->prepare("select postee,content,post_date from post_data where postee in (select username from user_like_artist where artistname =?)
order by post_date DESC LIMIT 5");
  $stmt33->bind_param("s",$pname);
  $stmt33->execute();
  $stmt33->bind_result($postee,$cont,$pdate);
  while($stmt33->fetch())
    {
      echo"$postee posted a message <b>'$cont '</b> at $pdate</br>";
      //echo $k;
    }
    echo"</br><b>Posts by  Artists</b></br>";
  $stmt33=$profsql1->prepare("select postee,content,post_date from post_data where postee in 
    (select ausername from artist_profile )
order by post_date DESC LIMIT 5");
  $stmt33->execute();
  $stmt33->bind_result($postee,$cont,$pdate);
  while($stmt33->fetch())
    {
      echo"$postee posted a message <b>'$cont '</b> at $pdate</br>";
      //echo $k;
    }

  echo"<table><tr>";
  echo"<p><b>'Upcoming Concerts of your competitors'</b></p></tr>";
  
    $stmt2=$profsql1->prepare("select concert_name,concert_date,venue_name,artist_name,vcity from upcoming_concerts,venue 
      where venue_name=venuename and m_type in(select mid from artist_play_music natural join music_types where artist_name=?) and 
artist_name<>? order by concert_date DESC LIMIT 5");
  $stmt2->bind_param("ss",$pname1,$pname1);
  $stmt2->execute();
  $stmt2->bind_result($r1cname,$r1cdate,$r1vname,$r1aname,$r1vcity);
  $y=0;
    while($stmt2->fetch())
    {   
    	
    	 echo"$r1aname is performing  a concert and name is <b>$r1cname</b> on $r1cdate at $r1vname in $r1vcity </br>";
     $y=$y+1;
    }
     if($y==0){
    	echo"No updates from your competitors "."</br>";
    }
    $stmt3=$profsql1->prepare("select r_username,concertname,rating,review,review_date,attornot from 
      review_data,upcoming_concerts where concertname=concert_name and artist_name=? order by review_date DESC LIMIT 5
");
    echo"</br>";
    echo"<b>'Recent Reviews on your concert's by fans'</b></br> ";
    echo"</br>";
  $stmt3->bind_param("s",$pname1);
  $stmt3->execute();
  $stmt3->bind_result($r2rname,$r2cname,$r2rating,$r2review,$r2r_date,$r2att);
  $z=0;
    while($stmt3->fetch())
    {   
      if($r2att==''){
        $r2att='Planned to';
      } 
       echo"$r2rname gave a rating of $r2rating and reviewed that'$r2review' on the concert-$r2cname
             on $r2r_date and he $r2att</br>";
     $z=$z+1;
    }
     if($z==0){
      echo"No reviews from your fans "."</br>";
    }
  
  
    

?>

<html>
<head>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
$(document).ready(function(){
  //EDIT BUTTON DESCRIPTION$("#id_search").click(function(){
$("#id_search").click(function(){
	var sr_txt=$("input#txt_search").val();
	var uname=$("input#user_id").val();
	//alert(sr_txt + uname);
	 var url = "artist_search_results.php?name=" + encodeURIComponent(uname) + "&txt=" + encodeURIComponent(sr_txt);
        window.location.href = url;

});
$('#bttn_logout').click(function(){
   var uname=$("input#user_id").val(); 
   var ut=1;
   $.post('logout.php',{uname:uname,ut:ut},function(data){
            }); 
   var url1 = "login.php?";
   window.location.href = url1;


});
$('#add_conc').click(function(){
   var uname=$("input#user_id").val();
   var ptype='artist';
   var url1 = "add_concert.php?name1=" + encodeURIComponent(uname) + "&ptype=" +encodeURIComponent(ptype);
   window.location.href = url1;

});
$('#bttn_edit').click(function(){
   var uname=$("input#user_id").val(); 
   var nw=$("input#nw").val();
   var sa=0;
   if(nw==0){
    $.post('ad_pf_new.php',{uname:uname,sa:sa},function(data){
            });
   }
   var url1 = "edit_aprofile?pname=" + encodeURIComponent(uname) ;
   window.location.href = url1;


});
$('#u_pf').click(function(){
   var uname=$("input#user_id").val(); 
  
   var url1 = "artist_profile.php?pname=" + encodeURIComponent(uname) ;
   window.location.href = url1;


});
$('#bttn_post').click(function(){

   var uname=$("input#user_id").val(); 
    var content=$("#Txtarea_post").val();
   $.post('add_post.php',{content:content,uname:uname},function(data){
            alert(data);
            location.reload();
            });

});


});
</script>
</head>
</html>