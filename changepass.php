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
     <?php
      include('connects.php');
      include('log-auth.php');
    ?>
  <div class="wrapper">
    <header class="main-header">
      <?php include ('header.php');?>
      <?php include ('navi.php');?>
    </header>
  <!--==========SIDE BAR===========-->
      <?php include('sidebar.php') ?>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
              Account Setting
            </h1>
            <ol class="breadcrumb">
              <?php if($type == "Staff"): ?>
                <li><a href="main.php"><i class="fa fa-dashboard"></i> Home</a></li>
              <?php endif; ?>
              <?php if($type == "Dean"): ?>
                <li><a href="dv-main.php"><i class="fa fa-dashboard"></i> Home</a></li>
              <?php endif; ?>

                <li class="active">Account Setting</li>
              </ol>
            </section>
            <!-- Main content -->
            <section class="content"> <hr/>
                  <div class="input-group">
                    <div class="area1">
                    <form action="changepass.php" method="post">
                      <input type="password" class="form-control" placeholder="New Password" aria-describedby="basic-addon1" name="txtNPass" id="txtNPass" required="required" pattern=".{6,}" title="Enter 6 or more characters"> <br/><br/>
                      <input type="password" class="form-control" placeholder="Confirm New Password" aria-describedby="basic-addon1" name="txtCPass" id="txtCPass" required="required" pattern=".{6,}" title="Enter 6 or more characters">
                      <br/> <br/>
                      <center>
                      <input type="submit" class="btn btn-success" name="btnChange" value="Submit" style="margin-top: 15px;" />
                      </center>
                      </form>
                    </div>
                  </div> <br/>
          </section>
    </div>
  <!--==========FOOTER========-->
    <footer class="main-footer">
      <?php include ('footer.php');?>
    </footer>
  </div><!--end of wrapper--> 
 </body>
</html>
<?php
    if(isset($_POST['btnChange']))
    {
      $nPass = md5($_POST['txtNPass']);
      $cnPass = md5($_POST['txtCPass']);
      $username = $_SESSION['id'];
      $oPass = $_SESSION['password'];

          if($nPass==$cnPass && $nPass!=$oPass)
          {
            $result2 = mysql_query("UPDATE account set password='$nPass' where id='$username' AND password='$oPass'");

            echo "<script type='text/javascript'> alert ('Password Successfully Changed');</script>";
            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=login.php\">";
          }
          else if($nPass==$oPass)
          {
            echo "<script type='text/javascript'> alert ('Old password and new password cannot be the same.');</script>";
          }
          else{
             echo "<script type='text/javascript'> alert ('Password does not match');</script>";
          }
    }
?>