<form action = 'printPermit.php' method='post'>
<?php
	require('connects.php');
	include('log-auth.php');
	include('qConn.php');

	$name = $fname . ' ' . $lname;

	$requestID = $_POST['requestID'];
	$purpose = '';
	$dateoffiling = '';
	$dateofuse = '';
	$room = '';
	$from = '';
	$to = '';
	$time = '';
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

	$query1 = ViewRequestDetails($con,$requestID);

	if(mysqli_num_rows($query1)>0)
	{
		while($row = mysqli_fetch_array($query1))
		{
		  	$req_status = $row['status'];	
		  	$purpose = $row['purpose'];
			$dateoffiling = $row['dateOfFiling'];
			$dateofuse = $row['dateOfUse'];
			$room = $row['room'];
			$from = $row['timeFrom'];
			$to = $row['timeTo'];
		} 
	}

	$query = ViewActionDetails($con,$requestID);

	if(mysqli_num_rows($query)>0)
	{
		while($row = mysqli_fetch_array($query))
		{
		  $deanAction = $row['deanAction'];
		  $cdmoAction = $row['cdmoAction'];
		  $lmoAction = $row['lmoAction'];
		  $deanDate = $row['deanDate'];
		  $cdmoDate = $row['cdmoDate'];
		  $lmoDate = $row['lmoDate'];
		} 
	}

	$query = ViewRequestDetailsRemarks($con,$requestID);

	if(mysqli_num_rows($query)>0)
	{
		while($row = mysqli_fetch_array($query))
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

	$time = $from . ' - ' . $to;
	$dateoffiling = date('m/d/Y');
	//HIDDEN VALUES FOR POSTING
	$output .="
		<input type='hidden' id='name' name='name' value='$name'/>
		<input type='hidden' id='dept' name='dept' value='$dept'/>
		<input type='hidden' id='dateoffiling' name='dateoffiling' value='$dateoffiling'/>
		<input type='hidden' id='dateofuse' name='dateofuse' value='$dateofuse'/>
		<input type='hidden' id='purpose' name='purpose' value='$purpose'/>
		<input type='hidden' id='room' name='room' value='$room'/>
		<input type='hidden' id='time' name='time' value='$time'/>

	";
	echo $output;

	include('viewEquipmentModal.php');

	if($req_status == 'Approved')
	{
		$requestID = encryptor($requestID);
		$name = encryptor($name);
		$dept = encryptor($dept);
		$time = encryptor($time);
		$from = encryptor($from);
		$dateofuse = encryptor($dateofuse);
		$dateoffiling = encryptor($dateoffiling);
		$purpose = encryptor($purpose);
		$room = encryptor($room);

		echo "<div class='modal-footer'>
		<a href='printPermit.php?id=$requestID&name=$name&dept=$dept&time=$time&dateofuse=$dateofuse&dateoffiling=$dateoffiling&purpose=$purpose&room=$room' class='btn btn-primary'>Print Permit</a>
        <button type='button' class='btn btn-success' data-dismiss='modal'>OK</button>
    	 </div>";
	}
	else
	{
		echo "<div class='modal-footer'>
        <button type='button' class='btn btn-success' data-dismiss='modal'>OK</button>
    	</div>";
	}

	function encryptor($string)
	{
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $secret_key = 'muni';
	    $secret_iv = 'muni123';
	    $key = hash('sha256', $secret_key);
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);

	    return $output;
	}
?>
</form>