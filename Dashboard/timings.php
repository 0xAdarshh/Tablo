<?php

    require('../config/config.php');
    require('../config/db.php');

    session_start();
    $hid = $_SESSION["id"];

    //after submit click
    if(isset($_POST['submit'])){
        //$hid = 2;//here the hotel id will be comming from Session (this id is used on temporary basis)
        $day1 = (int)mysqli_real_escape_string($conn,$_POST['day']); 
        $status1 = (int)mysqli_real_escape_string($conn,$_POST['status']); 
        $otime1 = mysqli_real_escape_string($conn,$_POST['otime']);
        $ctime1 = mysqli_real_escape_string($conn,$_POST['ctime']);

        //Query to retrive all timings of hotel of (hid)
        $query = "INSERT INTO hoteltime(hid,day,status,stime,etime) VALUES('$hid','$day1','$status1','$otime1','$ctime1')";

        if(mysqli_query($conn,$query)){
           // header('Location: '.ROOT_URL.''); 
           header('Location: http://localhost:8081/dbmsproject/Dashboard/timings.php');
         } else {
             echo 'ERROR :' . mysqli_error($conn);
         }
         }

    // Query to display current timing data
    $query = "select * from hoteltime where hid=$hid ORDER BY day";

    //Fire the Query
    $result = mysqli_query($conn, $query);

    //Get data into deatails object array (Associative Array)
    $details = mysqli_fetch_all($result,MYSQLI_ASSOC);

    //Free result
    mysqli_free_result($result);

?>

<?php include('inc/header.php')?>
<style>
table,th,tr,td{
        border: 1px solid black;
        padding: 5px;
    }
html, body {
    max-width: 100%;
    overflow-x: hidden;
    overflow-y:hidden;
}
</style>
    <div class="row">
        <div class="col-md-6">
<div class="jumbotron mx-auto" style="margin-top:5%; width:70%; padding:20px;">
<h3 style="font-weight:200;">Add your week timing details</h3>
<form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
<label>Day</label> <!--selector of day-->
<select class="form-control" name="day" value="">
  <option value="1">Sunday</option>
  <option value="2">Monday</option>
  <option value="3">Tuesday</option>
  <option value="4">Wednesday</option>
  <option value="5">Thursday</option>
  <option value="6">Friday</option>
  <option value="7">Saturday</option>
</select>
<br>
<label>Status</label>
<select class="form-control" name="status" value="">
<option value="1">OPEN</option>
<option value="0">CLOSED</option>
</select>
<br>
<label>Opens at</label> <!--selector for opening time-->
<div class="input-group clockpicker" style="width:100px">
    <input name="otime" type="text" class="form-control" value="" autocomplete="off">
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-time"></span>
    </span>
</div>
<label>Closes at</label> <!--selector for closing time-->
<div class="input-group clockpicker" style="width:100px">
    <input name="ctime" type="text" class="form-control" value="" autocomplete="off">
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-time"></span>
    </span>
</div>
<br>
<input class="btn btn-success my-2 my-sm-0" name="submit" type="submit" value="submit">
</form>
        </div>
        </div>
        <div class="col-md-6">
            <div class="jumbotron mx-auto" style="margin-top:5%; width:80%; padding:10px;">
<!-- Display current data -->
<table>
         <tr>
            <th>HID</th>
            <th>Day</th>
            <th>STATUS</th>
            <th>OPENS</th>
            <th>CLOSES</th>
         </tr>
     <?php foreach($details as $detail) : ?>
     <div>
         <tr>
        <td><?php echo $detail['hid']; ?></td>
        <td><?php 
        if($detail['day'] == '1'){ echo 'Sunday'; }
        elseif($detail['day'] == '2'){ echo 'Monday'; }
        elseif($detail['day'] == '3'){ echo 'Tuesday'; }
        elseif($detail['day'] == '4'){ echo 'Wednesday'; }
        elseif($detail['day'] == '5'){ echo 'Thursday'; }
        elseif($detail['day'] == '6'){ echo 'Friday'; }
        elseif($detail['day'] == '7'){ echo 'Saturday'; }
        ?></td>
        <td><?php if($detail['status'] == '0'){echo 'CLOSED';}else{ echo 'OPEN';} ?></td>
        <td><?php if($detail['status'] == '1'){echo $detail['stime'];} ?></td>
        <td><?php if($detail['status'] == '1'){echo $detail['etime'];} ?></td>
        </tr> 
     </div><br>
<?php endforeach; ?>
</table>
        </div>
        </div>
        </div>  
<?php include('inc/footer.php');?>
