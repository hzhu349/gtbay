<?php

include 'config.php' ;
?>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>




<?php


if (isset($_POST['Submit']) && !empty($_POST['username']) && !empty($_POST['password'])) {

    $password    =  $_POST['password'];
    $username    =  $_POST['username'];

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

    $admin_query = "SELECT * FROM Admin WHERE username = '$username'";

    $result = mysqli_query($gtbay,$query);

    $admin_reuslt = mysqli_query($gtbay,$admin_query);
    $user_arr = mysqli_fetch_assoc($result);

    $admin_arr = mysqli_fetch_assoc($admin_reuslt);

    if (mysqli_num_rows($admin_reuslt) > 0) {

        $_SESSION['position'] = $admin_arr['position'];

      }

      if (mysqli_num_rows($result) > 0 ) {
        $_SESSION['username'] = $username;
        header ('location: http://localhost/demo/gtbay/index.php?action=menu');
        exit();
      }
      else {
          ?>

        <div class="alert">
          <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>

    Wrong username or password!
    </div>
        <?php

      }
    }
    elseif (isset($_POST['Submit']) && empty($_POST['username']) && empty($_POST['password'])){

      ?>

        <div class="alert">
          <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    Please provide both of username and password!
    </div>
        <?php

    }
?>


<!--https://searchcode.com/file/65575543/view/login.php-->

<div class="column span-8 append-8 prepend-8 last">
<div style="margin-bottom: 10px; text-align: center; background-color: #FFAAAA;"></div>
  		<form id="form_id" name="form_name" action="index.php" method="post" style="text-align: center;">


      <div class="column span-4">
			<label for="first">Username</label>
			</div>

			<div class="column span-4 last">
				<input type="text" name="username" id="username" />
			</div>

			<div class="column span-4">
				<label for="first">Password</label>
			</div>

			<div class="column span-4 last">
				<input type="password" name="password" id="password"/>
			</div>
    		<div class="column span-4 last">
        <input type="button" name="Register" value="Register" class="btn btn-danger" onclick="window.location.href='index.php?action=register'"/>
        <input type="submit" name="Submit" class="btn btn-primary" value="Log in"/>
   	</div>

      </form>
   </div>
