<?php
	include('connects.php');

	$requestID = $_POST['requestID'];
	$output = '';
	$deanAction = '';
	$cdmoAction = '';
	$lmoAction = '';
	$deanDate = '';
	$cdmoDate = '';
	$lmoDate = '';
	$remarks = '';
	$deanColor = 'black';
	$cdmoColor = '';
	$lmoColor = '';
	$deanStyle = '';
	$cdmoStyle = '';
	$lmoStyle = '';
	$req_status = '';

	$query1 = mysql_query("select status from requests where requestID='$requestID'");

	if(mysql_num_rows($query1)>0)
	{
		while($row = mysql_fetch_array($query1))
		{
		  $req_status = $row['status'];
		} 
	}

	$query = mysql_query("select * from action where requestID='$requestID'");

	if(mysql_num_rows($query)>0)
	{
		while($row = mysql_fetch_array($query))
		{
		  $deanAction = $row['deanAction'];
		  $cdmoAction = $row['cdmoAction'];
		  $lmoAction = $row['lmoAction'];
		  $deanDate = $row['deanDate'];
		  $cdmoDate = $row['cdmoDate'];
		  $lmoDate = $row['lmoDate'];
		  //$remarks = $row['remarks'];
		} 
	}

	$query = mysql_query("select * from remarks where requestID='$requestID'");

	if(mysql_num_rows($query)>0)
	{
		while($row = mysql_fetch_array($query))
		{
		  $remarks = $row['remarks'];
		} 
	}

	if($remarks==NULL)
	{
		$remarks = "No remarks";
	}

	switch($deanAction)
	{
		case 'Endorsed': {$deanColor='#0099CC';break;}
		case 'Pending': {$deanColor='#FF8800';break;}
		case 'Rejected': 
		{
			$deanColor='#d9534f';
			$cdmoStyle='text-decoration: line-through';
			$lmoStyle='text-decoration: line-through';
			break;
		}
	}

	switch($cdmoAction)
	{
		case 'Approved': {$cdmoColor='#5cb85c';break;}
		case 'Pending': {$cdmoColor='#FF8800';break;}
		case 'Rejected': 
		{
			$cdmoColor='#d9534f';
			$deanStyle='text-decoration: line-through';
			$lmoStyle='text-decoration: line-through';
			break;
		}
	}

	switch($lmoAction)
	{
		case 'Approved': {$lmoColor='#5cb85c';break;}
		case 'Pending': {$lmoColor='#FF8800';break;}
		case 'Rejected': 
		{
			$lmoColor='#d9534f';
			$cdmoStyle='text-decoration: line-through';
			$deanStyle='text-decoration: line-through';
			break;
		}
	}
	
	$output .="
	<p><h3>Status</h3></p>
	<table class='table table-hover'>
		<tr>
			<th>Dean</th>
			<td style='color:$deanColor;font-weight:800;$deanStyle'>$deanAction</td>
			<td>$deanDate</td>
		</tr>

		<tr>
			<th>CDMO</th>
			<td style='color:$cdmoColor;font-weight:800;$cdmoStyle'>$cdmoAction</td>
			<td>$cdmoDate</td>
		</tr>

		<tr>
			<th>LMO</th>
			<td style='color:$lmoColor;font-weight:800;$lmoStyle'>$lmoAction</td>
			<td>$lmoDate</td>
		</tr>

	</table><br/>
	<p><h3>Remarks</h3></p>
	<table class='table table-hover'>
	<tr><td>$remarks</td></tr>
	</table><br/>";

	$output .="
	<p><h3>Additional Equipment</h3></p>";

	echo $output;

	include('viewEquipmentModal.php');

	if($req_status == 'Approved')
	{
		echo "<div class='modal-footer'>
        <button type='button' class='btn btn-primary' data-dismiss='modal' id='printpermit'>Print Permit</button>
        <button type='button' class='btn btn-success' data-dismiss='modal'>OK</button>
    	 </div>";
	}
	else
	{
		echo "<div class='modal-footer'>
        <button type='button' class='btn btn-success' data-dismiss='modal'>OK</button>
    	 </div>";
	}
	
?>