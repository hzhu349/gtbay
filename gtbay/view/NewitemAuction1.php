
<?php
include 'config.php' ;
session_start();

// debug
//echo $_SESSION['username'] ;
?>
<?php
    /** Conditions checked:
    * 1 All fields except Get It Now must be filled
    * 2 Starting Bid price < Min Sell Price < Get It Now price
    * 3 Price listed must be in 2 decimal forms
    * 4 Price listed in numeric forms
    * If no error, insert data into the database
    */



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

    if ( $new_item && !($_POST['name'] && $_POST['description'] && $_POST['start_bid'] && $_POST['min_sell_price'])) {

        $error_message = $error_message . "<br>Either item name, description, starting bid price, or minimum sell price not yet filled in</br>";

        $error_free = false;
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

    if ($new_item && (!is_numeric($_POST['start_bid']) || !is_numeric($_POST['min_sell_price']) || (!is_numeric($_POST['get_it_now_price']) && $_POST['get_it_now_price']))) {

        $error_message = $error_message . "<br>All prices listed must be numeric";

        $error_free = false;
    }

    if (isset($_POST['new_item']) && $error_free) {
        $sql="insert into items (       seller_username,
                                        returnable,
                                        min_sell_price,
                                        start_bid,
                                        actual_end_date,
                                        get_it_now,
                                        item_condition,
                                        description,
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
                                        $_POST['description'] . "\", \"" .
                                        $_POST['name'] . "\", \"" .
                                        $_POST['category'] . "\")" ;
        mysqli_query($gtbay,$sql);
        print "Congratulations! Your item had been listed successfully! Click GTBay to return to the Main Menu";
    }
    else {
        print $error_message;
    }
?>

<?php
    // Create the form
    if (!isset($_POST['new_item']) || !$error_free) {
?>

 <form action="index.php?action=new_item" method="post">

	<div>
		<label for="name">Item Name</label>
		<input type="text" name="name" id="name"></textarea>
	</div>

	<div>
		<label for="description">Description</label>
		<textarea id="description" name="description" rows="3" cols="5"></textarea>
	</div>

	<div>
		<label for="category_name">Category</label>
		<?php
            // Retrive data for categories
			$sql = "select * from categories";
			$result = mysqli_query($gtbay,$sql);
		?>
		<select name="category">
		<?php

			while ($category_row = mysqli_fetch_assoc($result)) {
		?>
			<option value= <?= $category_row['name'];?> > <?= $category_row['name'];?> </option>
		<?php
			}
		?>
		</select>
	</div>

	<div>
		<label for="Condition">Condition</label>
		<select name="condition" id="condition">
			<option value=1>Poor</option>
			<option value=2>Fair</option>
			<option value=3>Good</option>
			<option value=4>Very Good</option>
			<option value=5>New</option>
		</select>
	</div>

	<div>
		<label for="start_bid">Start auction bidding at $</label>
		<input type="text" name="start_bid" id="start_bid"/>
	</div>

    <div>
		<label for="min_sell_price">Minimum sale price $</label>
		<input type="text" name="min_sell_price" id="min_sell_price"/>
	</div>

	<div>
		<label for="auction_end_duration">Auction ends in</label>
		<select name="auction_end_duration" id ="auction_end_duration">
			<option value=1>1 day</option>
			<option value=3>3 days</option>
			<option value=5>5 day</option>
			<option value=7>7 days</option>
			<option value=10>10 days</option>
		</select>
	</div>

	<div>
		<label for="get_it_now_price">Get it now price $ </label>
		<input type="text" name="get_it_now_price" id="get_it_now_price">
		<label>(optional)</label>
	</div>

	<div>
		<label for="returnable">Returns accepted?</label>
		<input type="checkbox" name="returnable" value="returnable">
	</div>

    <div>
		<input name="new_item" type="submit" value="List my item">
		<button type="button" onclick="window.location.href='index.php'">Cancel</button>
	</div>
  </form>

 <?php
    }
?>
