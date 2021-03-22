<?php
include ("./inc/connect.inc.php"); 

$sql=mysqli_query($con,"SELECT * FROM catcars WHERE `master` = 0 ORDER BY model ASC");
if(mysqli_num_rows($sql)){
	$data=array();	
	while($row=mysqli_fetch_array($sql)){	
		$data[] = array(
			'id' => $row['id'],
			'name'=> $row['model']
		);
	}
	header('Content-type: application/json');	
	echo json_encode($data);	
}

?>

