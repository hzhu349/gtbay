
<?php
include 'config.php' ;
error_reporting(E_ALL);
ini_set('display_errors', 'on');
?>



<?php

$dblink = mysqli_init();
if (!$dblink) {
    die('mysqli_init failed');
}

if (!$dblink->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
    die('Setting MYSQLI_INIT_COMMAND failed');
}

if (!$dblink->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
    die('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed');
}
$gtbay = mysqli_real_connect(
   $dblink,
   $db_hostname,
   $db_username,
   $db_password,
   $db_name,
   $port);

if(!$gtbay) {
   die("Database connection failed: " . mysqli_error());
} else {
echo '';
}


?>

<html>
<head>
  <title>GTBay</title>
    <link rel="stylesheet" href="css/blueprint/screen.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="css/blueprint/print.css" type="text/css" media="print">
    <link rel="stylesheet" href="main.css" type="text/css">
</head>

<body style= "text-align: center;">
<img src="GTBay.gif" style="width:120px; height:100px;" >
</body>

<div class="container">
  	<div class="column span-24 last" style="text-align: center; margin-top: 20px; margin-bottom: 15px;">
  	</div>



