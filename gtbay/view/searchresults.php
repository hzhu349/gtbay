<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<html>
<!-- 	https://searchcode.com/file/65575510/ -->
    <head>
        <title>
					Search Result
        </title>
				<h1 class="test-results-header">
          Search Result

				</h1>
			</head>
		</html>

    <?php
     include 'config.php' ;
     error_reporting(E_ALL);
    ini_set('display_errors', 'on');

    // session_start();

    $keyword  =  (isset($_POST['search']) ? $_POST['keyword'] : $_SESSION['keyword']);
    $category   =  (isset($_POST['search']) ? $_POST['category'] : $_SESSION['category']);
    $minprice   =  (isset($_POST['search']) ? $_POST['minprice'] : $_SESSION['minprice']);
    $maxprice   =  (isset($_POST['search']) ? $_POST['maxprice'] : $_SESSION['maxprice']);
    $condition  =  (isset($_POST['search']) ? $_POST['condition'] : $_SESSION['condition']);

    $_SESSION['keyword'] = $keyword;
    $_SESSION['category'] = $category;
    $_SESSION['minprice'] = $minprice;
    $_SESSION['maxprice'] = $maxprice;
    $_SESSION['condition'] = $condition;

    if ($debug) {
      print "Parameters: <br>";
      print_r($_POST);
    }
    $currentdate = date('Y-m-d',time());


    $query = "
      SELECT
      id,
      name AS Item_Name,
      user_username AS High_Bidder,
      start_bid,
      get_it_now as Get_It_Now_Price,
      actual_end_date as Auction_Ends,
      Current_Bid
      FROM items
      LEFT OUTER JOIN
        (SELECT
                item_id,
                user_username,
                max(amount) AS Current_Bid
        FROM bids
        GROUP BY item_id) AS MaxiumBids
      ON item_id=id
      WHERE
      (name LIKE \"%" . $keyword . "%\" or description LIKE \"%" . $keyword . "%\")

      AND actual_end_date > " . ($currentdate ? "DATE('$currentdate')" : "NOW()") . "

      AND item_condition >= " . $condition;

        if (isset($category) && $category != "") $query .= " AND category_name=\"" . $category . " \" ";

        if (isset($minprice) && $minprice != "")
          $query .= " AND (Current_Bid >= " . $minprice . " or start_bid >= " . $minprice . ")";

        if (isset($maxprice) && $maxprice != "")
          $query .= " AND (Current_Bid <= " . $maxprice . " or start_bid <= " . $maxprice . ")";

      $query .= " ORDER BY Auction_Ends ASC";


    $result = mysqli_query($gtbay, $query);
    ?>



    <div class="span-24 last">
    <table>
      <tr>
        <td>ID</td>
        <td>Item Name</td>
        <td>Starting Bid</td>
        <td>Current Bid</td>
        <td>High Bidder</td>
        <td>Get It Now Price</td>
        <td>Auction Ends</td>
      </tr>
      <?php
        while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <tr>
        <td><?= $row['id'];?></td>
        <td><a href="index.php?action=viewitem&id=<?= $row['id'];?>"><?= $row['Item_Name'];?></a></td>
        <td><?= $row['start_bid'];?></td>
        <td><?= $row['Current_Bid'] ? "$" . $row['Current_Bid'] : "---";?></td>
        <td><?= $row['High_Bidder'] ? $row['High_Bidder'] : "---";?></td>
        <td><?= $row['Get_It_Now_Price'] ? "$" . $row['Get_It_Now_Price'] : "---" ;?></td>
        <td><?= $row['Auction_Ends'];?></td>
      </tr>
      <?php
        }
      ?>
    </table>
    </div>


</table>
</div>
<input type="button" name="Cancel" class="btn btn-danger" value="Go to Menu" onclick="window.location.href='index.php?action=menu'"/>
<input type="button" name="Back to Search" value="Back to Search" onclick="window.location.href='index.php?action=search'" class="btn btn-primary">
