<?php
//session_start();
ini_set('display_errors','off');
$db= new MYSQLi('localhost','livehive','gooners','Final_Project');
$uname='svarma9';
echo"user profile ".$uname;
if (mysqli_connect_errno()) {
   printf("Connect failed: %s\n", mysqli_connect_error());}
else {
  $sql = "select * from upcoming_concerts where uc_username='{$uname}'";
  $result = $db->query($sql);
   }?>

<html>
<head>
<h1 align="center">Welcome <?php echo $uname;?></h1>
</head>
<body>
  <p><?php
      while($row=$result->fetch_array())
{?>
<table border="1" style="width:100%">
	<tr>
  <td><?php echo $row["uc_username"];?></td>
  <td><?php echo $row["concert_name"];?></td>
  <td><?php echo $row["concert_date"];?></td>
  <td><?php echo $row["m_type"];?></td>
  <td><?php echo $row["venue_name"];?></td>
  <td><?php echo $row["ticket_price"];?></td>
  <td><?php echo $row["availability"];?></td>
  <td><?php echo $row["event_posted"];?></td>
  	</tr><?php
}
  ?></p>
  <!--<?php echo "<a href=\"concerts.php? uname=$uname\">Concerts of ".$uname."</a>";?>    -->
</body>
</html>