<?php
include ("./inc/connect.inc.php"); 

$sql=mysqli_query($con,"SELECT * FROM catclothes WHERE `master` = 50010 OR `master` = 50020");
if(mysqli_num_rows($sql)){
	$data=array();
	while($row=mysqli_fetch_array($sql)){
		$data[] = array(
			'id' => $row['id'],
			'name'=> $row['name']
		);
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

?>

