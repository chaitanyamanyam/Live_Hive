<?php
session_start();
$uname=$_SESSION['uname'];
$nn=$_POST['uname'];
$gn=$_POST['genre'];
$num=$_POST['num'];
$addnewlist=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }
   if($nn!='' && $gn!='' && $num!=''){
   if($stmt=$addnewlist->prepare("INSERT into list_details values (?,?,?,default,?)")){
  
  $stmt->bind_param("issi",$num,$nn,$uname,$genre);
  $stmt->execute();
  echo"List Added";
  exit();
  }
  else{
  	echo"Enter all details properly";
  }
}
else{
	echo"Enter all details properly exactly";
}
?>
