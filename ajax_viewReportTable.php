<table id="report-table" class="table table-bordered table-hover report-table">
  <thead>
    <tr>
      <th>Request ID</th>
      <th>Department</th>
      <th>Date Filed</th>
      <th>Date of Use</th>
      <th>Room</th>
      <th>Status</th> 
    </tr>
  </thead>
<?php
  include('connects.php');
  
  $output = '';
  $month = $_POST['month'];
  $type = $_POST['type'];

  $arrayID = array();
  $arrayDept = array();
  $arrayDateFiled = array();
  $arrayDateUse = array();
  $arrayRoom = array();
  $arrayStatus = array();

      if($type == 'LMO')
      {
        $getRequests = mysqli_query($con,"select * from requests join action on requests.requestID=action.requestID where action.lmoAction!='N/A' and requests.status='Approved' and requests.dateOfFiling like '$month%'");
      }
      else
      {
        $getRequests = mysqli_query($con,"select * from requests where status='Approved' and dateOfFiling like '$month%'");
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
            $output .="
            <tr>
            <td>$arrayDept[$ctr]</td>
            <td>$arrayDateFiled[$ctr]</td>
            <td>$arrayDateUse[$ctr]</td>
            <td>$arrayRoom[$ctr]</td>
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