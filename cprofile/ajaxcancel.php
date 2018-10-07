<?php 

require('../config/db.php');
require('../config/config.php');
session_start();
$cid = $_SESSION["cid"];
if(isset($_POST['v0'])){

	$bid = $_POST['v0'];
	$query = "DELETE FROM bookings WHERE bid='".$bid."' ";
	if(mysqli_query($conn,$query)){
		echo "1";		
	}else{
		echo "2";
	}


}
?>