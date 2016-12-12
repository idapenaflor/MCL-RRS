<!-- MODAL WHEN U CLICK THE PLUS BUTTON IN SEARCH ROOM -->

<form action='requestRoomModal.php' method='post'>
<?php

	if(isset($_POST['rroom']))
	{
		require('connects.php');
		include('qConn.php');

		$output = '';

		$room = $_POST['rroom'];
		$rtype = $_POST['rtype'];
		$from = $_POST['from'];
		$to = $_POST['to'];
		$date = $_POST['date'];

		//DINAGDAG NI IDA 11/04
		$fromTime = GetFromTime($con,$from);
		$toTime = GetToTime($con,$to);

		$arrayEquipments = array();
		$arrayQty = array();

		$tempId = array();
	    $tempFrom = array();
	    $tempTo = array();
	    $id = array();

	    $finalId = array();

		//GET ALL EQUIPMENT AND QTY
		$query = ViewAllEquip($con);

		if(mysqli_num_rows($query)>0)
	    {
	      while($row = mysqli_fetch_array($query))
	      {
	        $arrayEquipments[] = $row['ename'];
	        $arrayQty[] = $row['qty'];
	      } 
	    }

	    //GET REQUESTS ID OF REQUEST WITH SIMILAR DATE OF USE
	    $queryGetSimilarRequest = SelectSimilarRequest($con,$date);

		if(mysqli_num_rows($queryGetSimilarRequest)>0)
	    {
	      while($row = mysqli_fetch_array($queryGetSimilarRequest))
	      {
	        $tempId[] = $row['requestID'];
	        $tempFrom[] = ConvertToTid($con,$row['timeFrom']);
        	$tempTo[] = ConvertToTid($con,$row['timeTo']);
	      } 
	    }

	    //COMPARE IF TIME IS WITHIN REQUEST TIME RANGE
	    for($ctr=0; $ctr<count($tempId); $ctr++)
	    {
	      if(($tempFrom[$ctr] > $from && $tempFrom[$ctr] < $to) || ($tempTo[$ctr] > $from && $tempTo[$ctr] < $to) || ($tempFrom[$ctr] <= $from && $tempTo[$ctr] >= $to))
	      {
	        
	      }
	      else
	      {
	      	$tempId = array_diff($tempId, array($tempId[$ctr]));
	      }
	    }

	    $finalId = array_values($tempId);

	    //echo count($finalId);
	    for($ctr=0; $ctr<count($finalId); $ctr++)
	    {
	    	for($ctr2=0; $ctr2<count($arrayEquipments); $ctr2++)
	    	{
	    		$query = SelectEquipRequest($con,$finalId[$ctr],$arrayEquipments[$ctr2]);

		    	if(mysqli_num_rows($query)>0)
			    {
			      while($row = mysqli_fetch_array($query))
			      {
			        $arrayQty[$ctr2] = $arrayQty[$ctr2] - $row['qty'];
			      } 
			    }
			}
	    }

	    $output .="
	    <table class='table table-striped table-details'>
	    		<!-- DINAGDAG NI IDA 11/04 -->
	    		<thead>
	    			<th>Room</th>
	    			<td>$room</td>
	    			<input type='hidden' id='room' name='room' value='$room'>
	    			<input type='hidden' name='rtype' value='$rtype'>
	    			<th>Date of Use</th>
	    			<td>$date</td>
	    			<input type='hidden' name='date' value='$date'>
	    		</thead>
	    		<thead>
	    			<th colspan=1>Time of Use</th>
	    			<td colspan=3>$fromTime - $toTime</td>
	    			<input type='hidden' name='fromTime' value='$fromTime'>
	    			<input type='hidden' name='toTime' value='$toTime'>

	    		</thead>
	    		<!-- HANGGANG DITO BES -->

	    		<thead>
	    			<th colspan=1>Purpose of Activity</th>
	    			<th colspan=3><input type='text' name='purpose' id='purpose' required='required'></th>

	    		</thead>
	    		<thead>
	    			<th colspan=4>Additional Equipment</th>
	    		</thead>
		    	<thead>
		    		<th>Item</th>
		    		<th>Quantity</th>
		    		<th>Item</th>
		    		<th>Quantity</th>
		    	</thead>";
	    for($ctr = 0 ; $ctr < count($arrayEquipments) ; $ctr++)
	    {
	    	if($ctr%2 == 0)
	    	{
	    		$ctr2 = $ctr + 1;

	    		if($ctr2==count($arrayEquipments))
	    		{
	    			$output .="
			    	<tr>
			    		<td><input type='checkbox' name='equipment[]' value='$arrayEquipments[$ctr]' class='check-equipment'>  $arrayEquipments[$ctr]</input></td>
			    		<td><input type='number' name='qty[]' id='$arrayEquipments[$ctr]' disabled=true></input></td>
			    		<input type='hidden' name='$arrayEquipments[$ctr]' value='$arrayQty[$ctr]'>
			    	</tr>";
	    		}
	    		else
	    		{
			    	$output .="
				    	<tr>
				    		<td><input type='checkbox' name='equipment[]' value='$arrayEquipments[$ctr]' class='check-equipment'>  $arrayEquipments[$ctr]</input></td>
				    		<td><input type='number' name='qty[]' id='$arrayEquipments[$ctr]' disabled=true></input></td>
							<input type='hidden' name='$arrayEquipments[$ctr]' value='$arrayQty[$ctr]'>

				    		<td><input type='checkbox' name='equipment[]' value='$arrayEquipments[$ctr2]' class='check-equipment'>  $arrayEquipments[$ctr2]</input></td>
				    		<td><input type='number' name='qty[]' id='$arrayEquipments[$ctr2]' disabled=true></input></td>
				    		<input type='hidden' name='$arrayEquipments[$ctr2]' value='$arrayQty[$ctr2]'>

				    	</tr>";
			    }
		    }
	    }

	    $output .="</table>
	    <div class='modal-footer'>
      	<input type='submit' name='request' value='Request' class='btn btn-success'/>
        <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
        </div>";

	    echo $output;
	}
?>
</form>


<script type="text/javascript">
	$('.check-equipment').click(function()
    {
      var equip = $(this).val();

      if($(this).is(':checked'))
      {       
        document.getElementById(equip).disabled = false;
        document.getElementById(equip).value = document.getElementsByName(equip)[0].value;
      }
      else
      {
        document.getElementById(equip).disabled = true;
        document.getElementById(equip).value = "";
      }  
    });
</script>