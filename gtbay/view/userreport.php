<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<?php

include 'config.php' ;


$query = "SELECT *
		  FROM user_report
		  ORDER BY number_listed DESC";


?>

<html>
    <head>
        <title>
                    User Report
        </title>
                <h1 class="test-results-header">
                      User Report

                </h1>
            </head>
        </html>

<div class="span-24 last">
<table>
	<tr>
		<td>Username</td>
		<td>Listed</td>
		<td>Sold</td>
		<td>Purchased</td>
		<td>Rated</td>
	</tr>
<?php if ($result = mysqli_query($gtbay,$query)) {
	  while ($row = mysqli_fetch_assoc($result)) { ?>
	<tr>
		<td><?php echo $row['username'];?></td>
		<td><?php echo $row['number_listed'];?></td>
		<td><?php echo $row['number_sold'];?></td>
		<td><?php echo $row['number_purchased'];?></td>
		<td><?php echo $row['number_rated'];?></td>
	</tr>
	<?php
		}
	  }
	?>
</table>
</div>

<div class="column span-24 last">
				<input type="button" name="Back" value="Back" class="btn btn-primary" onclick="window.location.href='index.php?action=menu'"/>
			</div>
