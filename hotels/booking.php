<?php

    require('../config/config.php');
    require('../config/db.php');
    error_reporting(E_ERROR|E_PARSE);

    session_start();
    $cid = $_SESSION["cid"];
    //get hid 
    $hid = $_GET['hid'];



    date_default_timezone_set('Asia/Kolkata');
    $hr =  date('H').":00";
    $cut = substr($hr,0,2);
    //Query to display current running offers
    $query = "SELECT * FROM OFFERS where hid=$hid ORDER BY time";

    //fire the Query
    $result = mysqli_query($conn,$query);

    //fetch data
    $offers = mysqli_fetch_all($result,MYSQLI_ASSOC);

    //after clicking Add button
    if(isset($_POST['book'])){
        $curpeople = mysqli_real_escape_string($conn,$_POST['curpeople']);
        $oid = mysqli_real_escape_string($conn,$_POST['radio-value']);
        $discount = mysqli_real_escape_string($conn,$_POST['discount']);
        $people = mysqli_real_escape_string($conn,$_POST['people']);
        $time = mysqli_real_escape_string($conn,$_POST['time']);
        $tdate = date('Y/m/d');
        $npeople = $curpeople - $people;
        $query = "INSERT INTO bookings(date,cid,hid,time,discount,people) VALUES('$tdate','$cid','$hid','$time','$discount','$people');call updatepeople('$npeople','$oid');";
    

    if(mysqli_multi_query($conn,$query)){
        //go to thank you page
        header('Location:thankyou.php');
    }
    else{
        echo 'Error : ' . mysqli_error($conn);
    }

    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hotel Name</title>
    <link href="https://fonts.googleapis.com/css?family=Sriracha" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,900" rel="stylesheet">
    <link rel="stylesheet" href="bstyles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
</head>
<body style="padding:20px; font-family: 'Roboto', sans-serif;">
<!-- Navbar Starts -->
<nav class="navbar navbar-light fixed-top">
	<a href="../" class="navbar-brand brand">TABLO</a>
	<form class="form-inline">
		<?php if(!$_SESSION['user_logged_in']): ?>    
            <a href="../csignup/rform.php" class="btn btn-info my-2 my-sm-0 mx-1">Signup</a>
            <a href="../clogin/login.php" class="btn btn-success my-2 my-sm-0 mx-1">Login</a>
            <?php else: ?>
            <a href="#" class="btn btn-info my-2 my-sm-0 mx-1">Profile</a>
            <a href="../logout.php" class="btn btn-success my-2 my-sm-0 mx-1">Logout</a>
            <?php endif; ?>
	</form>
</nav>
<!-- Navbar Ends -->
    <div class="main" style="margin-top:60px;">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div id="hoteldes"></div>        
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5>Operating Hours</h5>
                    <div id="timingdes"></div>
                </div>
            </div>
        </div>    
        <div class="card col-md-4" style="background-color: rgb(240, 239, 239);padding:10px;">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
            <h4>No. of People</h4>
            <input type="number" name="people">
            <h4>Choose a Offer</h4>
            <div class="container">
                <div class="row radio-group">
                <?php foreach($offers as $offer) : ?> 
                <?php $ot = substr($offer['time'],0,2); $nt = $cut + 1; 
                 if($ot == $nt && (date('i')<45)){ ?>
                 <div class="col-md-3 sticker radio" data-value="<?php echo $offer['oid'];?>" data-discount="<?php echo $offer['discount'];?>" data-time="<?php echo $offer['time'];?>" data-people="<?php echo $offer['people'];?>">
                <p style=" margin-left:5px; margin-bottom:0px; font-size:19px;"><?php echo $offer['discount'];?><small>%</small>
                <p style="margin-left:6px; margin-top: 0px; font-size:11px;"><?php echo $offer['time'];?></p>
                <input type="hidden" name="discount" value="<?php echo $offer['discount'];?>">
                <input type="hidden" name="time" value="<?php echo $offer['time'];?>">
                </div>
                <?php }else if($ot>$cut && $ot !=$nt) { ?>   
                <div class="col-md-3 sticker radio" data-value="<?php echo $offer['oid'];?>" data-discount="<?php echo $offer['discount'];?>" data-time="<?php echo $offer['time'];?>">
                <p style=" margin-left:5px; margin-bottom:0px; font-size:19px;"><?php echo $offer['discount'];?><small>%</small>
                <p style="margin-left:6px; margin-top: 0px; font-size:11px;"><?php echo $offer['time'];?></p>
                </div>
                <?php } endforeach; ?>
                <input class="curpeople" type="hidden" id="radio-value" name="curpeople" />
                <input class="oid" type="hidden" id="radio-value" name="radio-value" />
                <input class="discount" type="hidden" id="radio-value" name="discount" />
                <input class="time" type="hidden" id="radio-value" name="time" />
                </div>
            </div>
            <input name="book" type="submit" value="BOOK" class="btn btn-primary">
            </form>
        </div>
    </div>
    </div>

<script>
$('.radio-group .radio').click(function(){
    $(this).parent().find('.radio').removeClass('selected');
    $(this).addClass('selected');
    var val = $(this).attr('data-value');
    var val1 = $(this).attr('data-discount');
    var val2 = $(this).attr('data-time');
    var val3 = $(this).attr('data-people');
    //alert(val);
    //$(this).parent().find('input').val(val);
    $(this).parent().find('.oid').val(val);
    $(this).parent().find('.discount').val(val1);
    $(this).parent().find('.time').val(val2);
    $(this).parent().find('.curpeople').val(val3);
});
</script>    
</body>
</html>

<script>

var ajax = new XMLHttpRequest();
var method = "GET";
var url="hoteldes.php?hid=<?php echo $hid?>";
var async = true;
ajax.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
        document.getElementById("hoteldes").innerHTML = this.responseText;
       }}
ajax.open(method,url,async);
ajax.send();

//Hotel Timings
var ajax = new XMLHttpRequest();
var method = "GET";
var url="timingdes.php?hid=<?php echo $hid?>";
var async = true;
ajax.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
        document.getElementById("timingdes").innerHTML = this.responseText;
       }}
ajax.open(method,url,async);
ajax.send();

// $('.carousel').carousel({
//     interval: false
// }); 
</script>