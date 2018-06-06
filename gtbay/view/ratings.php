<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<?php

include 'config.php' ;


// session_start();

	 if (isset($_GET['id'])) {

	   $id=$_GET['id'];

	 } else {

	   $id = "";

	 }

	 if (isset($_SESSION['username'])) {

	   $username=$_SESSION['username'];

	 } else {

	   $username = "";

	 }

//$username 		= $_SESSION['username'];

// Check for form submission
if (isset($_POST['rate'])) {
	$myrating = $_POST['myrating'];
	$comments = $_POST['comments'];

	//echo $username;
	//echo $id;

	$sql = "INSERT INTO ratings (timestamp, user_username, item_id, star_points, comment)
			VALUES (NOW(), '$username', $id, $myrating, '$comments')";

	mysqli_query($gtbay,$sql);


	if (mysqli_error($dblink)) {
		echo mysqli_error($dblink);
	} else {
		echo "Rated item successfully!";
	}
} else if (isset($_GET['deleterating'])) {
	$timestamp = $_GET['deleterating'];

	$sql = "DELETE FROM ratings WHERE user_username = '$username' AND item_id = $id AND timestamp = '$timestamp'";
	$del_history =1;

	mysqli_query($gtbay,$sql);


	if (mysqli_error($dblink)) {
		echo mysqli_error($dblink);
	} else if (mysqli_affected_rows($dblink) == 0) {
		echo "No rating with that timestamp/username/item_id combo found.  Nothing deleted.";
	} else {
		echo "Deleted rating successfully!";
	}
}



$query ="SELECT DISTINCT 	id,
			name,
			description,
			category_name,
			item_condition,
			returnable,
			get_it_now,
			actual_end_date,
			avg(star_points) AS avg_rating
FROM 			items left join ratings on (items.id = ratings.item_id)
WHERE 		id = $id;";

$result = mysqli_query($gtbay, $query);

$item = mysqli_fetch_assoc($result);

$query = "SELECT * FROM ratings WHERE item_id = $id;";

$result = mysqli_query($gtbay, $query);



?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<div class="span-12 append-6 prepend-6 last" style="margin-bottom: 15px; margin-left: 5px;">
	<table height ="2em" width = "4em" padding ="2em">

	<div style="span-12 last">


	</div>
	<div class="span-3">
		<tr>
			<td> <h3>Item ID</h3></td>
	<td> 	<h3>Item Name</h3></td>
	<td> <h3>	Average Rating</h3></td>
	</tr>
	</div>
	<div class="span-9 last" style="font-weight: bold;">
			<tr>
		<td> <h4>	<?= $item['id'];?><br/></h4></td>
			<td> <h4><?= $item['name'];?><br/></h4></td>
	 		<td><h4> <?= $item['avg_rating'] ? $item['avg_rating'] : "---";?><h4></td>
	</div>
	</table>
</div>

<?php
while ($rating = mysqli_fetch_assoc($result)) {
	//echo  $rating['user_username'];
?>
<div class="span-12 append-6 prepend-6 last">
	<div class="span-12 last" style="border-style: solid; border-width: 1px; margin-bottom: 5px; margin-top: 5px; padding: 5px;">
		<div class="span-12 last">
			<?php
			if ($rating['user_username'] == $username) {
				echo "<a href='index.php?action=ratings&id=$id&deleterating=" . $rating['timestamp'] . "'>Delete My Rating</a><br/>";
			}
			?>
		</div>
		<div class="span-3">
			Rated By:<br/>
			Date:<br/>
      Rated Star:<br/><br/><br/>
			Comments:
		</div>

		<div class="span-6" style="font-weight: bold;">
			<?= $rating['user_username'];?><br/>
			<?= $rating['timestamp'];?><br/>

		</div>


		<div class="span-3 last">
	<?php
		for ($i = 0; $i < 5; $i++)
		{
			if ($i<$rating['star_points'])
	{ ?> <!-- close php code -->
					<span class="fa fa-star checked" style = "color:orange"></span> <!-- this is the html code -->
	<?php }
			else
				{?> <!-- close php code -->
					<span class = "fa fa-star"></span> <!-- input html code -->
	<?php }
		}
	?>
		</div>

<br/><br/>

		<div class="star-ratings-sprite"><span style="width:52%" class="star-ratings-sprite-rating"></span>

			<div class="span-6" style="font-weight: bold;">
				<br/><br/>

				 <?= $rating['comment'];?>

			</div>
		</div>
			<!--
			for ($i = 0; $i < 5; $i++) {
				print "<img src='images/" . ($i >= $rating['star_points'] ? "no" : "") . "star.png'/>";
			}
    -->
	</div>




</div>
<?php
}
?>
<?php
$query ="SELECT DISTINCT 	id,
			name,
			description,
			category_name,
			item_condition,
			returnable,
			get_it_now,
			actual_end_date,
			avg(star_points) AS avg_rating
FROM 			items left join ratings on (items.id = ratings.item_id)
WHERE 		id = $id;";

$result = mysqli_query($gtbay, $query);

$item = mysqli_fetch_assoc($result);

$query = "SELECT * FROM ratings WHERE item_id = $id;";
$isExisted = 0;
$result = mysqli_query($gtbay, $query);
while ($rating = mysqli_fetch_assoc($result)) {
	if($rating['user_username'] == $username) {
		$isExisted = 1;
    }
}
?>




<form method="POST" action="index.php?action=ratings&id=<?= $id ?>">
<div class="span-12 append-6 prepend-6 last" style="margin-top: 20px;">
	<div class="span-3">
	
		<label for="myrating">My Rating</label>
	</div>
	<div class="span-9 last">
		<select name="myrating" id="myrating">
			<option value=0>0 Stars</option>
			<option value=1>1 Star</option>
			<option value=2>2 Stars</option>
			<option value=3>3 Stars</option>
			<option value=4>4 Stars</option>
			<option value=5>5 Stars</option>
		</select>
	</div>
	<div class="span-3">
		<label for="comments">Comments</label>
	</div>
	<div class="span-9 last">
		<textarea id="comments" name="comments" style="width: 100%; height: 75px;"></textarea>
	</div>
	<div class="span-4 prepend-8 last" style="position: relative;">
		<div style="right: 0px; position: absolute;">
			<br>

      <button type="button"  class="btn btn-danger" onclick="window.location.href='index.php?action=viewitem&id=<?= $id; ?>'">Cancel</button>

  <?php if($isExisted != 1 ) {
    ?>
		<button type="submit" name="rate"   class="btn btn-primary" value="rate">Submit</button>      <?php } ?>
		</div>
	</div>

</div>
</form>
