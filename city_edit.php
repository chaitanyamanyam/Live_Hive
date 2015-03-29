<?php
include('dbconn.php');
if($_POST)
{
$city=trim($_POST['city']);
$uname=$_POST['uname'];
$editcitysql=new mysqli("127.0.0.1","root","gooners","Final_Project");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if($stmt=$editcitysql->prepare("Update register_page set cor= ? where username=?"))
{
	$stmt->bind_param("ss",$city,$uname);
	$stmt->execute();
  
}
if($stmt1=$editcitysql->prepare("select cor from register_page where username=?"))
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
