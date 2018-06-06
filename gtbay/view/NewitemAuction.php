<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<?php
include 'config.php' ;
?>
<?php

    function TwoDecimalChecking ($aNumber) {
        if (($aNumber*100 - floor($aNumber*100)) < 0.00001)
            return true;
        else
            return false;
    }
    if (isset($_POST['start_bid'])) {
      $start_bid=$_POST['start_bid'];
    } else {
      $start_bid = "";
    }
    if (isset($_POST['min_sell_price'])) {
      $min_sell=$_POST['min_sell_price'];
    } else {
      $min_sell = "";
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
    $error_message = "";
    if (isset($_POST['new_item']) == "new_item") {
                $new_item=$_POST['new_item'];
    }else{
                $new_item =  "";
              }

    if (    ($new_item) &&
                (($start_bid > $min_sell) ||
                    (($get_it_now != 0) &&
                        ($start_bid > $get_it_now ||
                        $min_sell > $get_it_now)))) {
        $error_message = $error_message . "<br>Minimum Sell Price should not be more than Get It Now price, and not less than Starting Bid price</br>";
        $error_free = false;
    }
    $start_bid_float=floatval($start_bid);
    $min_sell_float=floatval($min_sell);
    $get_it_now_float=floatval($get_it_now);
    if ($new_item && (!TwoDecimalChecking($start_bid_float) || !TwoDecimalChecking($min_sell_float) || !TwoDecimalChecking($get_it_now_float))) {
        $error_message = $error_message . "<br>All prices enumerated must consist no more than 2 decimal places";
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
                                        $_POST['min_sell_price'] . "\", \"" .
                                        $_POST['start_bid'] . "\", " .
                                        "NOW() + INTERVAL \"" . $_POST['auction_end_duration'] . "\" DAY, \"" .
                                        $_POST['get_it_now_price'] . "\", \"" .
                                        $_POST['condition'] . "\", \"" .
                                        $_POST['Description'] . "\", \"" .
                                        $_POST['name'] . "\", \"" .
                                        $_POST['category'] . "\")" ;
        mysqli_query($gtbay,$sql);
        $_SESSION['message'] ="Congratulations! Your item had been listed successfully!";
        header ('location: http://localhost/demo/gtbay/index.php?action=main');
        exit;
    }
    else {
        print $error_message;
    }
?>


<form class="form-horizontal" action="index.php?action=new_item" method="post">
    <fieldset>

        <!-- Form Name -->
        <legend class="center">List New Item</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">Item Name:</label>
            <div class="col-md-6">
                <input id="name" name="name" type="text" placeholder="" class="form-control input-md" required="">
            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="category_name">Category:</label>
            <div class="col-md-4">
              <?php
                        // Retrive data for categories
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




        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="Description">Description:</label>
            <div class="col-md-6">
                <input id="Description" name="Description" type="text" placeholder="" class="form-control input-md" rows="4" >

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="start_bid">Starting Bid $</label>
            <div class="col-md-6">
                <input id="start_bid" name="start_bid" type="text" placeholder="" class="form-control input-md">

            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="min_sell_price">Minimum Sale Price $</label>
            <div class="col-md-4">
                <input id="min_sell_price" name="min_sell_price" type="text" placeholder="" class="form-control input-md">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="get_it_now_price">Get It Now Price $</label>
            <div class="col-md-4">
                <input id="get_it_now_price" name="get_it_now_price" type="text" placeholder="" class="form-control input-md">
            </div>
            <label class="col-md control-label" >
              <p>(Optional)</p></label>
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
          <label  class="col-md-4 control-label" for="returnable">Returns Accepted?</label>
          <div class="col-md-4">
            <input type="checkbox" name="returnable" value="returnable">
            </div>
        </div>


        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="submitButton"></label>
            <div class="col-md">
              <br><br><br>

                <input id="submit" name="new_item" type="submit" value="List" class="btn btn-primary">
                <button  type="button" class="btn btn-danger" onclick="http://localhost/demo/gtbay/index.php?action=menu">Cancel</button>
            </div>
        </div>

    </fieldset>
</form>
