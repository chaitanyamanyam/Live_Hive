<?php
session_start();
ini_set('display_errors','off');
$db= new MYSQLi('localhost','livehive','gooners','Final_Project');
$uname=$_GET['uname'];
if (mysqli_connect_errno()) {
   printf("Connect failed: %s\n", mysqli_connect_error());}
else {
  $sql = "select username,lastlogin,description from user_profile where username='{$uname}'";
  $result = $db->query($sql);
   }
echo"user profile".$uname;?>
<html>
<head>
<h1 align="center">Welcome <?php echo $uname;?></h1>
</head>
<body>
  <p><?php
      while($row=$result->fetch_array())
{

  echo $row["username"];
  echo $row["lastlogin"];
  echo $row["description"];
}
  ?></p>
</body>
</html>