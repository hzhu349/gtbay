<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<html>
    <head>
        <title>
                    Category  Report
        </title>
                <h1 class="test-results-header">
                      Category  Report

                </h1>
            </head>
        </html>

<?php

include 'config.php' ;
error_reporting(E_ALL);
  ini_set('display_errors', 'on');



?>
<div class="span-24 last">
	<table>
		<tr>
			<td>Category</td>
			<td>Total Items</td>
			<td>Min Price</td>
			<td>Max Price</td>
			<td>Average Price</td>
		</tr>
		<?php
    $query = "SELECT categories.name AS Category, COUNT(items.name) AS Total_Items, MIN(NULLIF(get_it_now, 0)) AS Min_Price, MAX(NULLIF(get_it_now, 0)) AS Max_Price, AVG(NULLIF(get_it_now, 0)) AS Average_Price  FROM categories left join items on (items.category_name = categories.name) GROUP BY categories.name order by categories.name asc;";


	      	$result = mysqli_query($gtbay,$query);

             while ($row = mysqli_fetch_array($result)){

		?>
			<tr>
				<td><?= $row['Category'];?></td>
				<td><?= $row['Total_Items'];?></td>
				<td><?= $row['Min_Price'] ? "$" . $row['Min_Price'] : "- ";?></td>
				<td><?= $row['Max_Price'] ? "$" . $row['Max_Price'] : "- ";?></td>
				<td><?= $row['Average_Price'] ? "$" . $row['Average_Price']: "- ";?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>

<div class="column span-24 last">

				<input type="button" name="Back to Main Page" value="Back to Main Page" class="btn btn-primary" onclick="window.location.href='index.php?action=menu'"/>
			</div>
