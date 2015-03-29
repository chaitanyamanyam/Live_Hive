<?php
SESSION_Start();
$mod=$_SESSION["pname"];

//echo $mod;

//echo $mod;


ini_set('display_errors','off');
  //echo $mod;
?>





<html>
<head>

<body> <h2 align="center"><b>List Details</h2>
Fill the details below</b></body>
<form action="add_list_value.php" method="GET" id ="list">
  <p>Type of Music     <select name="mtype" form="list">
 
<?php
   $mysql=new mysqli("localhost","livehive","gooners","Final_Project");
        $sql1="select listname, subcategory, mid from music_types, list_details where mtype = mid and listmoderator ='$mod'";
        $result = $mysql->query($sql1);
        while($row=$result->fetch_array())
          {
        echo '<option value='.$row["mid"].'>'.$row["listname"]."  ".$row["subcategory"].'</option>';
     }

?></select></p>
 <p><input type="submit"/></p>
<?php  ?>
</form>
</head>
</html> 