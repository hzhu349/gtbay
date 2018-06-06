
<?php
include 'config.php';
include 'view/header.php';
session_start();
if (isset ($_GET['action'])) {
	$page = $_GET['action'];
}
else{
	$page ="";
}

switch ($page) {
	case 'search':
		include 'view/search.php';
		break;
	case 'menu';
	include 'view/main.php';
	break;
	case 'registration':
		include 'view/registration.php';
		break;
	case 'new_item':
		include 'view/listingnewitem.php';
		break;
	case 'viewitem':
		include 'view/itemforsale.php';
		break;
	case 'edititemdescription':
		include 'view/DescriptionEdit.php';
		break;
	case 'searchresults':
		include 'view/searchresults.php';
		break;
	case 'results':
		include 'view/auctionResults.php';
		break;
	case 'userreport':
		include 'view/userreport.php';
		break;
	case 'categoryreport':
		include 'view/categoryReport.php';
		break;
	case 'register':
		include 'view/registration.php';
		break;
	case 'ratings':
		include 'view/ratings.php';
		break;
	case 'logout':
	{
		unset($_SESSION['username']);
		unset($_SESSION['position']);
		unset($_SESSION['password']);
		unset($_SESSION['message']);
		session_destroy();

	}
	default:
		include 'view/login.php';
}
;
?>
