<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content-="width=device-width initial-scale=1">
    <title>MCL Room Reservation</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
    <script src="./js/dropdown.js"></script>
  </head>

  <body>
  	<!--======NAVIGATION===================-->
  	<nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0px;">
	  <div class="container">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#">Malayan Colleges Laguna</a>
		    </div>
 	  </div><!-- /.container-fluid -->
	</nav>

	<div id="parentDiv">
		 <div class="container">
		 		<div class="row" style="margin-top: 40px;">
					
						<div class="panel" id="sign-up">
								
									<div class="input-group">
									<form name="forms"  action="signup.php" method="POST">
										<strong style="text-align: left; font-size: 25px;">Sign Up</strong>
									  <input type="text" class="form-control" placeholder="Last Name" aria-describedby="basic-addon1" maxlength="50" name="txtLName" pattern="[A-Za-z\s]+" title="Enter letters only" required="required"> <br/><br/>

									  <input type="text" class="form-control" placeholder="First Name" pattern="[A-Za-z\s]+" title="Enter letters only" required="required" aria-describedby="basic-addon1" maxlength="50" name="txtFName">

									  <input type="text" class="form-control" placeholder="Middle Name" pattern="[A-Za-z\s]+" title="Enter letters only" required="required" aria-describedby="basic-addon1" maxlength="50" name="txtMName">

									  <input type="text" class="form-control" placeholder="Account ID" required="required" aria-describedby="basic-addon1" maxlength="10" pattern="[0-9]{10}" title="Enter exactly 10 numbers only" name="txtUser">

									  <input type="password" class="form-control" placeholder="Password" required="required" aria-describedby="basic-addon1" id="txtPass" name="txtPass" pattern=".{6,}" title="Enter 6 or more characters">

									  <input type="password" class="form-control" placeholder="Confirm Password" required="required" pattern=".{6,}" title="Enter 6 or more characters" aria-describedby="basic-addon1" id="txtCPass" name="txtCPass">

									  <select class="form-control" name="uType" id="uType" required="required" aria-labelledby="dropdownMenu1" onchange="aDrop()">
												<option value="">Enter user type</option>
												<option value="Staff">Staff</option>
												<option value="Dean">Dean</option>
							          			<option value="CDMO" aria-labelledby="dropdownMenu1">CDMO</option>
							          			<option value="LMO" aria-labelledby="dropdownMenu1">LMO</option>
									  </select> <br/>

										<select class="form-control" name="Dept" id="Dept" required="required">
											<option value="">Enter department</option>
										</select>

									<center><input type="submit" class="btn btn-primary" name="btnSubmit" value="Submit" style="padding-top: 10px; margin-top: 10px;"/></center>
								</form>
								</div><!--end of div-->
						</div> <!--end of panel-->
				</div>
		
		 </div><!--end of class container-->
	</div>
	<footer>© 2016 All Rights Reserved</footer>
      <script    src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
  </body>
</html>

<!--PHP CODESSSSSSSSSSSSSS-->
	<?php

		require('connects.php');

			if (isset($_POST['btnSubmit']))
			{					
				$pass = md5($_POST['txtPass']);
				$cpass = md5($_POST['txtCPass']);

				if($pass==$cpass)
				{
					$username = $_POST['txtUser'];
					$password = md5($_POST['txtPass']);
					$utype = $_POST['uType'];
					$fname = $_POST['txtFName'];
					$lname = $_POST['txtLName'];
					$mname = $_POST['txtMName'];
					$department = $_POST['Dept'];


					$result = mysqli_query($con,"SELECT * FROM account WHERE id = '$username'");

					if(!$row = mysqli_fetch_assoc($result))
					{
						$sql1="INSERT INTO account VALUES('$username','$password', '$utype', '$fname', '$lname', '$mname', '$department')";

						if (!mysqli_query($con,$sql1))
						{
						  die('Error: ' . mysqli_error());
						}
						//TURN IT BACK TO LOGIN PAGE
				        echo "<script language='javascript'>alert('Sign up successful! Redirecting you back to log in page.');</script>";
				        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=login.php\">";
					}
					else
					{
						echo "<script type='text/javascript'> alert ('Username already existing');</script>";
					} //end of else

					mysqli_close($con);
				}//end of == pass
				else{
					echo "<script type='text/javascript'> alert ('Password does not match');</script>";
				}
			}
	?>