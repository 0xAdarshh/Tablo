<?php

	require('../config/config.php');
	require('../config/db.php');

	$email_err = $name_err = $pass_err = $website_err = $contact_err ="";
	$f = 1;
	if(filter_has_var(INPUT_POST, 'submit'))
	{
		if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["contact"]) && isset($_POST["website"]) && isset($_POST["description"]) && isset($_POST["pass_confirm"]) && isset($_POST["password"]) && isset($_POST["location"]) && isset($_POST["category"]))
		{
			$email = mysqli_real_escape_string($conn,$_POST['email']);
			$name = mysqli_real_escape_string($conn,$_POST['name']);
			$contact = mysqli_real_escape_string($conn,$_POST['contact']);
			$desc = mysqli_real_escape_string($conn,$_POST['description']);
			$website = mysqli_real_escape_string($conn,$_POST['website']);
			$password = mysqli_real_escape_string($conn,$_POST['password']);
			$pass_confirm = mysqli_real_escape_string($conn,$_POST['pass_confirm']);
			$location = mysqli_real_escape_string($conn,$_POST['location']);
			$category = mysqli_real_escape_string($conn,$_POST['category']);
			$address = mysqli_real_escape_string($conn,$_POST['address']);

			$msg = "PASS";

			if($_SERVER["REQUEST_METHOD"]=="POST")
			{
				if(!(empty($name) || empty($email) || empty($contact) || empty($desc) || empty($website) || empty($password) || empty($pass_confirm) || empty($pass_confirm) || empty($category)))
				{
					$email = filter_var($email, FILTER_SANITIZE_EMAIL);
					$website = strpos($website, 'http') !== 0 ? "https://$website" : $website;
					$website = filter_var($website, FILTER_SANITIZE_URL);
					
					if(!preg_match("/^[a-zA-Z0-9 ]*$/",$name)){
						$name_err = "name invalid";	$f = 0;
					}

					if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
						$email_err = "*email not valid"; $f = 0;
					}

					if($password!=$pass_confirm){
						$pass_err = "*passwords do not match";$f = 0;
					}

					if((strlen((string)$contact)==10) && (preg_match("/^[789]\d{9}$/",$contact)))
					{
						$query = "SELECT Name FROM hlogin WHERE hphno = '{$contact}'";
			   			$result = mysqli_query($conn,$query);
		   				$count = mysqli_num_rows($result);
		   				if($count)
		   				{
		   					$contact_err = "Contact already exists"; 
		   					$f=0;
		   				}
		   			}
		   			else{
							$contact_err = "*invalid contact"; 
							$f=0;
					}

					if(!filter_var($website,FILTER_VALIDATE_URL)){
						$website_err = "*website not valid"; $f =0;
					}

					if($f == 1){
						$query = "INSERT INTO hlogin (hphno,hpassword)VALUES ('$contact','$password');INSERT INTO hotel (hname,hemail,hlocation,hdescription,haddress,hcategory,hphno,hwebsite)VALUES ('$name','$email','$location','$desc','$address','$category','$contact','$website');";
						if(mysqli_multi_query($conn,$query))
							header("Location:../Dashboard/dashboard.php");
						else
							echo "error during account creation";
					}

				}
				else
				{
					$msg = "*Please fill all details";
					$msgClass = 'alert-danger';
				}
			}
		}
	}


?>

<!DOCTYPE html>
<html>
<head>
	<title>SIGN UP</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
</head>
<body>
			<!-- Navbar Starts -->
			<nav class="navbar navbar-light fixed-top">
				<a href="../" class="navbar-brand brand">TABLO</a>
				<form class="form-inline">
						<a href="../clogin/login.php" class="btn btn-primary my-2 my-sm-0 mx-1">Login</a>
				</form>
			</nav>
			<!-- Navbar Ends -->
			<div class="hero">
			<div class="row">
			<div class=" head col-md-6">
			</div>
			<div class="col-md-6">		
			<div class="jumbotron">
			<h1 class="display-5" style="font-weight:150;">Register</h1>
			<div class="container" id="content">
					<?php if(isset($msg) && $msg != "PASS"):?>
				<div id="msg" class="alert <?php echo $msgClass;?>">
					<?php echo $msg;?></div>
					<?php endif;?>
				<form id="carform" method="POST" action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>">
				<div class="form-group">Hotel Name: <input title="contains only alphabets" class="form-control" type="text" name="name"><?php echo $name_err; ?></div>
				<div class="form-group">Email: <input title="" class="form-control" type="text" name="email"><?php echo $email_err;?></div>
				<div class="form-group">Area:
				<select class="form-control" name="location" form="carform">
					<option value = "Deccan">Deccan</option>
					<option value = "Shivajinagar">Shivajinagar</option>
					<option value = "Kothrud">Kothrud</option>
					<option value = "Hadapsar">Hadpasar</option>
					<option value = "Hinjewadi">Hinjewadi</option>
					<option value = "Kondhwa">Kondhwa</option>
					<option value = "Katraj">Katraj</option>
				</select></div>
				<div class="form-group">Address: <input title="Enter Address" class="form-control" type="text" name="address"> </div>
				<div class="form-row">
				<div class="form-group col-md-6">Description For Your Hotel: <input title="Enter description" class="form-control" type="text" name="description"></div>
				<div class="form-group col-md-6">Category: <input title="Enter category" class="form-control" type="text" name="category"></div>
				</div>
				<div class="form-row">
				<div class="form-group col-md-6">Mobile: <input title="Enter mobile number(helpful for sms alerts)" class="form-control" type="number" name="contact"><?php echo $contact_err;?></div>
				<div class="form-group col-md-6">Website: <input title="Enter website" class="form-control" type="text" name="website"><?php echo $website_err?></div>
				</div>
				<div class="form-row">
				<div class="form-group col-md-6">Password: <input title="Type a password" class="form-control" type="password" name="password"></div>
				<div class="form-group col-md-6">Confirm Password: <input title="Confirm password " class="form-control" type="password" name="pass_confirm"><?php echo $pass_err; ?></div>
				</div>
				<input class="btn btn-info" type="submit" name="submit">
				</form>
			</div>
			<p class="lead">Already have an Account?<a href="../hlogin/login.php">Login</a></div>
				</div>
				</div>
				</div>
				</div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>			
</body>
</html>