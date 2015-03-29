<?php
include('dbconn.php');
if($_POST)
{
$add_combined=$_POST['com'];	
$com_data=explode ("-",$add_combined);
 $ac_uname=trim($com_data[0]);
 $ac_cn= trim($com_data[1]);
 $ac_aname=trim($com_data[2]);
  $ac_vcity= trim($com_data[3]);
  $ac_venue=trim($com_data[4]);
  $ac_cat=trim($com_data[5]);
  $ac_scat=trim($com_data[6]);
  $ac_price=trim($com_data[7]);
  $ac_availability=trim($com_data[8]);
  $ac_date=$com_data[9];
  $ac_time=$com_data[10];
  $ac_cdate=$ac_date." ".$ac_time;
  mysql_connect("127.0.0.1", "root", "gooners") or die(mysql_error());
  mysql_select_db("Final_Project") or die(mysql_error());
  //$ccqq=new mysqli("127.0.0.1","root","gooners","Final_Project");
   //if (mysqli_connect_errno()) {
    //printf("Connect failed: %s\n", mysqli_connect_error());
    //exit();
   //}
 if(!$result=mysql_query("SELECT mid from music_types where category='$ac_cat' and subcategory='$ac_scat' "))
{
	
  echo $ccqq->errno;
 
  }
else{ 
  while($row=mysql_fetch_array($result))
  {
    $ac_mid=$row['mid'];
  }

}

  $result1= mysql_query("CALL insert_concert('$ac_uname','$ac_cn','$ac_cdate', '$ac_venue',
       '$ac_price','$ac_availability','$ac_mid','$ac_aname')" ) or die(mysql_error());  
   $message="Concert Added";
   echo $message;


}

?>
