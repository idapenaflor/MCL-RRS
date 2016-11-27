<?php
  include('connects.php');

  $arrayEquipments = array();
  $arrayQty = array();
  $output = '';

  $requestID = $_POST['requestID'];

  $query = mysqli_query($con,"select * from equipmentrequest where requestID='$requestID'");

  if(mysqli_num_rows($query)>0)
  {
    while($row = mysqli_fetch_array($query))
    {
      $arrayEquipments[] = $row['ename'];
      $arrayQty[] = $row['qty'];
    } 
  }

  if(count($arrayEquipments) == 0)
  {
    $output = "No Equipment Requested";
  }
  else
  {
    $output .="
      <table class='table table-hover table-details'>
      <thead>
        <th>Equipment</th>
        <th>Quantity</th>
      </thead>";

    for($ctr = 0 ; $ctr < count($arrayEquipments) ; $ctr++)
    {
      $output .="
        <tr>
          <td>$arrayEquipments[$ctr]</td>
           <td>$arrayQty[$ctr]</td>
        </tr>";
    }

    $output .="</table>";
  }

  echo $output;
?>