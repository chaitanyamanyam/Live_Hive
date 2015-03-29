<?php
session_start();
$pname=$_SESSION['uname'];
//$_SESSION['uname']=$pname;
echo"<input type='hidden' value=$pname id='user_id'/>";
echo " <div align='right'> <strong>Enter Keyword</strong><input type='text' id='txt_search'/>";
echo"<input type='button' id='id_search' name='id_search' value='Search'/></div>";
echo "<input type='button' id='bttn_edit' value='Edit Profile'/>";
echo"<input type='button' id='add_conc' value='add Concerts'/>";
echo"<input type='button' id='u_pf' value='Profile'/>";
echo"<input type='button' id='cl_1' value='Create Lists'/>";
echo"<input type='button' id='like_music' value='Add Genres'/>";
echo"<input type='button' id='add_rv' value='Add Ratings'/>";
echo "<input type='hidden' value=$pname name='pname' />"; 
echo"<div align='right'><input type='button' name='logout' value='logout' id='bttn_logout'/></div>";
echo"</br>"."</br>"."</br>";
echo "Welcome back, ". $pname."</br>";

 $profsql=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }
  $stmt=$profsql->prepare("SELECT rank from user_profile where username= ?");
  $stmt->bind_param("s",$pname);
  $stmt->execute();
  $stmt->bind_result($returned);
  while($stmt->fetch())
    {
      $k=$returned;
      echo"<input type='hidden' id='rank' value=$k />";
      //echo $k;
    }
    $nw=$profsql->prepare("SELECT count(*) from user_profile where username= ?");
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
 
  echo"<b>Posts by your Favourite Artists</b></br>";
  $stmt33=$profsql->prepare("select postee,content,post_date from post_data where postee in (select artistname from user_like_artist where username =?)
order by post_date DESC");
  $stmt33->bind_param("s",$pname);
  $stmt33->execute();
  $stmt33->bind_result($postee,$cont,$pdate);
  while($stmt33->fetch())
    {
      echo"$postee posted a message <b>'$cont '</b> at $pdate</br>";
      //echo $k;
    }

    $stmt333=$profsql->prepare("select postee,content,post_date from post_data where postee in (
select k1.username from user_like_music as k,user_like_music as k1 where k1.mid=k.mid and 
k1.username<>k.username and k.username=?)
order by post_date DESC");
  $stmt333->bind_param("s",$pname);
  $stmt333->execute();
  $stmt333->bind_result($postee,$cont,$pdate);
   echo"</br><b>Posts by Users who have similar interests</b></br>";
  while($stmt333->fetch())
    {
      echo"$postee posted a message <b>'$cont '</b> at $pdate</br>";
      //echo $k;
    }
$stmt1=$profsql->prepare("SELECT concert_name,artist_name,venue_name,concert_date,category,subcategory from upcoming_concerts natural join music_types natural join 
user_like_music where mid=user_like_music.mid and m_type=mid and  event_posted >
(select lastlogin from user_profile where username=?) and user_like_music.username= ? 
 order by concert_date DESC
  LIMIT 5");
  $stmt1->bind_param("ss",$pname,$pname);
  $stmt1->execute();
  $stmt1->bind_result($rcname,$raname,$rvname,$rcdate,$rcat,$rscat);
  echo"<table><tr>";
  echo"<p><b>'Upcoming Concerts of your favourite genre'</b></p></tr>";
  echo"<tr><table>";
  echo"<tr><th> Concert Name </th><th> Artist Name </th><th> Venue Name</th><th> Concert Date</th><th> Category</th><th>
   Sub-Category</th></tr>";
  $k=0;
    while($stmt1->fetch())
    {   
    	if($raname==''){
    		$raname='Linkin_Park';
    	}
    	 echo"<tr>
    	 <td>$rcname</td>
    	 <td>$raname</td>
    	 <td>$rvname</td> 
    	 <td>$rcdate</td>
    	  <td>$rcat</td>
    	   <td>$rscat</td>
    	 </tr>";
      $k=$k+1;
    }
    if($k==0){
    	echo"Nothing to show "."</br>";
    }
    echo"</table></tr>";
    $stmt2=$profsql->prepare("(SELECT concertname, r_username, rating, review from review_data,
   upcoming_concerts, user_like_music, user_profile where user_profile.username =?
    and user_profile.username=user_like_music.username and user_like_music.mid=upcoming_concerts.m_type
     and upcoming_concerts.concert_name=review_data.concertname and review_date > lastlogin and 
     r_username<>user_profile.username order by concertname) union
   (SELECT concertname, r_username, rating, review from review_data, user_profile,  
  upcoming_concerts, user_like_artist where user_profile.username =? and user_profile.
  username=user_like_artist.username and user_like_artist.artistname=upcoming_concerts.artist_name 
  and upcoming_concerts.concert_name=review_data.concertname and review_date > lastlogin and 
     r_username<>user_profile.username order by concertname)");
  $stmt2->bind_param("ss",$pname,$pname);
  $stmt2->execute();
  $stmt2->bind_result($r1cname,$r1uname,$r1rat,$r1rev);
  echo"<tr><p><b>'Recently given ratings'</b></p></tr>";
  echo"<tr><table><tr><th>Concert Name </th><th> Reviewer Name </th><th> Rating</th><th> Review</th></tr>";
  $y=0;
    while($stmt2->fetch())
    {   
    	
    	 echo"<tr>
    	 <td>$rcname</td>
    	 <td>$r1uname</td>
    	 <td>$r1rat</td> 
    	 <td>$r1rev</td>
    	  
    	 </tr>";
   $y=$y+1;
    }
     if($y==0){
    	echo"Nothing to show "."</br>";
    }
    echo"</table></tr>";
    
    echo"</table>"
?>

<html>
<head>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
$(document).ready(function(){
  $("#id_search").click(function(){

  var sr_txt=$("input#txt_search").val();
  var uname=$("input#user_id").val();
   var url = "search_results.php?name=" + encodeURIComponent(uname) + "&txt=" + encodeURIComponent(sr_txt);
        window.location.href = url;

});
  $('#add_conc').click(function(){
   var uname=$("input#user_id").val();
   var rank=$("input#rank").val();
   var ptype='user';
   if(rank >7) 
   {
   var url1 = "add_concert.php?name1=" + encodeURIComponent(uname) + "&ptype=" +encodeURIComponent(ptype);
   window.location.href = url1;
   }
   else{
    alert("Not Eligible to add concerts");
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

$('#u_pf').click(function(){
   var uname=$("input#user_id").val(); 
   var k=0;
   var url1 = "user_profile.php?pname=" + encodeURIComponent(uname)+"&k=" +encodeURIComponent(k);
   window.location.href = url1;


});
$('#bttn_edit').click(function(){

   var uname=$("input#user_id").val(); 
   var nw=$("input#nw").val();
   var k=1;
   if(nw==0){
    $.post('ad_pf_new.php',{uname:uname,sa:k},function(data){
            });
   }
   var url1 = "edit_profile?pname=" + encodeURIComponent(uname);
   window.location.href = url1;

 });

$('#cl_1').click(function(){
   var uname=$("input#user_id").val(); 
  
   var url1 = "createlist.php?lcname=" + encodeURIComponent(uname);
   window.location.href = url1;


});
$('#add_rv').click(function(){
  
   var url1 = "add_review1.php?" ;
   window.location.href = url1;


});
$('#like_music').click(function(){
  
   var url1 = "addmusic.php?";
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