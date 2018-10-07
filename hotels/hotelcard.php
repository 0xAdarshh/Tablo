<?php
    require('../config/config.php');
    require('../config/db.php');
    error_reporting(E_ERROR|E_PARSE);
    session_start();
    $cid = $_SESSION['cid'];

    // create query
    $query = 'select hid,hname,hcategory,hlocation from hotel ORDER BY hname';

    //get results
    $result = mysqli_query($conn, $query);

    //fetch data
    $hotels = mysqli_fetch_all($result,MYSQLI_ASSOC);

    //Free result
    mysqli_free_result($result);

    //close connection
    mysqli_close($conn);

    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Sriracha" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Hotels</title>
</head>
<body>
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
<div class="container rounded">
    <div class="row">
    <?php foreach($hotels as $hotel) : ?>    
    <div class="col-md-4">
    <div class="card" style="width: 18rem;">    
    <img class="card-img-top" src="../Dashboard/uploads/<?php echo $hotel['hid'];?>.jpg" onerror="this.style.display='none'">
    <img class="card-img-top" src="../Dashboard/uploads/<?php echo $hotel['hid'];?>.png" onerror="this.style.display='none'">
    <img class="card-img-top" src="../Dashboard/uploads/<?php echo $hotel['hid'];?>.jpeg" onerror="this.style.display='none'">
    <!-- <img class="card-img-top" src=".../100px180/" alt="Card image cap"> -->
    <!-- <div class="card-img-top"></div> -->
    <div class="card-body">
    <h5 class="card-title"><?php echo $hotel['hname'];?></h5>
    <small class="light"><?php echo $hotel['hcategory'];?></small>
    <p class="card-text">@ <?php echo $hotel['hlocation'];?></p>
    <a href="booking.php?hid=<?php echo $hotel['hid'];?>" class="btn btn-danger">Book a Table</a>
    </div>
    </div>
</div>
<?php endforeach; ?>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>			 
</body>
</html>