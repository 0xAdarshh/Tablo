<?php 

require('../config/db.php');
require('../config/config.php');
session_start();
$cid = $_SESSION["cid"];
if(isset($_POST['v2']) && isset($_POST['v1'])){
	$rate = $_POST['v2'];
	$bid = $_POST['v1'];
	$query = "UPDATE bookings 
	SET rating ='".$_POST['v2']."' 
				WHERE cid='".$cid."' and bid='".$bid."' ";
	if(mysqli_query($conn,$query)){
		echo "1";		
	}else{
		echo "2";
	}


}
?>