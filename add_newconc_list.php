<?php
$lname=$_POST['lname'];
$cname=$_POST['cname'];
$num=$_POST['num'];
$addnewconclist=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }
   if($stmt=$addnewconclist->prepare("
insert into recommended_list values(?,?)")){
  
  $stmt->bind_param("is",$lname,$cname);
  $stmt->execute();
  echo"Concert  Added to List";
}
else{
	echo "not added";
}

?>
