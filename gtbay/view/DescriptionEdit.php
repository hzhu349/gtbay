<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<?php
include 'config.php' ;


if (isset($_GET['id'])) {

	   $id=$_GET['id'];

	 } else {

	   $id = "";

	 }

$query ="SELECT DISTINCT 	id,
			name,
			description,
			category_name,
			item_condition,
			returnable,
			get_it_now,
			actual_end_date,
			max(amount) AS high_bid
FROM 			items left join bids on (items.id = bids.item_id)
WHERE 		id = $id;";

$result = mysqli_query($gtbay,$query);

$row = mysqli_fetch_assoc($result);




if(isset($_POST['submit'])){


	$editDes="update items set description=\"" . $_POST['comments'] . "\" where id=$id;";
	mysqli_query($gtbay,$editDes);

	require_once 'itemforsale.php';
 }
else {

?>
<form method="post" action="">
  <h2>Item <?= $id ?> (<?= $row['name']?>) Description</h2>



 <textarea name="comments" cols="1000" rows="50">
<?= $row['description'];?>
</textarea><br>

<input name="submit" class="btn btn-primary" style="width:80px;height:30px;" type="submit" onclick="window.location.href='itemforsale.php'" value="Submit" />

<button type="button" class="btn btn-danger" style="width:80px;height:30px;" onclick="window.location.href='index.php?action=viewitem&id=<?= $id ?>'">Cancel</button>
</form>

<?php
 }
?>
