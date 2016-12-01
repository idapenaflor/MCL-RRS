<?php
	require("connects.php");
	require("log-auth.php");
	if($type=="OITS"){

	}
	else if($type=="Staff"){
		header("location:main.php");
	}
	else if($type=="Dean" || $type=="LMO" || $type=="CDMO"){
		header("location:dv-main.php");
	}
	else{
		header("location:login.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>MCL Room Reservation</title>
    <?php include('includes.php'); ?>
  </head>

  <body class="hold-transition sidebar-mini">
  	<div class="wrapper">
	  	<header class="main-header">
		    <?php include ('header.php');?>
		    <?php include ('navi.php');?>
	 	</header>

	 	<aside class="main-sidebar">
	        <?php include('sidebar.php') ?>
	    </aside>
		    <div class="content-wrapper">
		    	<section class="content-header">
		            <h1>
		              Register Account
		            </h1>
		            <ol class="breadcrumb">
		              <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		            </ol>
		        </section>
		    	<section class="content"> <hr/>
		            <div class="row">
		              <div class="col-xs-6">
		                <div class="box">
		                  <div class="box-body">							
							<div class="input-group">
								<form name="forms"  action="signup.php" method="POST">
								  <input type="text" class="form-control" placeholder="Last Name" aria-describedby="basic-addon1" maxlength="50" name="txtLName" pattern="[A-Za-z\s]+" title="Enter letters only" required="required">

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
						          			<option value="OITS" aria-labelledby="dropdownMenu1">OITS</option>
								  </select> <br/>

									<select class="form-control" name="Dept" id="Dept" required="required">
										<option value="">Enter department</option>
									</select>

								<center><input type="submit" class="btn btn-primary" name="btnSubmit" value="Submit" style="padding-top: 10px; margin-top: 10px;"/></center>
								</form>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				</section>
			</div>

		<!--==========FOOTER========-->
	    <footer class="main-footer">
	      <?php include ('footer.php');?>
	    </footer>
	</div>
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
					$password = $_POST['txtPass'];
					$utype = $_POST['uType'];
					$fname = $_POST['txtFName'];
					$lname = $_POST['txtLName'];
					$mname = $_POST['txtMName'];
					$department = $_POST['Dept'];

					$StorePass = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
					$result = mysqli_query($con,"SELECT * FROM account WHERE id = '$username'");

					if(!$row = mysqli_fetch_assoc($result))
					{
						$sql1="INSERT INTO account VALUES('$username','$StorePass', '$utype', '$fname', '$lname', '$mname', '$department')";

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