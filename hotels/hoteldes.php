<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php

require('../config/config.php');
require('../config/db.php');

//get hid 
$hid = $_GET['hid'];
    
// create query
//$query = 'SELECT h.hid,h.hname,ht.day,ht.status from hotel as h inner join hoteltime as ht on h.hid=ht.hid where h.hid=$hid';
$query = "SELECT * from hotel where hid='$hid' limit 1";
//get results
$result = mysqli_query($conn, $query);

//fetch data
$hotel = mysqli_fetch_all($result,MYSQLI_ASSOC);

//close connection
mysqli_close($conn);


echo "<h2>" . $hotel[0]['hname'] . "</h2>";
echo "<h3>@ " . $hotel[0]['hlocation'] . "</h3>";
echo "<small>" . $hotel[0]['hcategory'] . "</small>";
echo "<hr>";
echo "<p>" . $hotel[0]['hdescription'] . "</p>";


?>
</body>
</html>



