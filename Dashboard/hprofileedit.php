<?php 
session_start();

require('../config/db.php');
require('../config/config.php');
$hid=$_SESSION['id'];




$query = "SELECT * FROM hotel where hid=' ".$_SESSION['id']." ' ";

$res= mysqli_query($conn,$query);

$detailss= mysqli_fetch_array($res,MYSQLI_ASSOC);


if(isset($_POST['update'])){



	$name= $_POST['name'];
	$email= $_POST['email'];
	$loc= $_POST['location'];
	$des= $_POST['description'];
	$cat= $_POST['category'];
	$von= $_POST['von'];
	$web= $_POST['website'];
	$ph = $_POST['number'];
	$ppl = $_POST['people'];

	$query1= "UPDATE hotel
			  SET hname='$name',
			  hemail='$email',
			  hlocation='$loc',
			  hdescription='$des',
			  hcategory='$cat',
			  vegnonveg='$von',
			  hwebsite='$web',
			  people = '$ppl' 

			  WHERE
			  hid='".$_SESSION['id']."';
			  UPDATE offers SET people = '$ppl' where hid = '$hid';
			 ";

	$res1= mysqli_multi_query($conn,$query1);
	header("location: hprofile.php");




}

if (isset($_POST['cancel'])) {
	header("location: hprofile.php");
}



 ?>


<?php include('inc/header.php')?>
<style>
 .jumbotron{
	 margin-top:5%;
	 width:50%;
	 padding:20px;
 }
</style>	
	<div class="jumbotron mx-auto">
 	<form class="form-group" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
 		

 		NAME:<input class="form-control" type="text" name="name" value="<?php echo $detailss['hname'] ?>" >
 		<br>
 		EMAIL:<input class="form-control" type="text"  name="email" value="<?php echo $detailss['hemail'] ?>" >
 		<br>
 		LOCATION:<input class="form-control" type="text" name="location" value="<?php echo $detailss['hlocation'] ?>" >
 		<br>
 		DESCRIPTION:<input class="form-control" type="text"  name="description" value="<?php echo $detailss['hdescription'] ?>">
 		<br>
 		CATEGORY:<input class="form-control" type="text" name="category" value="<?php echo $detailss['hcategory'] ?>"  >
 		<br>
 		PHONE NO:<input  class="form-control" type="number" name="number" style="cursor: no-drop;" value="<?php echo $detailss['hphno'] ?>" readonly >
 		<br>
 		WEBSITE:<input class="form-control" type="text"  name="website"  value="<?php echo $detailss['hwebsite'] ?>" >
 		<br>
		 <select class="form-control" name="von">
		 <option value="1">VEG</option>
		 <option value="0">NON-VEG</option>
		 </select>
 		<br>
		People Capacity / Hr:<input type="text" class="form-control" name="people" value="<?php echo $detailss['people'] ?>">
 		<br>
 		<button class="btn btn-success my-2 my-sm-0"  type="submit" name="update">UPDATE</button>
 		<button class="btn btn-danger my-2 my-sm-0"  type="submit" name="cancel">CANCEL</button>
 		</div>
 	</form>
	 <?php include('inc/footer.php');?>