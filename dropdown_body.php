<?php
include ("./inc/connect.inc.php"); 

$sql=mysqli_query($con,"SELECT * FROM catbody");//Get state value uid and pass it in the query to get the districts according to the state
if(mysqli_num_rows($sql)){
	$data=array();	//Declare a variable for the array
	while($row=mysqli_fetch_array($sql)){	//Store id and name in the data array
		$data[] = array(
			'id' => $row['bodyid'],
			'name'=> $row['bodycat']
		);
	}
	header('Content-type: application/json');	//
	echo json_encode($data);	//Enconde $data in json format
}

?>

