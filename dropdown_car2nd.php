<?php /*xxx*/function test_input($data) {$data = trim($data);$data = stripslashes($data);$data = htmlspecialchars($data); return $data;}
include ("./inc/connect.inc.php"); 

	/*xxx*/$filtrado = test_input($_GET['sid']);
$getsid= mysqli_real_escape_string($con,$filtrado);

$districtsquery=mysqli_query($con,"SELECT * FROM catcars WHERE master=$getsid ORDER BY model ASC");
if(mysqli_num_rows($districtsquery)){
	$data=array();	
	while($row=mysqli_fetch_array($districtsquery)){
		$data[]=array(
			'id'=>$row['id'],
			'sid'=>$row['master'],
			'name'=>$row['model']
		);
	}
	header('Content-type:application/json');
	echo json_encode($data);
}

?>