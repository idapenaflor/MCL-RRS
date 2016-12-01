<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content-="width=device-width initial-scale=1">
    <title>MCL Room Reservation</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">

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
		 	<div class="index large-4 medium-4 large-offset-4 medium-offset-4 columns">
		 		<center>
			 		<div id="title1"><img src="./img/title.png" width="85%" height="auto" alt="Title"></div>
		 		</center>
			</div><!--end of offset-->
			<center>
				<div class="panel" id="login">
						<form action="login.php" method="post">
							<div class="input-group">
							  <input type="text" class="form-control" placeholder="Username" name="txtUser" required="required" style="margin-top: 8px;height: 45px;" /> <br/><br/>
							  <input type="password" class="form-control" placeholder="Password" name="txtPass" required="required" style="margin-top: 8px;height: 45px;"/>
							</div><br/>

							<input type="submit" class="btn btn-primary" name="btnLogin" value="Login"/>
						</form>
				</div> <!--end of panel-->
			</center>
		 </div><!--end of class container-->
	</div>
	<!--==========FOOTER========-->
		<footer class="main-footer">
			<center>
			<?php include ('footer.php');?>
			</center>
		</footer>
  </body>
</html>
<?php
require('connects.php');

if (isset($_POST['btnLogin']))
{
	$username = $_POST['txtUser'];
	//$password = md5($_POST['txtPass']);
	$password = $_POST['txtPass'];
	$type = "";
	$dept = "";

	//$query = "SELECT * FROM account WHERE id = '$username' AND password = '$password'";
	$query = "SELECT * FROM account WHERE id = '$username'";
	$result = mysqli_query($con,$query);

	while($row = mysqli_fetch_array($result))
          {
          	$pass = $row['password'];
             $type = $row['type'];
             $dept = $row['dept'];

             $pass = htmlspecialchars($row['password'],ENT_QUOTES);
             $type = htmlspecialchars($row['type'],ENT_QUOTES);
             $dept = htmlspecialchars($row['dept'],ENT_QUOTES);
          }

     if(password_verify($password, $pass))
     {
	    session_start();
		$_SESSION['id'] = $username;
		$_SESSION['password'] = $pass;
		$_SESSION['type'] = $type;
		$_SESSION['dept'] = $dept;

	    if($type=="Dean" || $type=="CDMO" || $type=="LMO"){
	    	//echo "<script type='text/javascript'> alert ('Hello Dean');</script>";
	    	header("location:dv-main.php");
	    }
	    else if($type=="Staff"){
	    	//echo "<script type='text/javascript'> alert ('Hello Staff');</script>";
	    	header("location:main.php");
	    }
	    else if($type=="OITS")
	    {
	    	header("location:signup.php");
	    }
	  }
    else{
    	session_destroy();
	 	echo "<script type='text/javascript'> alert ('Incorrect username and/or password.');</script>";
    }
	
}//end of if isset
else{
	session_destroy();
}

	mysqli_close($con);
?>