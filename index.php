<?php
//Date(H:i)
require('config/config.php');
require('config/db.php');

error_reporting(E_ERROR|E_PARSE);
session_start();
$cid = $_SESSION['cid'];


$query = 'select hid,hname,hcategory,hlocation from hotel where hid IN (16,18,14,1) ORDER BY hname';
$result = mysqli_query($conn, $query);
$hotels = mysqli_fetch_all($result,MYSQLI_ASSOC);
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
    <title>TABLO</title>
    <link rel="stylesheet" href="styles/hstyles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Sriracha" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
            
                <header class="hero">
                <nav class="navbar-fixed-top">

                      <div class="menu-icon">
                            <i class="fa fa-bars fa-2x"></i>
                      </div>

                      <div class="logo">
                            TABLO
                      </div>

                      <div class="menu">
                            <ul>
                                  <li class="align-center1"><form class="form-inline my-2 my-lg-0">
                                    <?php if(!$_SESSION['user_logged_in']): ?>    
                                    <a href="csignup/rform.php" class="btn btn-info my-2 my-sm-0 mx-1">Signup</a>
                                    <a href="clogin/login.php" class="btn btn-success my-2 my-sm-0 mx-1">Login</a>
                                    <?php else: ?>
                                    <a href="cprofile/profile.php" class="btn btn-info my-2 my-sm-0 mx-1">Profile</a>
                                    <a href="logout.php" class="btn btn-success my-2 my-sm-0 mx-1">Logout</a>
                                    <?php endif; ?>
                                    <!-- <button href="#" class="btn btn-info my-2 my-sm-0 mx-1" type="submit">Signup</button>  
                                    <button class="btn btn-success my-2 my-sm-0 mx-1" type="submit">Login</button> -->
                                  </form></li>
                            </ul>
                      </div>
                         
                </nav>
                <div class="message"><h1>Dining out Tonight ?</h1>
                <h3>Book a table at your favorite Restaurant</h3></div>
                </header>

                <!-- Featured Hotels Section -->
                <div class="container">
                <div class="row py-3">
                <div class="col-md-6"><h3>Featured Hotels</h3></div>
                <div class="col-md-6"><a href="hotels/hotelcard.php" class="btn btn-danger" style="margin-left:450px">View All</a></div>
                </div>
                      <div class="row">
                        <?php foreach($hotels as $hotel) : ?>    
                        <div class="col-md-3">
                        <div class="card" style="width: 16rem;">
                        <img class="card-img-top" src="Dashboard/uploads/<?php echo $hotel['hid'];?>.jpg" onerror="this.style.display='none'">
                        <img class="card-img-top" src="Dashboard/uploads/<?php echo $hotel['hid'];?>.png" onerror="this.style.display='none'">
                        <img class="card-img-top" src="Dashboard/uploads/<?php echo $hotel['hid'];?>.jpeg" onerror="this.style.display='none'">
                        <!-- <img class="card-img-top" src=".../100px180/" alt="Card image cap"> -->
                        <!-- <div class="card-img-top"></div> -->
                        <div class="card-body">
                        <h5 class="card-title"><?php echo $hotel['hname'];?></h5>
                        <small class="light"><?php echo $hotel['hcategory'];?></small>
                        <p class="card-text">@ <?php echo $hotel['hlocation'];?></p>
                        <a href="hotels/booking.php?hid=<?php echo $hotel['hid'];?>" class="btn btn-danger">Book a Table</a>
                        </div>
                        </div>
                        </div>
                        <?php endforeach; ?>
                      </div>
                </div>
                <!-- Featured Hotels Section over -->


                  <div class="container">
                  <div class="row">
                        <div class="col-md-4">
                          <div class="stepsdisplay"></div>
                        </div>
                        <div class="col-md-4">
                          <div class="stepsdisplay"></div>
                        </div>
                        <div class="col-md-4">
                          <div class="stepsdisplay"></div>
                        </div>
                  </div>
                  </div>

                  </div>
		<div class="partner container-fluid">
		<div id="partnering" class="container">Partner with us<br><a href="Dashboard/welcome.php" class="btn btn-primary" style="font-size: 0.4em;border-radius: 15px">Join now</a></div></div>
	</div>


                
    <script type="text/javascript">

        // Menu-toggle button
  
        $(document).ready(function() {
              $(".menu-icon").on("click", function() {
                    $("nav ul").toggleClass("showing");
              });
        });
  
        // Scrolling Effect
  
        $(window).on("scroll", function() {
              if($(window).scrollTop()) {
                    $('nav').addClass('black');
                    $('li').removeClass('align-center1');
                    $('li').addClass('align-left1');


              }
  
              else {
                    $('nav').removeClass('black');
                    $('li').addClass('align-center1');
                    $('li').removeClass('align-left1');
              }
        })
  
  
        </script>

</body>
</html>