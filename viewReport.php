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

      $arrayID = array();
      $arrayDept = array();
      $arrayDateFiled = array();
      $arrayDateUse = array();
      $arrayRoom = array();
      $arrayStatus = array();
      $arrayPurpose = array();

      $month = date('m');

      $type = $_SESSION['type'];

      $output = '';
      $month = date('m');

      if($type == 'LMO')
      {
        $getRequests = mysqli_query($con,"select * from requests join action on requests.requestID=action.requestID where action.lmoAction!='N/A' and requests.status='Approved' and requests.dateOfUse like '$month%'");
      }
      else
      {
          $getRequests = mysqli_query($con,"select * from requests where status='Approved' and dateOfUse like '$month%'");
      }

    ?>
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
              View Report
            </h1>
            <ol class="breadcrumb">
              <li><a href="dv-main.php"><i class="fa fa-dashboard"></i>Home</a></li>
              <li class="active">View Report</li>
            </ol>
          </section>

           <!-- Main content -->
          <section class="content">
            <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <p><h4>Month Covered
                      <select class="combo" name="month" id="month" required="required">
                        <option <?= $month=="01" ? 'selected' : '' ?> value="01">January</option>
                        <option <?= $month=="02" ? 'selected' : '' ?> value="02">February</option>
                        <option <?= $month=="03" ? 'selected' : '' ?> value="03">March</option>
                        <option <?= $month=="04" ? 'selected' : '' ?> value="04">April</option>
                        <option <?= $month=="05" ? 'selected' : '' ?> value="05">May</option>
                        <option <?= $month=="06" ? 'selected' : '' ?> value="06">June</option>
                        <option <?= $month=="07" ? 'selected' : '' ?> value="07">July</option>
                        <option <?= $month=="08" ? 'selected' : '' ?> value="08">August</option>
                        <option <?= $month=="09" ? 'selected' : '' ?> value="09">September</option>
                        <option <?= $month=="10" ? 'selected' : '' ?> value="10">October</option>
                        <option <?= $month=="11" ? 'selected' : '' ?> value="11">November</option>
                        <option <?= $month=="12" ? 'selected' : '' ?> value="12">December</option>
                      </select>
                      <select class="combo" name="year" id="year" required="required">
                        <option value="2016">2016</option>
                      </select>
                      
                      <span style="padding-left:10pt">Department</span>
                      <select class="combo" name="department" id="department" required="required">
                        <option value="All">All</option>
                        <option value="CAS">CAS</option>
                        <option value="CCIS">CCIS</option>
                        <option value="CMET">CMET</option>
                        <option value="ETYCB">ETYCB</option>
                        <option value="IEXCELL">IEXCELL</option>
                        <option value="MITL">MITL</option>
                      </select>
                      <div class="pull-right">
                        
                      <?php
                        if(mysqli_num_rows($getRequests) > 0)
                          {
                              while($row = mysqli_fetch_array($getRequests))
                              {
                                  $arrayID[] = $row['requestID'];
                                  $arrayDept[] = $row['dept'];
                                  $arrayDateFiled[] = $row['dateOfFiling'];
                                  $arrayDateUse[] = $row['dateOfUse'];
                                  $arrayRoom[] = $row['room'];
                                  $arrayStatus[] = $row['status'];
                                  $arrayPurpose[] = $row['purpose'];
                              }
                            $output1 = "<a href='#' class='btn btn-success generate-report' id='generate-report' title='Generate Report'><i class='fa fa-print'></i> <span>Generate Report</span></a>";
                          }
                          else
                          {
                            $output1 = "<a href='#' class='btn btn-success generate-report' id='generate-report' title='Generate Report' disabled=true style='cursor:not-allowed;'><i class='fa fa-print'></i> <span>Generate Report</span></a>";
                          }

                        echo $output1;
                      ?>
                    </div>
                    </h4></p>
                    <input type='hidden' id='admin-type' name='type' value='<?php echo ($_SESSION['type']); ?>'/>
                  </div> <!--======END OF BOX header=======-->
                  <div class="box-body"><!--code to report php-->
                     <div class="report-div">
                      <table id="report-table" class="table table-bordered table-hover report-table">
                        <thead>
                          <tr>
                          <!--   <th>Request ID</th> -->
                            <th>Department</th>
                            <th>Purpose</th>
                            <th>Date Filed</th>
                            <th>Date of Use</th>
                            <th>Room</th>
                            <th>Equipment</th>
                           <!--  <th>Status</th>  -->
                          </tr>
                        </thead>
                      <?php
                          if(count($arrayID) != 0)
                          {

                            for ($ctr = 0 ; $ctr < count($arrayID) ; $ctr++)
                            {
                              $arrayEquipments = array();
                              $arrayQty = array();
                              $equip = '';
                              $query = mysqli_query($con,"select * from equipmentrequest where requestID='$arrayID[$ctr]'");

                              if(mysqli_num_rows($query)>0)
                              {
                                while($row = mysqli_fetch_array($query))
                                {
                                  $arrayEquipments[] = $row['ename'];
                                  $arrayQty[] = $row['qty'];
                                } 
                              }

                              for($ctr2 = 0 ; $ctr2 < count($arrayEquipments) ; $ctr2++)
                              {
                                if($ctr2 == count($arrayEquipments) - 1)
                                {
                                  $equip .= '(' . $arrayQty[$ctr2] . ') ' . $arrayEquipments[$ctr2];
                                }
                                else
                                {
                                  $equip .= '(' . $arrayQty[$ctr2] . ') ' . $arrayEquipments[$ctr2] . ', ';
                                }
                              }

                              $output .="
                              <tr>
                              <td>$arrayDept[$ctr]</td>
                              <td>$arrayPurpose[$ctr]</td>
                              <td>$arrayDateFiled[$ctr]</td>
                              <td>$arrayDateUse[$ctr]</td>
                              <td>$arrayRoom[$ctr]</td>
                              <td>$equip</td>
                              </tr>";
                            }

                            $output .= "</table>";

                          }

                          echo $output;
                      ?>
                    </div>
                  </div> <!--======END OF BOX BODY=======-->
                </div> <!--======END OF BOX=======-->   
              </div> <!--======END OF col=======--> 
            </div> <!--======END OF row=======--> 
          </section>
    </div>
  <!--==========FOOTER========-->
    <!-- <footer class="main-footer">
      <?php include ('footer.php');?>
    </footer> -->
  </div><!--end of wrapper-->
 </body>
</html>

<!--MODALS-->
<div id="equipModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background-color:#428bca;color:white;">
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
        <h4 class="modal-title">Request Details</h4>
      </div>
     
      <div class="modal-body" id="request-details">
        <div class="container-fluid">
          
        </div>
      </div> <!--=======END OF MODAL BODY===-->

    </div> <!--==END OF MODAL CONTENT==-->

  </div>
</div>
<!--END MODAL-->


