<?php
include('dbconn.php');
if($_POST)
{
$category=$_POST['cat'];
$subcategory=$_POST['subcat'];
$uname=$_POST['uname'];
$dislikesql=new mysqli("127.0.0.1","root","gooners","Final_Project");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if($stmt=$dislikesql->prepare("DELETE from user_like_music using user_like_music natural 
	join music_types where username=? and category=? and subcategory=?"))
{
	$stmt->bind_param("sss",$uname,$category,$subcategory);
	$stmt->execute();
  
}
if($stmt1=$dislikesql->prepare("SELECT category,subcategory from user_like_music natural join music_types 
      natural join register_page where username=?"))
{
	$stmt1->bind_param("s",$uname);
	$stmt1->execute();
	$stmt1->bind_result($category,$subcategory);
    
}

}
?>
