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
      <?php include('sidebar.php'); ?>

    <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
            <section class="content-header">
              <h1>
                My Requested Room/s
              </h1>
              <ol class="breadcrumb">
                <li><a href="main.php"><i class="fa fa-dashboard"></i>Home</a></li>
                <li class="active">My Request/s</li>
              </ol>
            </section>
             <!-- Main content -->
            <section class="content"> <hr/>
              <!--DISPLAY ALL REQUESTS MADE BY USER-->
              <div class="row">
                <div class="col-xs-12">
                  <div class="box">
                    <div class="box-body">
                      <table id="example1" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>Request ID </th>
                            <th>Purpose of Activity</th>
                            <th>Date of Use</th>
                            <th>Time</th>
                            <th>Room</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>

                        <?php
                          $username = "";
                          $output = '';
                          $arrayID = array();

                          if (isset($_SESSION['id']))
                          {
                            $username = $_SESSION['id'];
                          }

                            $getRequests = mysql_query("select * from requests where requesterID='$username'");

                              if(mysql_num_rows($getRequests) > 0)
                              {
                                while($row = mysql_fetch_array($getRequests))
                                {
                                  if($row['isExpired'] != '1')
                                  {
                                   $arrayID[] = $row['requestID'];
                                   $arrayPurpose[] = $row['purpose'];
                                   $arrayDateOfUse[] = $row['dateOfUse'];
                                   $arrayFrom[] = $row['timeFrom'];
                                   $arrayTo[] = $row['timeTo'];
                                   $arrayRooms[] = $row['room'];
                                   $arrayStatus[] = $row['status'];
                                  }
                                }
                              }
                              else
                              {
                                //echo "No Requests";
                              }

                          for ($showDetailsCtr = 0 ; $showDetailsCtr < count($arrayID) ; $showDetailsCtr++)
                          {
                            $output .="
                              <tr>
                              <td>$arrayID[$showDetailsCtr]</td>
                              <td>$arrayPurpose[$showDetailsCtr]</td>
                              <td>$arrayDateOfUse[$showDetailsCtr]</td>
                              <td>$arrayFrom[$showDetailsCtr] - $arrayTo[$showDetailsCtr]</td>
                              <td>$arrayRooms[$showDetailsCtr]</td>";
                            
                            $color = "";

                            if($arrayStatus[$showDetailsCtr] == "Pending")
                            {
                              $color = "#FF8800";
                              $output .="<td style='color:$color;font-weight:800'>$arrayStatus[$showDetailsCtr]</td>";
                            }
                            else if($arrayStatus[$showDetailsCtr] == "Approved")
                            {
                              $color = "#5cb85c";
                              $output .="<td style='color:$color;font-weight:800'>$arrayStatus[$showDetailsCtr]</td>";
                            }
                            else if($arrayStatus[$showDetailsCtr] == "Cancelled")
                            {
                              $color = "#616161";
                              $output .="<td style='color:$color;font-weight:800'>$arrayStatus[$showDetailsCtr]</td>";
                            }
                            else if($arrayStatus[$showDetailsCtr] == "Rejected")
                            {
                              $color = "#d9534f";
                              $output .="<td style='color:$color;font-weight:800'>$arrayStatus[$showDetailsCtr]</td>";
                            }

                            //BUTTON FOR VIEW DETAILS
                            $output .="<td><a href='#' class='btn-block btn-info view-details' id='$arrayID[$showDetailsCtr]' title='View Request Details'><i class='fa fa-eye'></i></a>&nbsp;&nbsp;";

                            //BUTTON FOR CANCEL REQUEST
                            if($arrayStatus[$showDetailsCtr] == "Cancelled" || $arrayStatus[$showDetailsCtr] == "Rejected")
                            {
                              $output .="<a href='cancelrequest.php?id=$arrayID[$showDetailsCtr]' class='btn-block btn-danger' onClick='return false' disabled=true title='Cancel Request' style='cursor:not-allowed;'><i class='fa fa-close'></i></a>";
                            }
                            else
                            {
                              $output .="<a href='#' class='btn-block btn-danger cancel-request' id='$arrayID[$showDetailsCtr]' title='Cancel Request'><i class='fa fa-close'></i></a>";
                            }
                            $output .="</td></tr>";
                          }
                          $output .="</table>";

                          echo $output;
                              
                        ?>
                      </table>
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
  
  <!--==========JAVASCRIPT=======-->
    <!-- <script src="./js/jquery.datetimepicker.full.js"></script>
    <script src="./js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="./js/app.min.js"></script>
    <script src="./js/modal-requested-room.js"></script>
    <script src="./js/dataTable.js"></script> -->

 
 </body>
</html>

<script>
function doconfirm()
{
    if (confirm('Are you sure you want to cancel request?'))
    {
      
    }
    else
    {
      return false;
    }
}
</script>


<!--MODALS-->
<div id="detailsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background-color:#428bca;color:white;">
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
        <h4 class="modal-title">Request Detailsssssssssss</h4>
      </div>
     
      <div class="modal-body" id="request-details">
        <div class="container-fluid">
          
        </div>
      </div> <!--=======END OF MODAL BODY===-->

    </div> <!--==END OF MODAL CONTENT==-->

  </div>
</div>
<!--END MODAL-->

<!--MODALS-->
<form action='cancelrequest.php' method='post'>
  <div id="cancelModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">

          <div class="modal-header" style="background-color:#d9534f;color:white;">
            <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
            <h4 class="modal-title">Cancel Request</h4>
          </div>
         
          <div class="modal-body" id="cancel-request">
            <div class="container-fluid">
              
            </div>
          </div>
         
         <div class='modal-footer'>
            <input type='submit' name='request' value='Cancel Request' class='btn btn-danger'/>
         </div>

      </div><!--==END OF MODAL CONTENT==-->
    </div><!--==END OF MODAL DIALOG==-->
  </div><!--==END OF MODAL FADE==-->
</form>
<!--END MODAL-->