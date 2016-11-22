<?php
	include('connects.php');
	$output = '';

	$output .= "
		<p><h3>Equipment Details</h3></p>
		<table class='table table-hover'>
			<tr>
				<th>Name</th>
				<td><input type='text' name='ename' required=required/></td>
			</tr>
			<tr>
				<th>Quantity</th>
				<td><input type='number' name='qty' min='1' required=required/></td>
			</tr>
		</table>
	";

	echo $output;
?>
