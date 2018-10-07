<?php

require("../config/config.php");
require("../config/db.php");

session_start();
$hid = $_SESSION['id'];

$ddate1 = date('Y')."/".date('m')."/01";
$m2 =date('m')+1;
$ddate2 = date('Y')."/".$m2."/01";

if(isset($_POST['getdata']))
{
    $datef = mysqli_real_escape_string($conn,$_POST['from']);
    $datet = mysqli_real_escape_string($conn,$_POST['to']);

$query = "SELECT date,count(bid) from bookings where hid = $hid AND (date BETWEEN '$datef' AND '$datet')  group by date;";
$result = mysqli_query($conn,$query);
$bookings = mysqli_fetch_all($result,MYSQLI_ASSOC);
}
else{
    $query = "SELECT date,count(bid) from bookings where hid = $hid AND (date BETWEEN '$ddate1' AND '$ddate2')  group by date;";
    $result = mysqli_query($conn,$query);
    $bookings = mysqli_fetch_all($result,MYSQLI_ASSOC);
}
?>

<?php include('inc/header.php')?>
    <style>
    body,html{
        overflow-y:hidden;
    }
    label{margin-left: 20px;}
    #datepicker,#datepickert{width:180px; margin: 0 20px 20px 20px;}
    #datepicker,#datepickert > span:hover{cursor: pointer;}
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          
          ['Date', 'Bookings'],
          //foreach
          <?php foreach($bookings as $booking) :?>
          ['<?php echo $booking['date'];?>',<?php echo $booking['count(bid)'];?> ],
          //ensdforeach
          <?php endforeach ?>
        //   ['Nov',  1170],
        //   ['Dec',  660],
        //   ['Jan',  1030],
        //   ['Feb',  1000]
        ]);

        var options = {
          title: 'Daily Hotel Booking Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>

      <div class="row">
      <div class="col-md-4">
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
    <input class="btn btn-success mx-4" name="getdata" type="submit" value="SHOW GRAPH">
    </form>
    </div>
    <div class="col-md-6">
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
    </div>
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