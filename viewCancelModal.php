<?php
	include('connects.php');

	$requestID = $_POST['requestID'];

	$output='';

	$output .="
		<div class='required'>
    	<label><h3>Remarks</h3></label><br/>
    	<input type='text' name='remarks' class='form-control' required='required'>
    	<input type='hidden' name='requestID' value='$requestID' required='required'>
		</div>";

	echo $output;
?>

<style>
    .required:before
    {
    	content:" *";
    }
</style>​