<table id="report-table" class="table table-bordered table-hover report-table">
  <thead>
    <tr>
      <th>Department</th>
      <th>Purpose</th>
      <th>Date Filed</th>
      <th>Date of Use</th>
      <th>Room</th>
      <th>Equipment</th> 
    </tr>
  </thead>
<?php
  include('connects.php');
  
  $output = '';
  $month = $_POST['month'];
  $type = $_POST['type'];
  $department = $_POST['department'];

  $arrayID = array();
  $arrayDept = array();
  $arrayDateFiled = array();
  $arrayDateUse = array();
  $arrayRoom = array();
  $arrayStatus = array();
  $arrayPurpose = array();

      if($department == 'All')
      {
        if($type == 'LMO')
        {
          $getRequests = mysqli_query($con,"select * from requests join action on requests.requestID=action.requestID where action.lmoAction!='N/A' and requests.status='Approved' and requests.dateOfUse like '$month%'");
        }
        else
        {
          $getRequests = mysqli_query($con,"select * from requests where status='Approved' and dateOfUse like '$month%'");
        }
      }
      else
      {
        if($type == 'LMO')
        {
          $getRequests = mysqli_query($con,"select * from requests join action on requests.requestID=action.requestID where action.lmoAction!='N/A' and requests.status='Approved' and requests.dateOfUse like '$month%' and requests.dept='$department'");
        }
        else
        {
          $getRequests = mysqli_query($con,"select * from requests where status='Approved' and dateOfUse like '$month%' and dept='$department'");
        }
      }

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
        }
        else
        {
          //$output = 'No Requests.';
        }

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
            <td style='width:200pt;overflow:hidden;'>$equip</td>
            </tr>";
          }
          $output .= "</table>";
        }

      echo $output;
  ?>

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