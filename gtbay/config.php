<?php
$db_username 	= "root";
$db_password 	= "root";
$db_name 		= "gtbay";
$db_hostname	= "127.0.0.1";
$port = 3308;
$debug	= false;
$gtbay = mysqli_connect(
   $db_hostname,
   $db_username,
   $db_password,
   $db_name,
   $port) or die( "Unable to connect");

?>
