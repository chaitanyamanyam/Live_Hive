<?php
session_start();
$uname=$_GET['name'];
$k=$_SESSION['uname'];
$k1=$_SESSION['artist'];

echo"<input type='hidden' value=$uname id='st_uname'/>";
$s_text=trim($_GET['txt']);
if($uname==$k1){ 
  $ye=0;
}
else{
  $ye=1;
}
echo"<input type='hidden' value=$ye id='a_u'/>";
$searchsql=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();

}
$search_tag='%'.$s_text.'%';
//$search_tag='%metal%';

echo"<h3><p style='text-align:center'>Search Results</p></h3>";
echo"<div align='right'><input type='button' name='logout' value='logout' id='bttn_logout'/></div>";
echo"<input type='button' value='Home' id='go_home'style='text-align:left'/>"."</br>"; 
echo"<input type='hidden' id='errors' value=$uname />";
echo "</br>"."Search Key Word is <strong>".$s_text." </strong> "."</br>"."</br>";
$stmt=$searchsql->prepare("SELECT username,fullname,Cor,description,rank from register_page natural join user_profile where
                        username like ? OR description like ? OR cor like ? LIMIT 5");
  $stmt->bind_param("sss",$search_tag,$search_tag,$search_tag);
  $stmt->execute();
  $stmt->bind_result($r_uname,$r_fname,$r_city,$r_dscp,$r_rank);
  
  echo"<hr style='height:1px;border:none;color:#333;background-color:#333;' />";
  echo"<table>";
  echo"<tr><strong>Users</strong></tr>";
  echo"<tr><table>";
  $i=0;
  $y=1;
  while($stmt->fetch())
    {
      echo"<tr><td>Username:
          <a href='user_profile.php?pname=".$r_uname."&k=".$y."'>$r_uname</a></td><td>fullname:-$r_fname</td>";
      echo"<td> City:- $r_city </td> <td>Description:- $r_dscp </td><td>Rank:-$r_rank</td></tr>";
      $i=$i+1;
    }
    if($i==0){
    	echo" No User profiles with that keyword";
    }
   echo"</table></tr>";

    $stmt1=$searchsql->prepare("SELECT distinct(username),cor,description from register_page natural join artist_profile join artist_play_music natural join music_types
 where ausername=username and ausername=artist_name
 and (ausername like ? OR description like ? OR
cor like ? or category like ? or subcategory like ?)LIMIT 5 ");
  $stmt1->bind_param("sssss",$search_tag,$search_tag,$search_tag,$search_tag,$search_tag);
  $stmt1->execute();
  $stmt1->bind_result($r1_uname,$r1_city,$r1_dscp);
  echo"<hr style='height:1px;border:none;color:#333;background-color:#333;' />";
  echo"<tr><strong>Artists</strong>"."</br></tr>";
  echo"<tr><table>";
  $j=0;
  $r=1;
  while($stmt1->fetch())
    {
      if($r1_dscp==''){
      	$r1_dscp='Description not listed';
      }
      echo"<tr><td>Artist Name:<a href='artist_profile.php?pname=".$r1_uname."&r=".$r."'>$r1_uname</a></td>";
      echo"<td>   City:- $r1_city </td> <td>   Description:- $r1_dscp </td>
        </tr>";
       $j=$j+1;
    } 
    if($j==0){
    	echo" No Artist profiles with that keyword";
    }
    echo"</table></tr>"; 
    $stmt20=$searchsql->prepare("SELECT c,concert_date,venue_name,vcity,artist_name,k1.username from (SELECT distinct(concert_name)as c,
    	concert_date,venue_name,vcity,artist_name from upcoming_concerts natural join venue natural join music_types where Venue_name=venuename
and m_type=mid  and(concert_name like ? OR venue_name like ?  OR
artist_name like ?  OR vcity like ?  OR category like ? or subcategory like ? or concert_date like ? )
order by concert_date desc)as k left join
(SELECT username,concert_name from rsvp_info)as k1 on k.c=k1.concert_name and k1.username=?");
  $stmt20->bind_param("ssssssss",$search_tag,$search_tag,$search_tag,$search_tag,
  	$search_tag,$search_tag,$search_tag,$uname);
  $stmt20->execute();
  $stmt20->bind_result($r2_cname,$r2_date,$r2_vname,$r2_vcity,$r2_aname,$r2_uname);
  echo"<hr style='height:1px;border:none;color:#333;background-color:#333;' />";
  echo"<tr><strong>Concerts2</strong>"."</br></tr>";
  echo"<tr><table>";
  $k=0;
  $q=0;
  //$count_of=1;
  while($stmt20->fetch())
    { 
      if($r2_uname==''){
      	$count_of=0;
      }
      else{
      	$count_of=1;
      }
      echo"<tr><td>  Artist Name - <strong>'$r2_aname'</strong> </td><td>Concert name:$r2_cname  </td><td>  Concert Date:-$r2_date</td>";
      echo"<td>   Venue Name:- $r2_vname </td> <td> City:- $r2_vcity</td>";
      echo"<input type='hidden' id='$k' name='c_name.$k' value='$r2_cname' />";
      if($count_of == 0){
      echo "<td><input type='button' class='went' name='$k' value='RSVP' id='bttn_rsvp' /></td>";
     }
     else{
     	echo "<td><input type='button'class='went' name='$k' value='UNRSVP' id='bttn_rsvp'/></td>";
     	 }
     echo"</tr>";
      $k=$k+1;
    }
    echo "<input type='hidden' value=$k id='vl_k'/>";
    if($k==0)
    {
    	echo"No Concerts  with the keyword";
    }
    echo"</table></tr>";
    $stmt3=$searchsql->prepare("SELECT distinct(listname),list_created,category,subcategory,listmoderator  from list_details natural join recommended_list natural join music_types where listid=lid and
   mtype=mid and( listname like ? or listmoderator like ? or category like ? or subcategory like ?) order by list_created desc LIMIT 5 ");
  $stmt3->bind_param("ssss",$search_tag,$search_tag,$search_tag,$search_tag);
  $stmt3->execute();
  $stmt3->bind_result($r3_lname,$r3_lcreated,$r3_cat,$r3_scat,$r3_lmod);
  
  echo"<hr style='height:1px;border:none;color:#333;background-color:#333;' />";
  echo"<tr><strong>Lists</strong>"."</br></tr>";
  echo"<tr><table>";
  $f=0;
  while($stmt3->fetch())
    {
      echo"<tr><td>List name: <a href='addlist.php?lname=" . $r3_lname . "'>$r3_lname</a> </td><td>  List Created Date:-$r3_lcreated</td>";
      echo"<td>   Category:- $r3_cat </td> <td>   Sub-Category:- $r3_scat</td>
         <td>  Moderator-'$r3_lmod' </td></tr>";
     $f=$f+1;
    }
    if ($f==0){
    	echo"There are no lists with the keyword";
    }
    echo"</table></tr>";
    $stmt4=$searchsql->prepare("SELECT r_username,concertname,rating,review,review_date,
    	artist_name,concert_date,venue_name,vcity,category,subcategory 
from review_data natural join upcoming_concerts natural join music_types natural join venue
where venue_name=venuename and concertname=concert_name and m_type=mid and(concert_name like ?
	OR venue_name like ? OR artist_name like ? OR vcity like ? OR category like ? or subcategory like ? or r_username like ?)
    order by review_Date DEsc,concert_date Desc
LIMIT 10");
  $stmt4->bind_param("sssssss",$search_tag,$search_tag,$search_tag,$search_tag,$search_tag,$search_tag
  	 ,$search_tag);
  $stmt4->execute();
  $stmt4->bind_result($r4_uname,$r4_cname,$r4_rating,$r4_review,$r4_rdate,$r4_aname,$r4_cdate,
  $r4_vname,$r4_vcity,$r4_cat,$r4_scat);
  
  echo"<hr style='height:1px;border:none;color:#333;background-color:#333;' />";
  echo"<tr><strong>Reviews</strong>"."</br></tr>";
  echo"<tr><table>";
  $q=0;
  while($stmt4->fetch())
    { if($r4_aname==''){
    	$r4_aname='Linkin_park';
    }
      echo"<tr><td>$r4_uname gave rating of $r4_rating and a review like '$r4_review' </td><td>  
        Concert name is $r4_cname performed by $r4_aname on $r4_cdate</td>";
      echo"<td>  Concert held at $r4_vname in r4_vcity  </td> 
      <td>  Review was given on $r4_rdate </td>
      <td>   Genre of the concert was '$r4_scat' in $r4_cat category</td>
         </tr>";
     $q=$g+1;
    }
    if ($q==0){
    	echo"There are no reviews with the keyword";
    }
    echo"</table></tr>";
    echo"</table>";
?>
<html>
<head>
	 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script >
$(document).ready(function(){
  //EDIT BUTTON DESCRIPTION
	$("#go_home").click(function(){

  var a_u=$("input#a_u").val();
  var uname=$("input#errors").val();
  if(a_u==1){
  var url1 = "profile.php?uname=" + encodeURIComponent(uname);
   window.location.href = url1;
}
else{
    var url1 = "artist_home.php?uname=" + encodeURIComponent(uname);
   window.location.href = url1;
}
});
	$(".went").click(function(){
      var uname=$("input#errors").val();
      var condition=$(this).val();
      var k=$(this).attr('name');
      find='input#'+k;
      var cn_name = $(find).val();
       $.post('rsvp_add.php',{ru:condition,uname:uname,cn_name:cn_name},function(data){
               $(this).val()=data;
            });
     window.location.reload();
               
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

</head>
</html>



  	