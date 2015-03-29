<?php
session_start();

ini_set('display_errors','off');
if($_POST){
   $logsql=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) 
   {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();

}
   $uname=$_POST['uname'];
   $pwd=$_POST['pwd'];
   if($uname && $pwd)
   {
  $stmt=$logsql->prepare("SELECT count(*) from register_page where username= ?");
  $stmt->bind_param("s",$uname);
  $stmt->execute();
  $stmt->bind_result($returned);
  while($stmt->fetch())
    {
      $k=$returned;
      //echo $k;
    }
    if ($k==1)
    {
      $in1=$logsql->prepare("SELECT ptype from register_page where username=? 
        and password =?");
      $in1->bind_param("ss",$uname,$pwd);
      $in1->execute();
      $in1->bind_result($result);
      while($in1->fetch()){
        $uora=$result;
      }
    	$in=$logsql->prepare("SELECT count(*) from register_page where username=? 
    		and password =?");
    	$in->bind_param("ss",$uname,$pwd);
    	$in->execute();
    	$in->bind_result($check);
    	while($in->fetch()){
    		if ($check ==1)
        {
    			
          if($uora=='user')
          {
            $_SESSION["uname"]=$uname;
    			$destination_url="profile.php? uname=$uname ";
    			header("Location:$destination_url");
    			exit();
    			}
          else
          {
            $_SESSION["artist"]=$uname;
            $destination_url1="artist_home.php? uname=$uname ";
          header("Location:$destination_url1");
          exit();

          }
    		}
    		else{
    			echo"Wrong combination of username and password";
    		}
    		}
    	}
    	else{
          echo"There is no user with that username.Please correct it or 
              register into the system";
    	}
    }

 }

?>
<html>
<head>
<body background="wallpaper.jpg">
  <div style="text-align:center">
<h1 align="center">Welcome to Live Hive</h1>
<form action="login.php" method="post">
  <table align='center'>
<tr><td>Username </td><td><input type="text" name="uname" value="<?php echo htmlspecialchars($uname);?>"></td><br>
<tr><td>Password </td><td> <input type="password" name="pwd" value="<?php echo htmlspecialchars($pwd);?>"><br></td>
<a href='index.php'> Register ??</a>  
</table>
<input type='submit' name ='login-submit' value='submit'>
</div>


</body>
</form>
</head>
</html>