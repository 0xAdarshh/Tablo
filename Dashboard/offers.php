<?php
    require("../config/config.php");
    require("../config/db.php");
    //error_reporting(E_ERROR|E_PARSE);
    session_start();
    $hid = $_SESSION["id"];
    $ppl = 0;
    $oerr = " ";
    //after clicking Add button
    if(isset($_POST['add'])){
        //$hid=2; //temporary id
        $time1 = mysqli_real_escape_string($conn,$_POST['time']);
        $discount1 = mysqli_real_escape_string($conn,$_POST['discount']);

        $offer_check = "SELECT oid from offers where hid=$hid AND time='$time1'";
        $result1 = mysqli_query($conn,$offer_check);
        
        if(mysqli_num_rows($result1)){
            $oerr = "This Offer already exists please check !!!!";
        }
        else{
        //Query to insert offer details
        $query = "INSERT INTO OFFERS(hid,time,discount) VALUES('$hid','$time1','$discount1');";

        if(mysqli_query($conn,$query)){
            //be on same page
        }
        else{
            echo 'Error : ' . mysqli_error($conn);
        }
        }
    }

    //Query to display current running offers
    $query = "SELECT * FROM OFFERS where hid=$hid ORDER BY time";

    //fire the Query
    $result = mysqli_query($conn,$query);

    //get details into Details Array(Associative Array)
    $details = mysqli_fetch_all($result,MYSQLI_ASSOC);

    //Free Results
    mysqli_free_result($result);

    //FOR Update offer
    if(isset($_POST['update']))
    {
        $utime1 = mysqli_real_escape_string($conn,$_POST['utime']);
        $udiscount1 = mysqli_real_escape_string($conn,$_POST['udiscount']);
        $uoid1 = mysqli_real_escape_string($conn,$_POST['uoid']);

    $query = "UPDATE offers SET time = '$utime1', discount = '$udiscount1' where oid = {$uoid1}";

    if(mysqli_query($conn,$query)){
        //be on same page
        header('Location: http://localhost:8081/dbmsproject/Dashboard/offers.php');
    }
    else{
        echo 'Error : ' . mysqli_error($conn);
    }
        
    }

    //check for delete
    if(isset($_POST['delete'])){
        $delete_id = mysqli_real_escape_string($conn,$_POST['delete_id']);

        $query = "DELETE From offers where oid = {$delete_id}";

    if(mysqli_query($conn,$query)){
        header('Location: http://localhost:8081/dbmsproject/Dashboard/offers.php'); 
    } else {
        echo 'ERROR :' . mysqli_error($conn);
    }
    }


?>

<?php include('inc/header.php')?>
<style>
.inline { 
display: inline-block; 
margin:0px;
}

.scroll {
  height:400px;
  overflow-y: scroll;
}

html, body {
    max-width: 100%;
    overflow-x: hidden;
    overflow-y:hidden;
}
</style>
<div class="row">
    <div class="col-md-4">
        <h3 style="font-weight:400; margin-left:20px;">Add New Offer </h3>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']?>" style="margin-left:20px;">
        <label>Time</label> <!--selector for offer time-->
        <div class="input-group clockpicker" style="width:100px; text-align:center">
            <input name="time" type="text" class="form-control" value="" autocomplete="off">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-time"></span>
            </span>
        </div>
        <Label>Discount(in %)</Label>
        <input class="form-control" type="text" name="discount">
        <br>
        <small style="color:red;"><?php echo $oerr;?></small><br>
        <input class="btn btn-success my-2 my-sm-0" name="add" type="submit" value="ADD">
        </form>
        <hr>
    </div>
    <div class="col-md-8">
    <!-- Display current data -->
    <h2 style="font-weight:400;">Currently Running Offers</h2>
    <div class="scroll">
        <?php foreach($details as $detail) : ?>
        <form action="<?php $_SERVER['PHP_SELF'];?>" method="post" style ='float: left; padding: 5px;'>
        <div class="inline">
        <label style="margin-top:20px;">Time</label> <!--selector for offer time-->
        <div class="input-group clockpicker" style="width:100px; text-align:center">
            <input name="utime" readonly type="text" class="form-control" value="<?php echo $detail['time'];?>" autocomplete="off">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-time"></span>
            </span>
        </div>
        </div>
        <div class="inline">
        <Label>Discount(in %)</Label>
        <input class="form-control" type="text" name="udiscount" value="<?php echo $detail['discount'];?>">
        <input  type="hidden" name="uoid" value="<?php echo $detail['oid'];?>">
        </div>
        <div class="inline">
        <input class="btn btn-warning mx-2" name="update" type="submit" value="UPDATE">
        </form>
        <form style="float:right" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style ='float: left; padding: 5px;'>
            <input type="hidden" name="delete_id" value="<?php echo $detail['oid'];?>">
            <input class="btn btn-danger mx-2" type="submit" name="delete" value="DELETE"></form>
        </div> 
        <?php endforeach; ?>
    </div>
    </div>
</div>
<?php include('inc/footer.php');?>