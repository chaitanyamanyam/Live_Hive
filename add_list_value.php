<?php
SESSION_Start();
$mod=$_SESSION["pname"];

echo $mod;


ini_set('display_errors','off');
if($_POST){
  echo $mod;

   $mysql=new mysqli("127.0.0.1","root","gooners","Final_Project");
   if (mysqli_connect_errno()) {
   printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
  
  //$mod=$_GET['uname'];
  echo $mod;
  //$listname=$_POST['listname'];
  //$listid=$_POST['listid'];

  $mtype=$_POST['mtype'];
  
echo $mod;
  if($mod!='' && $listname && $listid && $mtype!='')
  { 
  
    echo $mod.$listname.$listid.$mtype;
echo"hello";
        $ins=$mysql->prepare("INSERT INTO list_details (listid,listname,listmoderator,mtype,list_created)
           values (?,?,?,?,CURRENT_TIMESTAMP)");
        $ins->bind_param("issi",$listid,$listname,$mod,$mtype);
        $ins->execute();
        $ins->close();  

      $destination_url="user_profile.php? uname=$mod ";
          header("Location:$destination_url");
          exit();
              //echo "< a href=login.php></a>";
         exit();
      }
     
 // $sel = "select mid from music_types order by mid";
  //$result = $mysql->query($sel);  
  
  
}?>



<html>
<head>

<body> <h2 align="center"><b>List Details</h2>
Fill the details below</b></body>
<form action="create_list.php" method="post">
 <p>List Name         <input type="text" name="listname"/></p>
 <p>List ID           <input type="text" name="listid" /></p> 
 <p>Type of Music     <select name="mtype">
  <?php 
   $mysql1=new mysqli("localhost","livehive","gooners","Final_Project");
  $sel = "select mid, subcategory from music_types";
    $result = $mysql1->query($sel); 
    while($row=$result->fetch_array())
      {
        echo '<option value='.$row["mid"].'>'.$row["subcategory"].'</option>';
      }?>
</select></p>
 <p><input type="submit" name="submit" values="submit"/></p>

</form>
</head>
</html> 