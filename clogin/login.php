<?php 

require('../config/db.php');
require('../config/config.php');
error_reporting(E_ERROR|E_PARSE);
session_start();

	
if(isset($_POST['submit'])){ 		//TO CHECK LOGIN BUTTON CLICK

if(empty($_POST['number']) || empty($_POST['password'])){  //THE FILEDS CANNOT BE EMPTY
echo "FILL ALL THE DETAILS".'<br>';
}

else{

$mobile=$_POST['number'];
$pass=md5($_POST['password']);

//$sql=" select * from clogin where cphno='$mobile' AND cpassword = '$pass' ";  //QUERY
$sql="select c.cid from customer as c INNER JOIN clogin as cl ON c.cphno=cl.cphno where cl.cphno='$mobile' AND cl.cpassword = '$pass'";

$result=mysqli_query($conn,$sql);	//PERFORMS THE QUERY AGAINST THE DATABASE
									//RETURNS mysqli_result OBJECT ON TRUE ELSE FALSE

$count=mysqli_num_rows($result);  	//RETURNS NUMBER OF ROWS IN RESULT SET



if($count == 1)
{
				//TO ACCESS THE DATA IN ANOTHER .PHP FILE
	$_SESSION['number']=$_POST['number'];
	$_SESSION['password']=$_POST['password'];
	$details = mysqli_fetch_array($result,MYSQLI_ASSOC);

		$_SESSION['cid'] = $details['cid'];
		$_SESSION['user_logged_in'] = true;
	

	header('location:'.ROOT_URL.'');	//REDIRECT TO SPECIFIED LOC:
}
else{
	echo "ENTER CORRECT NUMBER OR PASSWORD".'<br>';

}
}
}
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link href="https://fonts.googleapis.com/css?family=Sriracha" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
</head>
<body>
<!-- Navbar Starts -->
<nav class="navbar navbar-light fixed-top">
	<a href="../" class="navbar-brand brand">TABLO</a>
	<form class="form-inline">
		<?php if(!$_SESSION['user_logged_in']): ?>    
            <a href="rform.php" class="btn btn-info my-2 my-sm-0 mx-1">Signup</a>
            <a href="../clogin/login.php" class="btn btn-success my-2 my-sm-0 mx-1">Login</a>
            <?php else: ?>
            <a href="#" class="btn btn-info my-2 my-sm-0 mx-1">Profile</a>
            <a href="../logout.php" class="btn btn-success my-2 my-sm-0 mx-1">Logout</a>
            <?php endif; ?>
	</form>
</nav>
<!-- Navbar Ends -->
<div class="cover">
<div class="row">
<div class="col-md-6">
</div>
<div class="col-md-6">
<div class="jumbotron">
<h1 class="display-5" style="font-weight:150;">Login</h1>
<hr class="my-4">
 <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <div class="form-group">
    <label for="exampleInputEmail1">Phone Number</label>
    <input name="number" type="tel" class="form-control" id="exampleInputEmail1" placeholder="phone number">
    </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Login</button>
</form>
<!-- <hr class="my-4"> -->
<p class="lead" style="margin-top:5px;">Create an Account?<a href="../csignup/rform.php">Register</a></div>
</div>
</div>
</div>
</div>	

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>			 
</body>
</html>