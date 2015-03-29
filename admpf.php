<?php
$uname=$_POST['uname'];
$mid=$_POST['mid'];
$k=$_POST['k'];
$addmpf=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }
if($k==1){
   if($stmt1=$addmpf->prepare("INSERT INTO user_like_music values(?,?)")){
 $stmt1->bind_param("si",$uname,$mid);
  $stmt1->execute();
  echo"Genre Added to Interests";
}
else{
	echo"try adding it again";
}
}
else{
$stmt3=$addmpf->prepare("Delete from user_like_music where username=? and mid=?");
 $stmt3->bind_param("si",$uname,$mid);
  $stmt3->execute();
  echo"Genre Deleted from  Interests";
}
?>