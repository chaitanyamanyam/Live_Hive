<?php
include('dbconn.php');
if($_POST)
{
$description=trim($_POST['content']);
$uname=$_POST['uname'];
$editsql=new mysqli("127.0.0.1","root","gooners","Final_Project");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if($stmt=$editsql->prepare("Update user_profile set description= ? where username=?"))
{
	$stmt->bind_param("ss",$description,$uname);
	$stmt->execute();
  
}
if($stmt1=$editsql->prepare("select description from user_profile where username=?"))
{
	$stmt1->bind_param("s",$uname);
	$stmt1->execute();
	$stmt1->bind_result($returned);
    while ($stmt1->fetch()){
    	echo $returned;
    }
}
}
?>