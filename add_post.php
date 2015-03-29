<?php
include('dbconn.php');
if($_POST)
{
$content=trim($_POST['content']);
$uname=$_POST['uname'];
$addpostmysql=new mysqli("127.0.0.1","root","gooners","Final_Project");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if($content ===''){
	echo"Post is Empty";
}
else{
if($stmt=$addpostmysql->prepare("Insert into post_data values(?,?,default)"))
{
	$stmt->bind_param("ss",$uname,$content);
	$stmt->execute();
	echo"Added Post";
  
}
	
}
}

?>