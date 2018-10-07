<?php 

require('../config/db.php');
require('../config/config.php');

	
if(isset($_POST['submit'])){ 		//TO CHECK LOGIN BUTTON

if(empty($_POST['number']) || empty($_POST['password'])){  //THE FILEDS CANNOT BE EMPTY
echo "FILL ALL THE DETAILS".'<br>';
}

else{

$mobile=$_POST['number'];
$pass=$_POST['password'];

//$sql=" select * from hlogin where hphno='$mobile' AND hpassword = '$pass' ";  //QUERY
$sql="select h.hid from hotel as h INNER JOIN hlogin as hl ON h.hphno=hl.hphno where hl.hphno='$mobile' AND hl.hpassword = '$pass'";  //QUERY

$result=mysqli_query($conn,$sql);	//PERFORMS THE QUERY AGAINST THE DATABASE
									//RETURNS mysqli_result OBJECT ON TRUE ELSE FALSE

$count=mysqli_num_rows($result);  	//RETURNS NUMBER OF ROWS IN RESULT SET



if($count == 1)
{
	session_start();				//TO ACCESS THE DATA IN ANOTHER .PHP FILE
	$_SESSION['number']=$_POST['number'];
	$_SESSION['password']=$_POST['password'];
	$details = mysqli_fetch_array($result,MYSQLI_ASSOC);

		$_SESSION['id'] = $details['hid'];
	

	header("Location:../Dashboard/dashboard.php");	//REDIRECT TO SPECIFIED LOC:
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
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="styles.css">
	<title>Login form</title>
</head>
<body>
  <!-- Navbar Starts -->
<nav class="navbar navbar-light fixed-top">
	<a href="../" class="navbar-brand brand">TABLO</a>
	<form class="form-inline">    
            <a href="../hsignup/signup.php" class="btn btn-info my-2 my-sm-0 mx-1">Signup</a>
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
 <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <div class="form-group">
    <label for="exampleInputEmail1">Phone Number</label>
    <input name="number" type="tel" class="form-control" id="exampleInputEmail1" placeholder="phone no">
    </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Login</button>
</form>
<p class="lead" style="margin-top:5px;">Create an Account?<a href="../hsignup/signup.php">Register</a></div>
</div>
</div>
</div>
</div>	




 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>			 
</body>
</html>