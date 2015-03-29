<?php
include('dbconn.php');
if($_POST)
{
$fullname=trim($_POST['fname']);
$uname=$_POST['uname'];
$editfnamesql=new mysqli("127.0.0.1","root","gooners","Final_Project");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if($stmt=$editfnamesql->prepare("Update register_page set fullname= ? where username=?"))
{
	$stmt->bind_param("ss",$fullname,$uname);
	$stmt->execute();
  
}
if($stmt1=$editfnamesql->prepare("select fullname from register_page where username=?"))
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