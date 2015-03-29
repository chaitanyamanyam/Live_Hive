<?
include('dbconn.php');
if($_POST)
{
$password=$_POST['pwd'];
$uname=$_POST['uname'];
$pwdchangesql=new mysqli("127.0.0.1","root","gooners","Final_Project");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if($stmt=$pwdchangesql->prepare("UPDATE register_page set password=?  where username=?"))
{
	$stmt->bind_param("ss",$password,$uname);
	$stmt->execute();
  
}

}


?>