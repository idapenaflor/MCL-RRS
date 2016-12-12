<?php
  include('connects.php');
  include_once('log-auth.php');
  include('qConn.php');

  $dateofuse = NULL;
  $from = NULL;
  $to = NULL;
  $room= NULL;
  $type = NULL;

  $dean = 'Pending';
  $cdmo = 'Pending';
  $lmo = 'Pending';

  if (isset($_SESSION['id']))
  { 
    //Request Details
    $dateofuse = $_GET['dateofuse'];
    $from = $_GET['from'];
    $to = $_GET['to'];
    $room = $_GET['room'];
    $type = $_GET['rtype'];
    $currentdate = $_GET['currentdate'];
  }

  if(isset($_POST['request']))
  {
   /* $lname = $_POST['hLname'];
    $fname = $_POST['hFname'];    
    $dept = $_POST['hDept'];
    $dateofuse = $_POST['hDateOfUse'];
    $from = $_POST['hFrom'];
    $to = $_POST['hTo'];
    $room = $_POST['hRoom'];
    $type = $_POST['hType'];
    $current_date = $_POST['hCurrentDate'];*/
    $purpose = $_POST['purpose'];

    if($type != "Laboratory")
    {
      $lmo = "N/A";
    }

    $sql1 = InsertRequestedRoom($con,$username,$dept,$currentdate,$purpose,$dateofuse,$from,$to,$room,$dean,$cdmo,$lmo)

    if (!mysql_query($con,$sql1))
    {
      die('Error: ' . mysql_error());
    }
    else
    {
      echo "<script language='javascript'>alert('Request Successful! Redirecting you back to main page.$dept');</script>";
      echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=main.php\">";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>MCL Room Reservation</title>
    <!--=============CSS=============-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="./css/AdminLTE.min.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!--============JAVASCRIPT================-->
    <script src="./js/dropdown.js"></script>
    <script type = "text/javascript" src="js/jquery-1.12.0.min.js"></script>
  </head>
  <body class="hold-transition sidebar-collapse sidebar-mini">
    <div class="wrapper">
  <header class="main-header">
    <?php include ('header.php');?>
    <?php include ('navi.php');?>
  </header>
  <!--==========SIDE BAR===========-->
    <aside class="main-sidebar">
        <?php include('sidebar.php'); ?>
    </aside>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
              Request Room
            </h1>
            <ol class="breadcrumb">
              <li><a href="main.php"><i class="fa fa-dashboard"></i> Home</a></li>
              <li class="active">Request Room</li>
            </ol>
          </section>
           <!-- Main content -->
          <section class="content">
          <hr/>
            <div class="partRequest">
              <form method="post">
                <div class="row">
                  <table class="pr-1">
                    <tr>
                   <td>ID Number</td>
                   <td><?php echo ($username); ?></td>
                  </tr>
                  <tr>
                   <td>Requester Name</td>
                   <td><?php echo ($lname.', '.$fname); ?></td>
                  </tr>
                  <tr>
                   <td>College</td>
                   <td><?php echo ($dept); ?></td>
                  </tr>
                  <tr>
                   <td>Date of Filing</td>
                   <td><?php echo ($currentdate); ?></td>
                    <input type='hidden' name='hCurrentDate' value='<?php echo ($current_date); ?>'/>
                  </tr>
                  <tr>
                   <td>Room</td>
                   <td><?php echo ($room); ?></td>
                   <input type='hidden' name='hRoom' value='<?php echo ($room); ?>'/>
                   <input type='hidden' name='hType' value='<?php echo ($type); ?>'/>
                  </tr>
                  <tr>
                   <td>Date of Use</td>
                   <td><?php echo ($dateofuse); ?></td>
                   <input type='hidden' name='hDateOfUse' value='<?php echo ($dateofuse); ?>'/>
                  </tr>
                  <tr>
                   <td>Time of Use</td>
                   <td><?php echo ($from.' - '.$to); ?></td>
                   <input type='hidden' name='hFrom' value='<?php echo ($from); ?>'/>
                   <input type='hidden' name='hTo' value='<?php echo ($to); ?>'/>
                  </tr>
                  <tr>
                   <td>Equipment</td>
                  </tr>
                  <tr>
                   <td>Purpose of Activity</td>
                   <td><input type="text" name="purpose" id="purpose" placeholder="Purpose of Activity" style="width: 500px;" required="required" /></td>
                  </tr>
                  </table>
                  <br/>
                   <center><input type="submit" name="request" id="request" value="Request" style="background-color: #3c8dbc;
    color: white;border-width: thin;border-radius: 5px;font-size: 20px;width: 120px;font-size: 20px;" /></center>
                </div>
              </form>
            </div><!--========END OF partRequest=======-->
          </section>
    </div>
  <!--==========FOOTER========-->
    <footer class="main-footer">
      <?php include ('footer.php');?>
    </footer>
  </div><!--end of wrapper-->
  
  <!--==========JAVASCRIPT=======-->
   <!-- jQuery 2.2.3 -->
    <script src="./js/jquery-2.2.3.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <!-- AdminLTE App -->
    <script src="./js/app.min.js"></script>
 </body>
</html>
