<?php
require('../config/db.php');
require('../config/config.php');
error_reporting(E_ERROR|E_PARSE);
session_start();
$errors=array();
$perror="";
$uerror="";
$eerror="";
$pherror="";
$passerror="";

if(isset($_POST['register_btn']))  {
	$username = mysqli_real_escape_string($conn,$_POST['username']);
	$phno = mysqli_real_escape_string($conn,$_POST['phno']);
	$email = mysqli_real_escape_string($conn,$_POST['email']);
	$password = mysqli_real_escape_string($conn,$_POST['password']);
	$confirmpass = mysqli_real_escape_string($conn,$_POST['confirmpass']);


	$user_check_query = "SELECT * FROM clogin WHERE cphno='$phno' LIMIT 1";
  	$result = mysqli_query($conn, $user_check_query);
  	$user = mysqli_fetch_assoc($result);

  	if (empty($username)) { $uerror="Username is required"; }
  	if (empty($phno)) { $pherror="Phone Number is required"; }
  if (empty($email)) { $eerror="Email is required"; }
  if (empty($password)) { $passerror="Password is required"; }
  
	if ($user) { 																					// if user exists
	    if ($user['phno'] == $phno) {
	      array_push($errors, "Phone Number Already Exists");
	    }

	    // if ($user['email'] == $email) {
	    //   array_push($errors, "E-Mail Already Exists");
	    // }
	}
	if($password == $confirmpass){
		if(count($errors)==0 && $uerror=="" && $pherror=="" && $eerror=="" && $passerror==""){
		$password = md5($password);  //Hash Password before storing for security purpose
		//$password = $password;
		$sql ="INSERT INTO clogin(cphno,cpassword) VALUES('$phno','$password');INSERT INTO customer(cusername,cphno,cemail) VALUES('$username','$phno','$email');";
		// $sql .= "INSERT INTO customer(cusername,cphno,cemail) VALUES('$username','$phno','$email');";
		mysqli_multi_query($conn,$sql);
		header('location: '.ROOT_URL.'');   //Jump to page after successful login;	
		}
		
	}else{
		
		$perror="Passwords did not match";

	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>User Registration</title>
	<link rel="stylesheet" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Sriracha" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
	<!-- NAvBAr Starts -->
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
	<div class="row">
	<div class="col-md-6"></div>
	<div class="col-md-6">
	<div class="jumbotron">
	<h1 class="display-5" style="font-weight:150;">Register</h1>
	<form method="post" action="rform.php">
	<?php include('errors.php'); ?>	
			<div class="form-group"><label>Name:</label> * <input type="text" name="username" class="form-control" placeholder="Enter your Name" required></div>
			<div class="form-row">
			<div class="form-group col-md-4"><label>PhoneNumber:</label>  * <input type="text" name="phno" class="form-control" placeholder="Phone Number"></div>
			<div class="form-group col-md-8"><label>E-Mail Id:</label>  * <input type="email" name="email" class="form-control" placeholder="e-mail"></div>
			</div>
			<div class="form-row">
			<div class="form-group col-md-6"><label>Password:</label>  * <input type="Password" name="password" class="form-control" placeholder="Enter Password" value=""></div>
			<div class="form-group col-md-6"><label>Confirm Password:</label>  * <?php echo $perror; ?><input type="Password" name="confirmpass" class="form-control" placeholder="Confirm Password" value=""></div>
			</div>
			<input type="submit" name="register_btn" value="Register" class="btn btn-info">
	</form>
	<!-- <hr class="my-4">	 -->
	<p class="lead" style="margin-top:5px;">Already have an Account?<a href="../clogin/login.php">Login</a></div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

<?//php echo $uerror; ?>
<?//php echo $pherror; ?>
<?//php echo $eerror; ?>
<?//php echo $passerror; ?>
