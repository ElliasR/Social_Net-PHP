<?php /*xxx*/function test_input($data) {$data = trim($data);$data = stripslashes($data);$data = htmlspecialchars($data); return $data;}
include ("./inc/connect.inc.php"); 

	/*xxx*/$filtrado = test_input($_GET['sid']);
$getsid= mysqli_real_escape_string($con,$filtrado);

$districtsquery=mysqli_query($con,"SELECT * FROM catbody2nd WHERE bodycat=$getsid");
if(mysqli_num_rows($districtsquery)){
	$data=array();	
	while($row=mysqli_fetch_array($districtsquery)){	
		$data[]=array(
			'id'=>$row['bodyid'],
			'sid'=>$row['bodycat'],
			'name'=>$row['bodysub']
		);
	}
	header('Content-type:application/json');	
	echo json_encode($data);	
}

?>