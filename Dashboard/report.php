<?php
require("../config/config.php");
require("../config/db.php");

session_start();
$hid = $_SESSION['id'];

if(isset($_POST['getreport']))
{
    $_SESSION['$datef'] = mysqli_real_escape_string($conn,$_POST['from']);
    $_SESSION['$datet'] = mysqli_real_escape_string($conn,$_POST['to']);
    header('Location:reportpdf.php');
}    
?>
<?php include('inc/header.php')?>
    <style>
    .jumbotron{
        width:25%;
        margin-top:7%;
        padding:2%;
    }
    body,html{
        overflow-y:hidden;
    }
    label{margin-left: 20px;}
    #datepicker,#datepickert{width:180px; margin: 0 20px 20px 20px;}
    #datepicker,#datepickert > span:hover{cursor: pointer;}
    </style>

    <div class="jumbotron mx-auto">
    <h2 style="margin-bottom:10px; font-weight:200;">Generate Report</h2>
    <form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
    <label>From: </label>
    <div id="datepicker" class="input-group date" data-date-format="yyyy/mm/dd">
        <input class="form-control" name="from" type="text" readonly />
        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
    </div>
    <label>To: </label>
    <div id="datepickert" class="input-group date" data-date-format="yyyy/mm/dd">
        <input class="form-control" name="to" type="text" readonly />
        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
    </div>
    <br>
    <input class="btn btn-success mx-4" name="getreport" type="submit" value="GET REPORT">
    </form>
    </div>

    <?php include('inc/footer.php');?>

<script>
$(function () {
$("#datepicker").datepicker({ 
    autoclose: true, 
    todayHighlight: true
}).datepicker('update', new Date());
});

$(function () {
$("#datepickert").datepicker({ 
    autoclose: true, 
    todayHighlight: true
}).datepicker('update', new Date());
});
</script>