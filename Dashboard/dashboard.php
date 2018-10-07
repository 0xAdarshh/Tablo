<?php
require("../config/config.php");
require("../config/db.php");

session_start();
$hid = $_SESSION["id"];
$tdate = date('Y/m/d');
date_default_timezone_set('Asia/Kolkata');
$hr =  date('H');
// $hr1 = $hr + 1;
// $hr2 = $hr1 + 1;
$hr3 = $hr + 3;
$hr =  date('H').":00";
// $_hr = date('H').":30";
// $_hr1 =  $hr1.":30";
// $hr1 = $hr1.":00";
// $_hr2 = $hr2.":30";
// $hr2 = $hr2.":00";
$hr3 = $hr3.":00";
$tdate = date('Y/m/d');
//echo $hr." ".$hr1." ".$hr2;

//$query = "SELECT * FROM bookings where time IN ('$hr','$hr1','$hr2') ORDER BY time";
$query = "SELECT b.bid,b.date,b.time,b.discount,b.people,b.status,c.cusername,c.cphno from bookings as b inner join customer as c on b.cid=c.cid where (b.time between '$hr' AND '$hr3') AND b.hid='$hid' AND b.date='$tdate' AND b.status=1 order by b.time"; 
$result = mysqli_query($conn,$query);
$bookings = mysqli_fetch_all($result,MYSQLI_ASSOC);


//FOR Confirm status
if(isset($_POST['confirm']))
{
    $bid1 = mysqli_real_escape_string($conn,$_POST['confirm_id']);
    $time1 = mysqli_real_escape_string($conn,$_POST['confirm_time']);   
    $stat = 3;

    $res = mysqli_query($conn,"SELECT bid from bookings where time = '$time1' and status='1';");
    if(mysqli_num_rows($res)==1){
    $people1 = mysqli_query($conn,"SELECT people from hotel where hid = '$hid';");
    $ppl = mysqli_fetch_assoc($people1); 

    $query = "UPDATE bookings SET status = '$stat' where bid = {$bid1};UPDATE offers SET people = '{$ppl["people"]}' where hid = {$hid} AND time = '$time1';";

    if(mysqli_multi_query($conn,$query)){
        //be on same page
        header('Location: dashboard.php');
    }
    else{
        echo 'Error : ' . mysqli_error($conn);
    }
    }else{
    //attended the booking
    $query = "UPDATE bookings SET status = '$stat' where bid = {$bid1}";

    if(mysqli_query($conn,$query)){
        //be on same page
        header('Location: dashboard.php');
    }
    else{
        echo 'Error : ' . mysqli_error($conn);
    }
    }
    
}

//FOR Cancel status
if(isset($_POST['cancel']))
{
    $bid1 = mysqli_real_escape_string($conn,$_POST['cancel_id']);
    $time1 = mysqli_real_escape_string($conn,$_POST['cancel_time']);  
    $stat = 2;

    $res = mysqli_query($conn,"SELECT bid from bookings where time = '$time1' and status='1';");
    if(mysqli_num_rows($res)==1){
    $people1 = mysqli_query($conn,"SELECT people from hotel where hid = '$hid';");
    $ppl = mysqli_fetch_assoc($people1); 

    $query = "UPDATE bookings SET status = '$stat' where bid = {$bid1};UPDATE offers SET people = '{$ppl["people"]}' where hid = {$hid} AND time = '$time1';";

    if(mysqli_multi_query($conn,$query)){
        //be on same page
        header('Location: dashboard.php');
    }
    else{
        echo 'Error : ' . mysqli_error($conn);
    }
    }else{
        //missed the booking
        $query = "UPDATE bookings SET status = '$stat' where bid = {$bid1}";

        if(mysqli_query($conn,$query)){
            //be on same page
            header('Location: dashboard.php');
        }
        else{
            echo 'Error : ' . mysqli_error($conn);
        }
        }
}


?>
<?php include('inc/header.php')?>
<style>
.scroll {
  width:80%;
  height:400px;
  overflow-y: scroll;
  overflow-x:hidden;
  border:1px solid gray;
  background:#DAE0E2;
}

table,th,tr,td{
        border-bottom: 1px solid gray!important;
    }

html, body {
    max-width: 100%;
    overflow-x: hidden;
    overflow-y:hidden;
}

.message{
    text-align:center;
}

.message h1{
    font-size:80px;
    font-weight:100;
    margin-top:150px;
}
</style>    

<h1 style="font-weight:200;">Welcome to the Dashboard</h1>
<?php echo $hid;?>
<div class="scroll mx-auto">
<?php if(mysqli_num_rows($result)){ ?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">NAME</th>
      <th scope="col">CONTACT</th>
      <th scope="col">TIME</th>
      <th scope="col">DISCOUNT</th>
      <th scope="col">SEATS</th>
      <th scope="col">CONFIRM</th>
      <th scope="col">CANCEL</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($bookings as $booking) : ?>
    <tr>
      <td style="text-transform:uppercase;"><?php echo $booking['cusername'];?></td>
      <td>+91 <?php echo $booking['cphno'];?></td>
      <td>@ <?php echo $booking['time'];?></td>
      <td><?php echo $booking['discount'];?> %</td>
      <td><?php echo $booking['people'];?></td>
      <td><form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <input type="hidden" name="confirm_time" value="<?php echo $booking['time'];?>">
            <input type="hidden" name="confirm_id" value="<?php echo $booking['bid'];?>">
            <input class="btn btn-success" type="submit" name="confirm" value="CONFIRM">
        </form></td>
      <td><form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <input type="hidden" name="cancel_time" value="<?php echo $booking['time'];?>">
            <input type="hidden" name="cancel_id" value="<?php echo $booking['bid'];?>">
            <input class="btn btn-danger mx-2" type="submit" name="cancel" value="CANCEL">
        </form></td>
    </tr>
    <?php endforeach; ?> 
  </tbody>
</table>
<?php } else{ ?>
<div class="message"><h1 style="color:gray;">No Bookings Yet :(</h1></div>
<?php } ?>
</div>

<?php include('inc/footer.php');?>


