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
      require('connects.php');
     // require('log-auth.php');
    ?>
    <div class="wrapper">
      <header class="main-header">
        <?php include ('header.php');?>
        <?php include ('navi.php');?>
      </header>
      <!--==========SIDE BAR===========-->
        <aside class="main-sidebar">
            <?php include('sidebar.php') ?>
        </aside>
      <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
              <!-- Content Header (Page header) -->
              <section class="content-header">
                <h1>
                  Facility Schedule
                </h1>
                <ol class="breadcrumb">
                  <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                </ol>
              </section>
              <!-- Main content -->
              <form action="scheduleOccupy.php" method="post">
              <section class="content"> <hr/>
                <div class="row">
                  <div class="col-xs-12">
                    <div class="box">
                      <div class="box-body">
                      <span>Facility Name</span>
                        <select id='room' name='room'>
                          <?php
                            $arrayID = array();
                            $arrayRoom = array();
                            $query1 = mysqli_query($con,"select * from roomtable");

                            if(mysqli_num_rows($query1) > 0)
                            {
                                while($row = mysqli_fetch_array($query1))
                                {
                                   $arrayID[] = $row['rID'];
                                   $arrayRoom[] = $row['rRoom'];
                                }
                            }

                            for($ctr=0; $ctr<count($arrayID); $ctr++)
                            {
                              echo "<option value='$arrayID[$ctr]'>$arrayRoom[$ctr]</option>";
                            }
                          ?>
                        </select>
                        <span style='padding-left:20pt;'><input type='submit' class='btn btn-success' id='btn-occupy' value='Occupy'/></span>
                      </div>
                    </div>
                <div class="row">
                        <div class="col-xs-4">
                         <span><h4>Day of the Week</h4></span>
                         <p><input type='checkbox' name='day[]' value='Monday'>&nbsp;&nbsp;Monday</input></p>
                         <p><input type='checkbox' name='day[]' value='Tuesday'>&nbsp;&nbsp;Tuesday</input></p>
                         <p><input type='checkbox' name='day[]' value='Wednesday'>&nbsp;&nbsp;Wednesday</input></p>
                         <p><input type='checkbox' name='day[]' value='Thursday'>&nbsp;&nbsp;Thursday</input></p>
                         <p><input type='checkbox' name='day[]' value='Friday'>&nbsp;&nbsp;Friday</input></p>
                         <p><input type='checkbox' name='day[]' value='Saturday'>&nbsp;&nbsp;Saturday</input></p>
                         <p><input type='checkbox' name='day[]' value='Sunday'>&nbsp;&nbsp;Sunday</input></p>
                         </div>
                         <div class="col-xs-4">
                         <span><h4>Day of the Week</h4></span>
                         <p><input type='checkbox' name='time[]' value='1'>&nbsp;&nbsp;7:00AM - 8:30AM</input></p>
                         <p><input type='checkbox' name='time[]' value='2'>&nbsp;&nbsp;8:30AM - 10:00AM</input></p>
                         <p><input type='checkbox' name='time[]' value='3'>&nbsp;&nbsp;10:00AM - 11:30AM</input></p>
                         <p><input type='checkbox' name='time[]' value='4'>&nbsp;&nbsp;11:30AM - 1:00PM</input></p>
                         <p><input type='checkbox' name='time[]' value='5'>&nbsp;&nbsp;1:00PM - 2:30PM</input></p>
                         <p><input type='checkbox' name='time[]' value='6'>&nbsp;&nbsp;2:30PM - 4:00PM</input></p>
                         <p><input type='checkbox' name='time[]' value='7'>&nbsp;&nbsp;4:00PM - 5:30PM</input></p>
                         <p><input type='checkbox' name='time[]' value='8'>&nbsp;&nbsp;5:30PM- 7:00PM</input></p>
                         <p><input type='checkbox' name='time[]' value='9'>&nbsp;&nbsp;7:00PM - 8:30PM</input></p>
                         </div>
                      </div> <!--======END OF BOX BODY=======-->
                    </div> <!--======END OF BOX=======-->   
                  </div> <!--======END OF col=======--> 
                </div> <!--======END OF row=======--> 
              </section>
              </form>
        </div>
      <!--==========FOOTER========-->
        <footer class="main-footer">
          <?php include ('footer.php');?>
        </footer>
    </div><!--end of wrapper-->

 </body>
</html>


