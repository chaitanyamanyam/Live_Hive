
<?php
ob_start();
ini_set('display_errors', 'off');
error_reporting(E_ALL);

if($_POST){
   $mysql=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
	
	$uname=$_POST['uname'];
	$fname=$_POST['fullname'];
	$pwd=$_POST['pwd'];
	$yob=$_POST['yob'];
	$cor=$_POST['cor'];
	$ptype=$_POST['ptype'];
		$emailid=$_POST['emailid'];

	if($uname!='' && $fname && $pwd!='' && $yob && $cor!='' && $ptype!='' )
	{ 
  
  $stmt=$mysql->prepare("SELECT count(*) from register_page where username= ?");
  $stmt->bind_param("s",$uname);
  $stmt->execute();
  $stmt->bind_result($returned);
    while($stmt->fetch())
    {
      $k=$returned;
    }
    $stmt->close();
      if ($k==0)

      {
        $ins=$mysql->prepare("INSERT INTO register_page (username,fullname,YOB,emailid,COR,ptype,password)
           values (?,?,?,?,?,?,?)");
        $ins->bind_param("ssissss",$uname,$fname,$yob,$emailid,$cor,$ptype,$pwd);
        $ins->execute();
        $ins->close(); 

        echo"<body background='wallpaper3.jpg'> </body>";
        echo"<p align='center'style='color:white'><b>Account Created </br></b></p>";
        echo"<p align='center'style='color:white'><a href='login.php' align='center'> LOGIN PAGE</a></p>";
        exit();
      }
      else{

        echo "<p align='center'style='color:white'><b>Enter a new username </br>which is unique</b></p></br>";
      }
    
	}
	else{
		echo "<p align='center'style='color:white'><b>Enter data properly </b></p></br>";
	}
}

ob_end_flush();

?>


<html>
<head>
<body background='wallpaper3.jpg'>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script >   
    $(function() {
         $( "#calendar" ).datepicker();   
    });</script>
    <script> 
    $(document).ready(function(){
    	$("#uniquebt").click(function(){
    		var txt=$("input:text[name=uname]").val();
    	    //alert(txt);
    	    if($.trim(txt) != ''){
    	    	$.post('unique.php',{name:txt},function(data){
    	    		alert(data);
    	    	});
    	    }
    	});
    });
   
</script>

<body> 
 
  <div style="text-align:center;color: #FFFFFF"> <h2>Live Hive</h2>
<strong>Fill the details below</strong>
<br></br>
<form action="index.php" method="post" font color="red"> 
 <table align="center" style="color:#FFFFFF">
  <tr><td><p>Username      </td><td>  <input type="text" name="uname" id="uname"/> </td><td><input type='button' value='Unique' id="uniquebt" align/></p></td></tr>
 <tr><td><p>Full Name  </td><td>  <input type="text" name="fullname" onkeypress="return checkNum();"/></p></td></tr>
 <tr><td><p>Password   </td><td>  <input type="password" name="pwd" /></p> </td></tr>
 <tr><td><p>Year of Birth </td><td> <input type="date" name="yob" id="calendar"/></p></td></tr>
<tr><td><p>City of Residence</td><td> <input type="text" name="cor" onkeypress="return checkNum();"/></p> </td></tr>
 <tr><td><p>Email Id     </td><td>  <input type="text" name="emailid" onblur="validateEmail(this.value)"/></p> </td></tr>
<tr><td><input type="radio" name="ptype" value="user">User  </td><td><input type="radio" name="ptype" value="artist">Artist</td></tr>
 </table>
 <p><input type="submit" name="submit"/></p>
<a style='color:white'href='login.php'>Login Page</a>


</div>
 <script type="text/javascript">
function checkNum()
{
 
if ((event.keyCode > 64 && event.keyCode < 91) || (event.keyCode > 96 && event.keyCode < 123) || event.keyCode == 8)
   return true;
else{
	return false;
} 
}
function validateEmail(sEmail) {
  var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;

  if(!sEmail.match(reEmail)) {
    alert("Invalid email address");
    return false;
  }

  return true;}
</script>
</body>
</form>
</head>
</html>

