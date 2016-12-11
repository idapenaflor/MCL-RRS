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
  include('qConn.php');
  
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

      $getRequests = CheckIfAdmin($con,$department,$type,$month);

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

            $query = EquipRequest($con,$arrayID[$ctr]);

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

<script src="./js/dataTable.js"></script>