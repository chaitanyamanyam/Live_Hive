<?php
if(isset($_POST["name"] )== true && empty($_POST['name'])==false){
	ini_set('display_errors','off');
 $unique_db = pg_connect(getenv('DATABASE_URL')) or die("Unable to connect to postgre");
 //$db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$unique_db){
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
   }

	$insert_size=$_POST['name'];
  	$ucheck="SELECT count(*) from register_page where username= '".$uname."'"; 
   	$returned = pg_query($unique_db, $ucheck);
        if(!$returned)
        	{
        	echo pg_last_error($db);
    	   	}  
   
	echo ($returned==0)?'Username Available':'Username taken';
   }
?>