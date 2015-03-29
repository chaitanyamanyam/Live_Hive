<?php
//session_start();
ini_set('display_errors','off');
$db= new MYSQLi("127.0.0.1","root","gooners","Final_Project");
$uname='svarma9';
if (mysqli_connect_errno()) {
   printf("Connect failed: %s\n", mysqli_connect_error());}
else {
  $sql = "select username,lastlogin,description from user_profile where username='{$uname}'";
  $result = $db->query($sql);
  $sql1 = "select concertname, r_username, rating, review from review_data,
   upcoming_concerts, user_like_music, user_profile where user_profile.username ='{$uname}'
    and user_profile.username=user_like_music.username and user_like_music.mid=upcoming_concerts.m_type
     and upcoming_concerts.concert_name=review_data.concertname and review_date > lastlogin order by concertname";
  $result1 = $db->query($sql1);
  $sql2 = "select concertname, r_username, rating, review from review_data, user_profile,  
  upcoming_concerts, user_like_artist where user_profile.username ='{$uname}' and user_profile.
  username=user_like_artist.username and user_like_artist.artistname=upcoming_concerts.artist_name 
  and upcoming_concerts.concert_name=review_data.concertname and review_date > lastlogin order by concertname";
  $result2 = $db->query($sql2);
   }
//echo"user profile".$uname;?>
<html>
<head>

<h1 align="center">Welcome <?php echo $uname;?></h1>
</head>
<body>
  <p><?php
    // echo"<table style='width:100%'>";
      while($row=$result->fetch_array())
{?>


  <p><?php echo 'user name: '.$row["username"];?></p>
  <p><?php echo 'was previously seen at: '.$row["lastlogin"];?></p>
  <p><?php echo 'description: '.$row["description"];?></p>
 <?php
}
?>
<p><?php
  echo '<b>concerts of '.$uname."'s favourite music type</b>";
   echo"<table style='width:100%'>";
 while($row=$result1->fetch_array())
{?>
  <col width="10">
  <col width="10">
  <col width="10">
  <col width="10">
  <tr>
  <td><?php echo $row["concertname"];?></td>
  <td><?php echo $row["r_username"];?></td>
  <td><?php echo $row["rating"];?></td> 
  <td><?php echo $row["review"];?></td>
 <?php
}
  ?></table></p>
  <p><?php
   echo '<b>concerts of '.$uname."'s favourite artists</b>";
   echo"<table style='width:100%'>";
 while($row=$result2->fetch_array())
{?>
  <col width="10">
  <col width="10">
  <col width="10">
  <col width="10">
  <tr>
  <td><?php echo $row["concertname"];?></td>
  <td><?php echo $row["r_username"];?></td>
  <td><?php echo $row["rating"];?></td> 
  <td><?php echo $row["review"];?></td>
 <?php
}
  ?>
  </table></p>
  <?php echo "<a href='user_recommends.php? uname=$uname'\>".$uname."'s recommendations</a>".'<br>';
  ?>



  <?php echo "<a href=\'create_list.php? uname=$uname\'>create new list</a>";?>  
  <?php echo "<a href=\'hci\ishaan_add_list.php? uname=$uname\'>add to existing list</a>";?>

<?php echo '<form method="post" action="logout.php ?uname=$uname>
    <button type="submit">Logout</button>
</form>'?>
</body>
</html>