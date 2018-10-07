<?php 
	require('../config/db.php');
	require('../config/config.php');
	session_start();
	$cid = $_SESSION['cid'];
	//$query = "SELECT bid,hid,date,time,rating FROM bookings WHERE cid = '{$cid}' and time < CURTIME() ORDER BY date DESC";
	$query = "SELECT bid,hid,date,time,rating FROM bookings WHERE cid = '{$cid}' and status IN(0,2,3);";
	$result  = mysqli_query($conn,$query);
	$num = mysqli_num_rows($result);

	//$query1 = "SELECT bid,hid,date,time,rating FROM bookings WHERE cid = '{$cid}' and time >= CURTIME() ORDER BY date DESC";
	$query1 = "SELECT bid,hid,date,time,rating FROM bookings WHERE cid = '{$cid}' and status = 1";
	$result1  = mysqli_query($conn,$query1);
	$num1 = mysqli_num_rows($result1);


?>

<!DOCTYPE html>
<html>
<head>
	<title>TABLO</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	 	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
 		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	 	<style>
			.glyphicon-star{
		 		color: #E4E4E4;
		 		font-size: 2vw;
		 	} 

		 	.rate-hover{
		 		cursor: pointer;
		 		color: #094D7A;
		 	}
		 	.rate-chosen{
		 		color: #BDF53D;
		 	}

		 	.tab-elm{
		 		margin-left:10em;
		 	}
		 	

	 	</style>
</head>
<body class="container">

	<h1>Upcoming Orders: </h1>
	<?php if($num1== 0): ?>
	<div class="container">
		No New Orders to show. 
	</div>
	<?php else: ?>

	<div>
	<table class="table table-hover">
	<tr>
		<th>Booking id</th>
		<th>Hotel</th>
		<th>Time</th>
		<th>Status</th>
	</tr>	
	<?php while($row1 = mysqli_fetch_assoc($result1)){  ?>
		<div class="container content" style="'background-color: blue;color: white">
			<tr>		
			<td><div id="tab-elm"><?php echo $row1["bid"];?></div></td>
			<td><div id="tab-elm" ><?php $hotel1 = mysqli_query($conn,"SELECT hname FROM hotel WHERE hid = '{$row1["hid"]}'"); $hot = mysqli_fetch_assoc($hotel1);echo $hot["hname"]; ?></div></td>
			<td><div id="tab-elm"><?php echo $row1["time"];?></div></td>
			<td><button id="<?php echo $row1["bid"] ?>" class="cancel btn btn-danger">Cancel</button></td>
			</tr>
		 </div>
	
	<?php  }?>
	<?php endif; ?>
	</table></div>
<!-------------------------------------------------------------------------------->
	<h1>Previous Orders:</h1> 
	<?php if($num== 0): ?>
	<div class="container">
		No Previous Orders to show. 
	</div>
	<?php else: ?>
	<div>
	<table class="table table-hover">
	<tr>
		<th>Booking id</th>
		<th>Hotel</th>
		<th>Date</th>
		<th>Rating</th>
	</tr>	
	<?php while($row = mysqli_fetch_assoc($result)){  ?>
		<div class="container content" style="'background-color: blue;color: white">
			<tr>		
			<td><div id="tab-elm"><?php echo $row["bid"];?></div></td>
			<td><div id="tab-elm" ><?php $hotel = mysqli_query($conn,"SELECT hname FROM hotel WHERE hid = '{$row["hid"]}'"); $hot = mysqli_fetch_assoc($hotel);echo $hot["hname"]; ?></div></td>
			<td><div id="tab-elm"><?php echo $row["date"]."[".$row["time"]."]";?></div></td>
			<td><div id="rating-container" class="<?php echo $row["bid"]; ?>">
		  	<div id="1" class="glyphicon glyphicon-star"></div>
		  	<div id="2" class="glyphicon glyphicon-star"></div>
		  	<div id="3" class="glyphicon glyphicon-star"></div>
		  	<div id="4" class="glyphicon glyphicon-star"></div>
		  	<div id="5" class="glyphicon glyphicon-star"></div>
		  	<div class="end"></div>
		 	</div>
		 	</td>
		 	</tr>
		 </div>
	<?php  }?>
	<?php endif; ?>
	</table></div>


	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

	<script>
	 	$(function(){
	 		$('.cancel').on('click',function(){
	 			var bid = $(this).attr("id");
	 			$.ajax({
      					type : "POST",
      					url : "ajaxcancel.php",
      					data: {v0 : bid},      					
      					success: function (status) {
      						if(status==1)
      						{
      							alert("Successfully cancelled your booking!");
      							location.reload();
      						}
      						else
      							alert("failed");

      					}
    				});

	 		})


	 		$('.glyphicon-star').on({
	 			mouseenter:function(){			
	 				$(this).addClass('rate-hover').prevUntil('rating-container').addClass('rate-hover');
	 			},
	 			mouseleave:function(){
	 				$(this).removeClass('rate-hover').prevUntil('rating-container').removeClass('rate-hover');

	 			},
	 			click:function(){
	 				var rating = $(this).attr('id');
      				var id = $(this).parent().attr("class");
      				alert(id);
      				
	 				
	 				$(this).removeClass('rating-chosen').nextUntil('end').removeClass('rate-chosen').prevUntil('rating-container').removeClass('rate-chosen');
	 				$(this).addClass('rate-chosen').prevUntil('rating-container').addClass('rate-chosen');
	 				$.ajax({
      					type : "POST",
      					url : "ajax.php",
      					data: {v1 : id, v2 : rating},      					
      					success: function () {}
    				});
	 			}
	 		

	 		});

 		})



 

 	</script>


</body>
</html>