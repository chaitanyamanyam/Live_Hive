<?php
ini_set('display_errors','off');
if($_POST)
{
$uname=$_POST['uname'];
$logout_info1=new mysqli("127.0.0.1","root","gooners","Final_Project");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if($stmt=$logout_info1->prepare("Update artist_profile set lastlogin= CURRENT_TIMESTAMP where ausername=?"))
{
	$stmt->bind_param("s",$uname);
	$stmt->execute();
  
}

}
?>