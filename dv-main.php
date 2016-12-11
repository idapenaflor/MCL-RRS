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
      require('log-auth.php');

      $arrayID = array();
       $arrayRequester = array();
       $arrayPurpose = array();
       $arrayDateOfUse = array();
       $arrayDateOfUse = array();
       $arrayFrom = array();
       $arrayTo = array();
       $arrayRooms = array();
       $arrayDept = array();
       $arrayLname = array();
       $arrayFname = array();
       $output = '';
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
                  Requested Room/s
                </h1>
                <ol class="breadcrumb">
                  <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                </ol>
              </section>
              <!-- Main content -->
              <section class="content"> <hr/>
                <div class="row">
                  <div class="col-xs-12">
                    <div class="box">
                      <div class="box-body">
                          <form method="post">
                            <table id='example1' class='table table-bordered table-hover'>
                              <thead>
                                <tr>
                                  <!-- <th>Request ID</th> -->
                                  <th>Requester</th>
                                  <th>Date of Filing</th>
                                  <th>Date of Use</th>
                                  <th>Time</th>
                                  <th>Room</th>
                                  <th>Purpose of Activity</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                            <?php
                            include('connects.php');
                            include('qConn.php');

                              $getrequests = CheckAdmin($con,$type,$dept);

                              if(mysqli_num_rows($getrequests) > 0)
                              {
                                  while($row = mysqli_fetch_array($getrequests))
                                  {
                                     $arrayID[] = $row['requestID'];
                                     $arrayRequester[] = $row['requesterID'];
                                     $arrayPurpose[] = $row['purpose'];
                                     $arrayDateOfFiling[] = $row['dateOfFiling'];
                                     $arrayDateOfUse[] = $row['dateOfUse'];
                                     $arrayFrom[] = $row['timeFrom'];
                                     $arrayTo[] = $row['timeTo'];
                                     $arrayRooms[] = $row['room'];
                                     $arrayDept[] = $row['dept'];
                                  }
                              }
                              else
                              {
                                //echo "No Requests";
                              }

                              for($ctr=0; $ctr<count($arrayRequester); $ctr++)
                              {
                                $getnames = GetNames($con,$arrayRequester[$ctr]);
                                
                                if(mysqli_num_rows($getnames) > 0)
                                {
                                    while($row = mysqli_fetch_array($getnames))
                                    {
                                       $arrayLname[] = $row['lname'];
                                       $arrayFname[] = $row['fname'];
                                    }
                                }
                              }

                              for ($showDetailsCtr = 0 ; $showDetailsCtr < count($arrayID) ; $showDetailsCtr++)
                              {
                               
                                $output .="
                                <tr>
                                
                                <td>$arrayLname[$showDetailsCtr], $arrayFname[$showDetailsCtr]</td>
                                <td>$arrayDateOfFiling[$showDetailsCtr]</td>
                                <td>$arrayDateOfUse[$showDetailsCtr]</td>
                                <td>$arrayFrom[$showDetailsCtr] - $arrayTo[$showDetailsCtr]</td>
                                <td>$arrayRooms[$showDetailsCtr]</td>
                                <td>$arrayPurpose[$showDetailsCtr]</td>";

                                //VIEW EQUIPMENT
                                $output .="<td><a href='#' id='$arrayID[$showDetailsCtr]' class='btn-block btn-info view-equipment' title='View Requested Equipments'><i class='fa fa-eye'></i></a>";

                                //APPROVE
                                $output .="&nbsp;&nbsp;<a href='#' id='$arrayID[$showDetailsCtr]' class='btn-block btn-success approve-request' title='Approve Request'><i class='fa fa-fw fa-check'></i></a>";

                                //REJECT
                                $output .="&nbsp;&nbsp;<a href='#' id='$arrayID[$showDetailsCtr]' class='btn-block btn-danger reject-request' title='Reject Request'><i class='fa fa-fw fa-close'></i></a></td>";
                                $output .="</tr>";
                                $ctr++;
                              }

                              $output .="</table>";
                              echo $output;
                            ?>
                          </form>
                      </div> <!--======END OF BOX BODY=======-->
                    </div> <!--======END OF BOX=======-->   
                  </div> <!--======END OF col=======--> 
                </div> <!--======END OF row=======--> 
              </section>
        </div>
      <!--==========FOOTER========-->
        <footer class="main-footer">
          <?php include ('footer.php');?>
        </footer>
    </div><!--end of wrapper-->

 </body>
</html>

<!--MODALS-->
<div id="equipmentModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background-color:#428bca;color:white;">
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
        <h4 class="modal-title">Requested Equipment</h4>
      </div>
     
      <div class="modal-body" id="equipment-details">
        <div class="container-fluid">
          
        </div>
      </div>
     
     <div class='modal-footer'>
        <button type='button' class='btn btn-success' data-dismiss='modal'>OK</button>
      </div>
    </div>

  </div>
</div>
<!--END MODAL-->

<!--MODALS-->
<form action='approverejectrequest.php' method='post'>
<div id="rejectModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

        <div class="modal-header" style="background-color:#d9534f;color:white;">
          <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
          <h4 class="modal-title">Are you sure you want to reject request?</h4>
        </div>
       
        <div class="modal-body" id="reject-request">
          <div class="container-fluid">
            
          </div>
        </div>
       
        <div class='modal-footer'>
          <input type='submit' name='request' value='Reject' class='btn btn-danger'/>
        </div>
    </div>
  </div>
</div>
</form>


<!--END MODAL-->

<!--MODALS-->
<form action='approverejectrequest.php' method='post'>
<div id="approveModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

        <div class="modal-header" style="background-color:#5cb85c;color:white;">
          <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
          <h4 class="modal-title">Are you sure you want to approve request?</h4>
        </div>
       
        <div class="modal-body" id="approve-request">
          <div class="container-fluid">
            
          </div>
        </div>
     
       <div class='modal-footer'>
          <input type='submit' name='request' value='Approve' class='btn btn-success'/>
       </div>
    </div>
  </div>
</div>
</form>
<!--END MODAL-->
