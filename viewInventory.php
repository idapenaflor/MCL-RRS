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
              Equipment Inventory
            </h1>
            <ol class="breadcrumb">
                <li><a href="dv-main.php"><i class="fa fa-dashboard"></i>Home</a></li>
                <li class="active">Equipment Inventory</li>
              </ol>
          </section>
            <!-- Main content -->
          <section class="content"> <hr/>
            <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <a href='#' class='btn btn-success' id='$type' title="Add New Equipment" style="width: 170px;margin-top:5px;margin-left: 5pt;">
                      <span class='add-equipment' title="Add New Equipment"><i class='glyphicon glyphicon-plus view-data'></i>&nbsp; Add New Equipment
                      </span>
                    </a>
                  </div> <!--======END OF BOX header=======-->
                  <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Equipment ID</th>
                          <th>Equipment</th>
                          <th>Quantity</th>
                          <th>On Hand</th>
                          <th>Created</th>
                          <th>Modified</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                      <?php

                        $output = '';
                        $arrayID = array();

                        $getEquipment = mysqli_query($con,"select * from equipment where edept='$type'");
                        if(mysqli_num_rows($getEquipment) > 0)
                        {
                            while($row = mysqli_fetch_array($getEquipment))
                            {
                               $arrayID[] = $row['eid'];
                               $arrayEname[] = $row['ename'];
                               $arrayQty[] = $row['qty'];
                               $arrayOnhand[] = $row['onhand'];
                               $arrayModified[] = $row['modified'];
                               $arrayCreated[] = $row['created'];
                            }
                        }
                        else
                        {
                          //echo "No Requests";
                        }

                          for ($ctr = 0 ; $ctr < count($arrayID) ; $ctr++)
                          {
                            $output .="

                              <tr>
                              <td>$arrayID[$ctr]</td>
                              <td>$arrayEname[$ctr]</td>
                              <td>$arrayQty[$ctr]</td>
                              <td>$arrayOnhand[$ctr]</td>
                              <td>$arrayCreated[$ctr]</td>
                              <td>$arrayModified[$ctr]</td>

                              <td><a href='#' class='btn-block btn-success edit-equipment' id='$arrayID[$ctr]' title='Edit Equipment'><i class='fa fa-pencil'></a></td>";

                          }
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
    <script src="./js/app.min.js"></script> -->
 </body>
</html>

<!-- EDIT MODAL-->
<form action='editEquipmentDetails.php' method='post'>
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background-color:#428bca;color:white;">
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
        <h4 class="modal-title">Edit Equipment</h4>
      </div>
     
      <div class="modal-body" id="edit-equipment">
        <div class="container-fluid">         
        </div>
      </div>
      <div class='modal-footer'>
        <input type='submit' name='save' value='Save' class='btn btn-success'/>
        <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
      </div>
    </div>
  </div>
</div>
</form>
<!--END MODAL-->

<!-- ADD MODAL-->
<form action='saveNewEquipment.php' method='post'>
<div id="addModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background-color:#428bca;color:white;">
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
        <h4 class="modal-title">Add New Equipment</h4>
      </div>
     
      <div class="modal-body" id="add-equipment">
        <div class="container-fluid">         
        </div>
      </div>
      <div class='modal-footer'>
        <input type='submit' name='save' value='Save' class='btn btn-success btn-add'/>
        <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
      </div>
    </div>
  </div>
</div>
</form>
<!--END MODAL-->


<script>
  $(document).ready(function(){
    $('.edit-equipment').click(function(){
      var equipID = $(this).attr("id");
      $.ajax({
        url:"viewEditInventoryModal.php",
        method:"get",
        data:{equipID},
        success:function(data){
          $('#edit-equipment').html(data);
          $('#editModal').modal("show"); 
        }
      });
    });
  });
</script>

<script>
  $(document).ready(function(){
    $('.add-equipment').click(function(){
      var type = $(this).attr("id");
      $.ajax({
        url:"viewAddEquipmentModal.php",
        method:"get",
        data:{type},
        success:function(data){
          $('#add-equipment').html(data);
          $('#addModal').modal("show"); 
        }
      });
    });
  });
</script>