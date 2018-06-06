<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<html>
    <head>
        <title>
				Search Items        </title>
				<h1 class="test-results-header">
				Item Search

				</h1>
			</head>
		</html>

<?php
include 'config.php' ;

$query = "SELECT *
		  FROM categories;";
$result = mysqli_query($gtbay,$query);
?>


<div class="column span-12 append-4 prepend-4 last">
	<form action="index.php?action=searchresults" method="post">

		<div class="column span-8">
			<label for="keyword">Keyword:</label>

			<input type="text" name="keyword" id="keyword"/>
		</div>

		<div class="column span-8">
			<label for="category">Category:</label>

			<select name="category" id="category">
				<option value=""></option>
				<?php
					while ($row = mysqli_fetch_array($result)) {
				?>
				<option value="<?php echo $row['name'];?>" > <?php echo $row['name'];?> </option>
				<?php
					}
				?>
			</select>
		</div>

		<div class="column span-8">
			<label for="minprice">Minimum Price $:</label>

	 		<input type="text" name="minprice" id="minprice"/>
		</div>

		<div class="column span-8">
			<label for="maxprice">Maximum Price $:</label>

	 		<input type="text" name="maxprice" id="maxprice"/>
		</div>

		<div class="column span-8">
			<label for="condition">Condition at least:</label>

	 		<select name="condition" id="condition">
				<option value=0></option>
				<option value=1>Poor</option>
				<option value=2>Fair</option>
				<option value=3>Good</option>
				<option value=4>Very Good</option>
				<option value=5>New</option>
			</select>
		</div>

		<div class="column span-8 prepend-4 last">
			<br><br><br>

			<button type="submit" name="search" value="search" class="btn btn-primary">Search</button>
			<input type="button" name="Cancel" class="btn btn-danger" value="Cancel" onclick="window.location.href='index.php?action=menu'"/>
		</div>
	</form>
</div>
