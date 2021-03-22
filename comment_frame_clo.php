<?php 
session_start();
if (isset($_SESSION['user_login'])){
	$username=$_SESSION['user_login'];
}
else{
	$username="";
}
?>

<style>
	*{
		font-size:13px;
		font-family:Arial, Helvetica, Sans-serif;
		background-color:white;
	}
</style>

<?php	/*xxx*/function test_input($data) {$data = trim($data);$data = stripslashes($data);$data = htmlspecialchars($data, ENT_QUOTES); return $data;}
include("inc/connect.inc.php");
/*xxx*/$filtrado = test_input($_GET['id']);
	$getid= mysqli_real_escape_string($con,$filtrado);
?>

<script language="javascript">
	function toggle(){
		var ele = document.getElementById("toggleComment");
		var text = document.getElementById("displayComment");
		if(ele.style.display =="block"){
			ele.style.display="none";
		}
		else{
			ele.style.display="block";
		}
	}
</script>
<?php 
if (isset($_POST['postcomment' . $getid . ''])){
	
		/*xxx*/$filtrado = test_input($_POST['post_body']);
	$post_body= mysqli_real_escape_string($con,$filtrado);	
	$posted_to= "";
	$date= date('Y-m-d H:i:s');
	$insertpost= mysqli_query($con,"INSERT INTO post_comments_clo VALUES ('','$post_body','$username','$posted_to','0','$getid','$date')");
}
?>


<a href='javascript:;' onClick="javascript:toggle()"><div style='float:right; display:inline;'>Post a comment</div></a>
<div id='toggleComment' style='display:none;'>
	<form action="comment_frame_clo.php?id=<?php echo htmlspecialchars($getid);?>" method="POST" name="postcomment<?php echo htmlspecialchars($getid);?>">
		Enter your answer below:<p/>
		<textarea rols="50" cols="50" style="height:100px;" name="post_body";></textarea>
		<input type="submit" name="postcomment<?php echo htmlspecialchars($getid);?>" value="Post comment">
	</form>
</div>
<?php

//Get relevant comments 
$get_comments=mysqli_query($con,"SELECT * FROM post_comments_clo WHERE post_id='$getid' ORDER BY id ASC");
$count=mysqli_num_rows($get_comments);
if($count!=0){
	while ($comment=mysqli_fetch_assoc($get_comments)){

		$comment_body=$comment['post_body'];
		$posted_to=$comment['posted_to'];
		$posted_by=$comment['posted_by'];
		$removed=$comment['post_removed'];
		$date=$comment['date'];
		echo "$date - <b><u>$posted_by said:</b></u><br/><br/>$comment_body<hr/><br>";
	}
}
else{
	echo"<center><br><br>No comments</center>";
}
?>
