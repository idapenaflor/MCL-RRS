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
      $arrayEname = array();
      $arrayQty = array();
      $arrayOnhand = array();
      $arrayModified = array();
      $arrayCreated = array();
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
          Equipment Inventory
        </h1>
        <ol class="breadcrumb">
          <li class="active"><a href="dv-main.php"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
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
                     $getEquipment = mysql_query("select * from equipment where edept='$type'");
                        if(mysql_num_rows($getEquipment) > 0)
                        {
                          while($row = mysql_fetch_array($getEquipment))
                          {
                            $arrayID[] = $row['eid'];
                            $arrayEname[] = $row['ename'];
                            $arrayQty[] = $row['qty'];
                            $arrayOnhand[] = $row['onhand'];
                            $arrayModified[] = $row['modified'];
                            $arrayCreated[] = $row['created'];
                          }
                        }

                      for ($ctr = 0 ; $ctr < count($arrayID) ; $ctr++)
                      {
                        echo "<tr>";
                        echo "<td>$arrayID[$ctr]</td>";
                        echo "<td>$arrayEname[$ctr]</td>";
                        echo "<td>$arrayQty[$ctr]</td>";
                        echo "<td>$arrayOnhand[$ctr]</td>";
                        echo "<td>$arrayCreated[$ctr]</td>";
                        echo "<td>$arrayModified[$ctr]</td>";

                        echo "<td><a href='#' class='btn-block btn-success edit-equipment' id='$arrayID[$ctr]'><i class='fa fa-pencil'></a></td>";
                      }
                  ?>
                </table>
              </div>
              <!-- /.box-body -->
            </div><!--===END OF BOX==-->
          </div><!--===END OF COL===-->
        </div><!--==END OF ROW==-->
      </section>
    </div>

    <!-- <script src="./js/jquery-2.2.3.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="././plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="././plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="./js/app.min.js"></script> -->
  </body>
</html>

<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>

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

