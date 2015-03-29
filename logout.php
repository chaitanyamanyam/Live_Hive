<?php
ini_set('display_errors','off');
$db= new MYSQLi('127.0.0.1","root","gooners","Final_Project');
$uname=$_POST['uname'];
$at=$_POST['ut'];
$logout_info=new mysqli("127.0.0.1","root","gooners","Final_Project");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if($at!=1){
if($stmt=$logout_info->prepare("Update user_profile set lastlogin= CURRENT_TIMESTAMP where username=?"))
{
	$stmt->bind_param("s",$uname);
	$stmt->execute();
	echo"Logged Out Successfully";
  
}
}
else{
	if($stmt1=$logout_info->prepare("Update artist_profile set lastlogin= CURRENT_TIMESTAMP where ausername=?"))
{
	$stmt1->bind_param("s",$uname);
	$stmt1->execute();
	
	echo"Logged Out Successfully";
  
}
}

?>
