<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!--https://searchcode.com/file/65575510/ -->
<html>
    <head>
        <title>
                    Auction Result Report
        </title>
                <h1 class="test-results-header">
                    Auction Result Report

                </h1>
            </head>
        </html>
    <?php
    include 'config.php' ;
    ?>
    <div class="span-24 last">
    <table>
        <tr>
            <td>ID</td>
            <td>Item Name</td>
            <td>Sale Price</td>
            <td>Winner</td>
            <td>Auction Ended</td>
        </tr>
        <?php
        $sql_command = "select * from (select amount, user_username,  i.id, i.actual_end_date, i.name, i.min_sell_price from items i left outer join bids b on i.id= b.item_id  where i.actual_end_date< now() order by amount DESC) as res  group by id order by actual_end_date DESC";
        $result = mysqli_query($gtbay, $sql_command);
        $query = "update items, (" . $sql_command . ") as endedItem set items.winner_username = endedItem.user_username where items.id = endedItem.id and items.min_sell_price <= endedItem.amount";
            while ($row = mysqli_fetch_array($result)) {
        ?>
        <tr>
            <td><?= $row['id'];?></td>
            <td><a href="index.php?action=viewitem&id=<?= $row['id'];?>"><?= $row['name'];?></td>
            <td><?= $row['amount'] && $row['amount'] >= $row['min_sell_price'] ? "$" . $row['amount'] : "---";?></td>
            <td><?= $row['user_username'] && $row['amount'] >= $row['min_sell_price'] ? $row['user_username'] : "---";?></td>
            <td><?= $row['actual_end_date'];?></td>
        </tr>
        <?php
            }
        ?>
    </table>
    </div>
<div class="col-md">

    <input type="button" name="Back to Menu" class="btn btn-danger" value="Back to Menu" onclick="window.location.href='index.php?action=menu'"/>

</div>
