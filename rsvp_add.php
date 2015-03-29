<?php
include('dbconn.php');
if($_POST)
{
	//svarma9RSVPGreen day
$conc_name=trim($_POST['cn_name']);
$uname=$_POST['uname'];
$k=$_POST['ru'];
$rsvpsql=new mysqli("127.0.0.1","root","gooners","Final_Project");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if($k=='RSVP'){
if($stmt=$rsvpsql->prepare("INSERT INTO rsvp_info values(?,?,default)"))
{
	$stmt->bind_param("ss",$uname,$conc_name);
	$stmt->execute();
	echo"RSVP";
	
  
}
}
else{
if($stmt1=$rsvpsql->prepare("delete from rsvp_info where username=? and concert_name=?"))
{
	$stmt1->bind_param("ss",$uname,$conc_name);
	$stmt1->execute();
	echo"UNRSVP";

	
	
}
}
}
?>

