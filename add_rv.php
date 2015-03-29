<?php
 $addrv=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }

$uname=$_POST['uname'];
$att=$_POST['att'];
$cname=$_POST['cname'];
$rat=$_POST['rat'];
$review=$_POST['rv'];
 if( $stmt=$addrv->prepare("insert into review_data values(?,?,?,?,default,0,0,?)")){
  $stmt->bind_param("ssiss",$uname,$cname,$rat,$review,$att);
  $stmt->execute();
  echo"Review Added";
 }
 else{
 	echo"Not Added";
 }

?>