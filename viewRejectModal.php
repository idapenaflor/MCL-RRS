<?php
	include('connects.php');

	$requestID = $_POST['requestID'];
	$action = $_POST['action'];

	$output='';

	if($action == 'Rejected')
	{
		$output .="
			<div class='required'>
	    	<label><h3>Remarks</h3></label><br/>
	    	<input type='text' name='remarks' class='form-control'>
	    	<input type='hidden' name='requestID' value='$requestID'>
	    	<input type='hidden' name='action' value='$action'>
			</div>";
	}

	else
	{
		$output .="
			<input type='hidden' name='remarks' value='0'>
	    	<input type='hidden' name='requestID' value='$requestID'>
	    	<input type='hidden' name='action' value='$action'>
			";
	}
	echo $output;
?>

<style>
    .required:before
    {
    	content:" *";
    }
</style>​