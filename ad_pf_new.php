<?php
ini_set('display_errors','on');
$uname=trim($_POST['uname']);
$sa=$_POST['sa'];
$ladd_info=new mysqli("127.0.0.1","root","gooners","Final_Project");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if($sa==1){
if($stmt=$ladd_info->prepare("Insert into user_profile values(?,default,'Edit',6)"))
{
	$stmt->bind_param("s",$uname);
	$stmt->execute();

  
}
else{

}
}
else{
	if($stmt1=$ladd_info->prepare("Insert into artist_profile values(?,'Waiting for confirmation','Edit',current_timestamp)"))
{
	$stmt1->bind_param("s",$uname);
	$stmt1->execute();

}
else{

}

}


?>
