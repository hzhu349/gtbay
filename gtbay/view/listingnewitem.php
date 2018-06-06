<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<?php
include 'config.php' ;

?>
<?php

    function validateTwoDecimals($number)
    {

      if (($number*100 - floor($number*100)) < 0.00001)
          return true;
      else
          return false;

    }
    if (isset($_POST['startingBid'])) {
      $startingBid=$_POST['startingBid'];
    } else {
      $startingBid = "";
    }
    if (isset($_POST['minimumSalePrice'])) {
      $minimumSalePrice=$_POST['minimumSalePrice'];
    } else {
      $minimumSalePrice = "";
    }
    if (isset($_POST['get_it_now_price'])) {
      $get_it_now=$_POST['get_it_now_price'];
    } else {
      $get_it_now = "";
    }
    if (isset($_POST['returnable']) == "returnable") {
                $_POST['returnable'] = 1;
    }else{
                $_POST['returnable'] = 0;
              }
    $error_free = true;

    if (isset($_POST['new_item']) == "new_item") {
                $new_item=$_POST['new_item'];
    }else{
                $new_item =  "";
              }
    if ( $new_item && !($_POST['name'] && $_POST['Description'] && $_POST['startingBid'] && $_POST['minimumSalePrice'])) {

      ?>

      <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        All the fields with asterisk must be filled in!
      </div>
      <?php
        $error_free = false;
    }
    if (    ($new_item) &&
                (($startingBid > $minimumSalePrice) ||
                    (($get_it_now != 0) &&
                        ($startingBid > $get_it_now ||
                        $minimumSalePrice > $get_it_now)))) {
                          ?>

                          <div class="alert">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            Minimum Sell Price should not be greater than Get It Now price!

                            Minimum Sell Price should not be less than Starting Bid price!
                          </div>
                          <?php

        $error_free = false;
    }

    if ( $new_item && ( ($_POST['startingBid']<0.01)  || ($_POST['minimumSalePrice'] <0.01))) {

      ?>

      <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
The price must be positive!
  </div>

      <?php


        $error_free = false;
    }
    $start_bid_float=floatval($startingBid);
    $min_sell_float=floatval($minimumSalePrice);
    $get_it_now_float=floatval($get_it_now);
    if ($new_item && (!validateTwoDecimals($start_bid_float) || !validateTwoDecimals($min_sell_float) || !validateTwoDecimals($get_it_now_float))) {

      ?>

      <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
The prices must be like $ XXXX.XX!
  </div>
      <?php
        $error_free = false;
    }
    if ($new_item && (!is_numeric($_POST['startingBid']) || !is_numeric($_POST['minimumSalePrice']) || (!is_numeric($_POST['get_it_now_price']) && $_POST['get_it_now_price']))) {
      ?>

      <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
The prices must be numeric!
  </div>
      <?php

        $error_free = false;
    }
    if (isset($_POST['new_item']) && ($error_free == true)) {
        $sql="insert into items (       seller_username,
                                        returnable,
                                        min_sell_price,
                                        start_bid,
                                        actual_end_date,
                                        get_it_now,
                                        item_condition,
                                        Description,
                                        name,
                                        category_name)
                            values (\"" .
                                        $_SESSION['username'] . "\", \"" .
                                        $_POST['returnable'] . "\", \"" .
                                        $_POST['minimumSalePrice'] . "\", \"" .
                                        $_POST['startingBid'] . "\", " .
                                        "NOW() + INTERVAL \"" . $_POST['auction_end_duration'] . "\" DAY, \"" .
                                        $_POST['get_it_now_price'] . "\", \"" .
                                        $_POST['condition'] . "\", \"" .
                                        $_POST['Description'] . "\", \"" .
                                        $_POST['name'] . "\", \"" .
                                        $_POST['category'] . "\")" ;
        mysqli_query($gtbay,$sql);
        $_SESSION['message'] ="Congratulations! Your item had been listed successfully!";
        header ('location: http://localhost/demo/gtbay/index.php?action=menu');
        exit;
    }


?>

<!--https://searchcode.com/file/65575521/view/NewItemAuction.php-->
<form class="form-horizontal" action="index.php?action=new_item" method="post">
    <fieldset>


        <legend class="center">List New Item</legend>


        <div class="form-group">
            <label class="col-md-4 control-label" for="name">Item Name *:</label>
            <div class="col-md-6">
                <input id="name" name="name" type="text" placeholder="" class="form-control input-md">
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-4 control-label" for="category_name">Category:</label>
            <div class="col-md-4">
              <?php

            			$sql = "select * from categories";
            			$result = mysqli_query($gtbay,$sql);
            		?>
            		<select name="category" width="300">
            		<?php
            			while ($category_row = mysqli_fetch_assoc($result)) {
            		?>
            			<option value= <?= $category_row['name'];?> > <?= $category_row['name'];?> </option>
            		<?php
            			}
            		?>
            		</select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="auction_end_duration">Auction Length:</label>
            <div class="col-md-4">
                <select name="auction_end_duration" id ="auction_end_duration" width="300px">
                  <option value=1>1 day</option>
                  <option value=3>3 days</option>
                  <option value=5>5 days</option>
                  <option value=7>7 days</option>
                </select>
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-4 control-label" for="Description">Description *:</label>
            <div class="col-md-6">
                <input id="Description" name="Description" type="text" placeholder="" class="form-control input-md" rows="4" >

            </div>
        </div>


        <div class="form-group">
            <label class="col-md-4 control-label" for="startingBid">Starting Bid $ *</label>
            <div class="col-md-6">
                <input id="startingBid" name="startingBid" type="text" placeholder="" class="form-control input-md">

            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="minimumSalePrice">Minimum Sale price $ *</label>
            <div class="col-md-4">
                <input id="minimumSalePrice" name="minimumSalePrice" type="text" placeholder="" class="form-control input-md">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="get_it_now_price">Get It Now Price $ (Optional)</label>
            <div class="col-md-4">
                <input id="get_it_now_price" name="get_it_now_price" type="text" placeholder="" class="form-control input-md">
            </div>
        </div>

        <div class="form-group">
          <label  class="col-md-4 control-label" for="Condition">Condition</label>
          <div class="col-md-4">
            <select name="condition" id="condition">
              <option value=1>Poor</option>
              <option value=2>Fair</option>
              <option value=3>Good</option>
              <option value=4>Very Good</option>
              <option value=5>New</option>
            </select>
          </div>

        </div>

        <div>
          <label  class="col-md-4 control-label" for="returnable">Return accepted?</label>
          <div class="col-md-4">
            <input type="checkbox" name="returnable" value="returnable">
            </div>
        </div>



        <div class="form-group">
            <label class="col-md-4 control-label" for="submitButton"></label>
            <div class="col-md">
              <br><br><br><br><br><br>

                <input id="submit" name="new_item" type="submit" value=" List" class="btn btn-primary">
                <input type="button" name="Cancel" class="btn btn-danger" value="Cancel" onclick="window.location.href='index.php?action=menu'"/>

            </div>
        </div>

    </fieldset>
</form>
