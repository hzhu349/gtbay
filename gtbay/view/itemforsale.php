<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<html>

<head>
  <title>Item For Sale</title>
</head>

<title>
Item For Sale</title>

</html>

<?php
include 'config.php' ;
         if (isset($_GET['id'])) {
               $id=$_GET['id'];
             } else {
               $id = "";
             }
             if (isset($_SESSION['username'])) {
                   $username=$_SESSION['username'];
                 } else {
                   $_SESSION['username'] = "";
                 }
$itemquery ="SELECT * FROM items where id = $id";
$itemresult = mysqli_query($gtbay,$itemquery);
$item = mysqli_fetch_assoc($itemresult);
$bidquery = "SELECT * FROM bids WHERE item_id = $id order by amount desc limit 4";
$bidhistory = mysqli_query($gtbay,$bidquery);
$bid = mysqli_fetch_assoc($bidhistory);
$error = 0;
if(isset($item['item_condition']))
{
    if ($item['item_condition'] == 1)
    {
      $condition = "Poor";
    }
    elseif ($item['item_condition'] == 2)
    {
      $condition = "Fair";
    }
    elseif ($item['item_condition'] == 3)
    {
      $condition = "Good";
    }
    elseif ($item['item_condition'] == 4)
  {
    $condition = "Very Good";
  }
  elseif ($item['item_condition'] == 5)
  {
    $condition = "New";
  }
}
while (isset($_GET['getitnow']))
{
  $getitnow = $item['get_it_now'];
  if ($getitnow == null || $getitnow == 0)
  {
    ?>

    <div class="alert">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
      The get it now option is not available !
    </div>
    <?php

    $error = 1;
      break;
  }
elseif (strtotime($item['actual_end_date']) < time())
{
  ?>

  <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    The auction has ended!
  </div>
  <?php
  $error = 1;
    break;
}
if (isset($getitnow) && $error == 0)
{
      $query = "INSERT INTO bids VALUES (NOW(), '$username', '$id', '" . $getitnow . "');";
      $result = mysqli_query($gtbay,$query);
      $end_query = "UPDATE items SET actual_end_date = NOW() WHERE items.id = $id;";
      mysqli_query($gtbay,$end_query) or die("cannot connect");
      $_SESSION['message'] = "Congratulations! You purchase the item successfully!";
      header ('location: http://localhost/demo/gtbay/index.php?action=menu');
      exit;
}
}
while (isset($_POST['itemBid']))
{
    $price = $_POST['bidprice'];
if (strtotime($item['actual_end_date']) < time())
{
  ?>

  <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    The auction has ended!
  </div>
  <?php
  $error = 1;
  break;
}
if ($price < $item['start_bid'])
{
  ?>

  <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    Your bid is less than Current Bid!
  </div>
  <?php
  $error = 1;
  break;
}
if ($item['get_it_now'] != null && $item['get_it_now'] > 0 && $price >= $item['get_it_now'])
{
  ?>

  <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    Your bid is more  than Get It Now Price!
  </div>
  <?php
$error = 1;
break;
}
if (isset($item['high_bid']) && $price < $item['high_bid'] + 1)
{
  ?>

  <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    Your bid must be more than the current high bid + $1!
  </div>
  <?php
  $error = 1;
  break;
}
if ($error == 0)
{
  $newBidquery= "INSERT INTO bids  VALUES (NOW(), '$username','$id','$price');";
  $newbid =mysqli_query($gtbay,$newBidquery);
  $bidhistory = mysqli_query($gtbay,$bidquery);
  $bid = mysqli_fetch_assoc($bidhistory);
  if (!(empty($newbid)))
  {
    ?>
    <div class="alert success">
      <span class="closebtn">&times;</span>
      Good Luck! Your bid had been placed successfully!
</div>
<?php
  break;
  }
  else {
    break;
  }
  }
}
if ($bid['amount'] != NULL ||  $bid['amount'] != 0)
{
  $minimumbid = $bid['amount']+1;
}else{
  $minimumbid= $item['start_bid'];
}
?>
<div class="span-14 append-5 prepend-5 last" style="margin-bottom: 15px; margin-left: 5px;">
<div class="span-14 last">

</div>


<!--https://searchcode.com/file/65575571/view/itemforsale.php-->
<div class="span-14 last" style="padding-top: 5px; padding-bottom: 5px;">
    <div class="span-4">
    Item ID:
    </div>
    <div class="span-8" style="font-weight: bold;">
    <?= $item['id'] ?>
    </div>
    <div class="span-2 last">
        <a href="index.php?action=ratings&id=<?= $id ?>">View Ratings</a>
    </div>
</div>

<div class="span-14 last" style="padding-top: 5px; padding-bottom: 5px;">
    <div class="span-4">
    Item Name:
    </div>
    <div class="span-10 last" style="font-weight: bold;">
    <?= $item['name'] ?>
    </div>
</div>

<div class="span-14 last" style="padding-top: 5px; padding-bottom: 5px;">
    <div class="span-4">
    Description:
    </div>
    <div class="span-10 last" style="font-weight: bold;">
    <?= $item['description'] ?>
    <?php
    if ($item['seller_username'] == $username) {
        echo("<br/><a href='#' onclick='window.location.href=\"index.php?action=edititemdescription&id=$id\"'>Edit Description</a>" );
    }
    ?>
    </div>
</div>

<div class="span-14 last" style="padding-top: 5px; padding-bottom: 5px;">
    <div class="span-4">
    Category:
    </div>
    <div class="span-10 last" style="font-weight: bold;">
    <?= $item['category_name'] ?>
    </div>
</div>

<div class="span-14 last" style="padding-top: 5px; padding-bottom: 5px;">
    <div class="span-4">
    Condition:
    </div>
    <div class="span-10 last" style="font-weight: bold;">
    <?=$condition?>
    </div>
</div>

<div class="span-14 last" style="padding-top: 5px; padding-bottom: 5px;">
    <div class="span-4">
    Returns Accepted:
    </div>
    <div class="span-10 last" style="font-weight: bold;">
    <?= $item['returnable'] ? "Yes" : "No" ?>
    </div>
</div>

<?php if (isset($item['get_it_now']) && $item['get_it_now'] != NULL && $item['get_it_now'] > 0) { ?>
<div class="span-14 last" style="padding-top: 5px; padding-bottom: 5px;">
    <div class="span-4">
    Get It Now price:
    </div>
    <div class="span-10 last" style="font-weight: bold;">
    $<?= $item['get_it_now']      ;?>

    <?php if (strtotime($item['actual_end_date']) > time() && $username!=$item['seller_username'] ) { ?>
    <button type="button"  class="btn btn-primary" onclick="window.location.href='index.php?action=viewitem&id=<?= $id?>&getitnow=getitnow'">Get It Now</button>
    <?php
        }
    ?>
    </div>
</div>
<?php
}
?>

<div class="span-14 last" style="padding-top: 5px; padding-bottom: 5px;">
    <div class="span-4">
    Auction Ends:
    </div>
    <div class="span-10 last" style="font-weight: bold;">
    <?= $item['actual_end_date'] ?>
    </div>
</div>


<div class="span-14 last" style="margin-top: 1px; margin-bottom: 1px; border-style: solid; border-width: 1px;">
<table>
    <tr>
        <td><b>Bid Amount</b></td>
        <td><b>Time of Bid</b></td>
        <td><b>Username</b></td>
    </tr>
    <?php
    $bidhistory = mysqli_query($gtbay,$bidquery);
    while ($bid = mysqli_fetch_assoc($bidhistory)) {
        ?>
        <tr>
            <td><?= $bid['amount'];?></td>
            <td><?= $bid['timestamp'];?></td>
            <td><?= $bid['user_username'];?></td>
        </tr>
        <?php
    }
    ?>
</table>
</div>
<div class="span-14 last">



(Minimim bid $ <?= $minimumbid ?>)

<?php if (strtotime($item['actual_end_date']) > time() && $username!=$item['seller_username'] ) { ?>
<form action="index.php?action=viewitem&id=<?php echo $id;?>" method="POST">
    Your bid $   <input type="text" name="bidprice" /></br>
  <input type="submit" style="width:80px;height:30px;" name="itemBid" value="Bid" class="btn btn-primary"/></button> <font-size: 10px>

<?php } ?>

    <button  type="button" class="btn btn-danger" style="width:80px;height:30px;" onclick="window.location.href='index.php?action=menu'">Cancel </button>


</form>

</div>
