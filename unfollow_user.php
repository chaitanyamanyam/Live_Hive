<?
include('dbconn.php');
if($_POST)
{
$follower=$_POST['flw'];
$uname=$_POST['uname'];
$unfollowsql=new mysqli("127.0.0.1","root","gooners","Final_Project");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if($stmt=$unfollowsql->prepare("DELETE from follow_details  where follower=? and followee=?
"))
{
	$stmt->bind_param("ss",$follower,$uname);
	$stmt->execute();
  
}

}

?>