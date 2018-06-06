<?php
include 'config.php' ;

?>

<html>

<head>
  <title>MainMenu</title>
</head>

<title>
MainMenu</title>

</html>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<!-- http://www.jquery2dotnet.com ------>

<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-folder-close">
                            </span>Content</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-pencil text-primary"></span><a href="http://localhost/demo/gtbay/index.php?action=search">Search for Items</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-flash text-success"></span><a href="http://localhost/demo/gtbay/index.php?action=new_item">List an Item for Sale</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-file text-info"></span><a href="http://localhost/demo/gtbay/index.php?action=results">View Auction Results</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-comment text-success"></span><a href="http://www.jquery2dotnet.com">Member Messages</a>
                                        <span class="badge">42</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-folder-close">
                            </span>Report</a>
                        </h4>
                    </div>
                    <?php
                    if (isset($_SESSION['position']))
                    {
                    ?>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <table class="table">

                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-file text-info"></span><a href="http://localhost/demo/gtbay/index.php?action=categoryreport">View Category Report</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-file text-info"></span>  <a href="http://localhost/demo/gtbay/index.php?action=userreport">View User Report</a>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                    <?php
                  }
                  ?>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="glyphicon glyphicon-user">
                            </span>Account</a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="http://www.jquery2dotnet.com">Change Password</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="http://www.jquery2dotnet.com">Notifications</a> <span class="label label-info">5</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="http://www.jquery2dotnet.com">Import/Export</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-trash text-danger"></span><a href="http://www.jquery2dotnet.com" class="text-danger">
                                            Delete Account</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                      <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="glyphicon glyphicon-th">
                          </span>Modules</a>
                      </h4>
                  </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <table class="table">

                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-trash text-danger"></span>    <a href="http://localhost/demo/gtbay/index.php?action=logout">Logout</a>
                                    </td>
                                </tr>



                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9">
            <div class="well">
                <h1>
                    Welcome To GTBay, <b><?= $_SESSION['username'];?></b>!<br/></h1>


                    <?php
                    if (isset($_SESSION['message']))
                    {
                    echo $_SESSION['message'];

                  }

                    if (isset($_SESSION['position']))
                    {
                    echo " Your position is " .  $_SESSION['position'] . " .";
                  }
                    ?>
                  </p>
            </div>
        </div>
    </div>
</div>
