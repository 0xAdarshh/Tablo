<?php 
	
session_start();
require('../config/db.php');
require('../config/config.php');

$query = "SELECT * FROM hotel where hid=' ".$_SESSION['id']." ' ";
$res= mysqli_query($conn,$query);
$detailss= mysqli_fetch_array($res,MYSQLI_ASSOC);

if(isset($_POST['edit'])){
		header("location: hprofileedit.php");
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
 		<button class="btn btn-primary my-2 my-sm-0" style="float: right" type="submit" name="edit">EDIT</button>
 		<br>

 		Name:<input class="form-control" type="text" name="name" style="cursor: no-drop;" value="<?php echo $detailss['hname'] ?>" readonly >
 		<br>
 		Email:<input type="text" class="form-control" name="email" style="cursor: no-drop;" value="<?php echo $detailss['hemail'] ?>" readonly>
 		<br>
 		Location:<input class="form-control" type="text" name="location" style="cursor: no-drop;" value="<?php echo $detailss['hlocation'] ?>" readonly>
 		<br>
 		Description:<input type="text" class="form-control" name="description" style="cursor: no-drop;" value="<?php echo $detailss['hdescription'] ?>" readonly>
 		<br>
 		Category:<input class="form-control" type="text" name="category"  style="cursor: no-drop;"  value="<?php echo $detailss['hcategory'] ?>" readonly>
 		<br>
 		Phone No. :<input  class="form-control" type="number" style="cursor: no-drop;" name="number" value="<?php echo $detailss['hphno'] ?>" readonly>
 		<br>
 		Website:<input type="text" class="form-control" name="website" style="cursor: no-drop;" value="<?php echo $detailss['hwebsite'] ?>" readonly>
 		<br>
 		Veg /NON Veg:<input  class="form-control" type="text" name="von"  style="cursor: no-drop;"  value="<?php if($detailss['vegnonveg']){echo "VEG";}else{echo "NON-VEG";} ?>" readonly>
 		<br>
		People Capacity / Hr:<input type="text" class="form-control" name="people" style="cursor: no-drop;" value="<?php echo $detailss['people'] ?>" readonly>
 		<br>
	</form>	 
 	</div>
 	
	 <?php include('inc/footer.php');?>