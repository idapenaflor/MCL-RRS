<?php
	require('connects.php');

	$equipID = $_GET['equipID'];
	$output = '';
	$id = '';
	$ename = '';
	$qty = '';
	$onhand = '';
	$modified = '';


	$getEquipment = mysqli_query($con,"select * from equipment where eid='$equipID'");
	
	if(mysqli_num_rows($getEquipment) > 0)
	{
	  while($row = mysqli_fetch_array($getEquipment))
	  {
	     $id = $row['eid'];
	     $ename = $row['ename'];
	     $qty = $row['qty'];
	     $onhand = $row['onhand'];
	  }
	}

	$output .= "
		<p><h3>Equipment Details</h3></p>
		<table class='table table-hover'>
			<tr>
				<th>ID</th>
				<td>$id</td>
				<input type='hidden' name='id' value='$id'>
			</tr>
			<tr>
				<th>Name</th>
				<td><input type='text' name='ename' value='$ename' readonly/></td>
			</tr>
			<tr>
				<th>Quantity</th>
				<td><input type='number' name='qty' value='$qty' min='1' /></td>
			</tr>
			<tr>
				<th>Onhand</th>
				<td><input type='number' name='onhand' value='$onhand' min='1' max='$qty' /></td>
			</tr>

		</table>
	";

	echo $output;
?>
