<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

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

<html>
<title>NEW USER REGISTRATION</title>
<h1>NEW USER REGISTRATION</h1>


<?php

if (isset($_POST['register'])) {


	$firstname 	= $_POST['firstname'];
	$lastname 	= $_POST['lastname'];
	$username 	= $_POST['username'];
	$password 	= $_POST['password'];
	$confirm	= $_POST['confpassword'];

	$error_free = 1;

	if (!($firstname && $lastname && $username && $password && $confirm))
	{

    ?>

    <div class="alert">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
You must fill in all fields!
</div>
    <?php

		$error_free = 0;

	}

	if ($password != $confirm)
	{
    ?>

    <div class="alert">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
Password confirmation doesn't match password!
</div>
    <?php

		$error_free = 0;

	}

	if ($error_free==1)


	{
		$query = "INSERT INTO Users Values  (\"$username\",\"$password\",\"$firstname\",\"$lastname\");";
		$result =mysqli_query($gtbay,$query)  ;
    if(!$result){
      ?>

      <div class="alert ">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  Username or Password already exist!
  </div>
      <?php
    }

		elseif ($result){

      ?>

      <div class=" alert success">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  Regiser successfully!
  </div>
      <?php

		}

}
}

?>



	<div class="column span-8 append-8 prepend-8 last">
	<form action="index.php?action=register" method="post">

		<div class="column span-4">
			<label for="firstname">First Name</label>
		</div>
		<div class="column span-4 last">
			<input type="text" name="firstname" id="firstname"/>
		</div>

		<div class="column span-4">
			<label for="lastname">Last Name</label>
		</div>
		<div class="column span-4 last">
			<input type="text" name="lastname" id="lastname"/>
		</div>

		<div class="column span-4">
			<label for="username">Username</label>
		</div>
		<div class="column span-4 last">
			<input type="text" name="username" id="username"/>
		</div>

		<div class="column span-4">
			<label for="password">Password</label>
		</div>
		<div class="column span-4 last">
			<input type="password" name="password" id="password"/>
		</div>

		<div class="column span-4">
			<label for="confpassword">Confirm Password</label>
		</div>
		<div class="column span-4 last">
			<input type="password" name="confpassword" id="confpassword"/>
		</div>

		<div class="column span-4 last">
			<button type="button" class="btn btn-danger"  onclick="window.location.href='index.php'">Cancel</button>
			<button type="submit" name="register"  class="btn btn-primary" value="register">Register</button>
		</div>
	</form>
</div>
