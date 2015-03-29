<?php
ini_set('display_errors','off');
$kladd_info= new MYSQLi('127.0.0.1","root","gooners","Final_Project');
if($_POST)
{ 
$uname=trim($_POST['uname']);

$kladd_info=new mysqli("127.0.0.1","root","gooners","Final_Project");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if($stmt=$kladd_info->prepare("Insert into artist_profile values(?,'Nothing as sor','Edit',6,default)"))
{
	$stmt->bind_param("s",$uname);
	$stmt->execute();
  
}

}
?>