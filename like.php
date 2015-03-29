<?php
ini_set('display_errors','off');
$uname=$_POST['uname'];
$ouser=$_POST['ouser'];
$er=$_POST['feb'];
   $like=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();

}
if($er==0){
if($stmt2=$like->prepare("INSERT INTO follow_Details values(?,?,default)")){
  $stmt2->bind_param("ss",$uname,$ouser);
  $stmt2->execute();
  echo "Now following";
}
}
else{
if($stmt3=$like->prepare("Delete from follow_Details where followee=? and follower=?")){
  $stmt3->bind_param("ss",$uname,$ouser);
  $stmt3->execute();
  echo "Now NOT following";
}

}


?>