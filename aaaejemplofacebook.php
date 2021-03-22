<html>
	<head>
	</head>
	<body>
	Esto viene siendo el body 3

		<?php
			$photolink='http://macareno.tk/userdata/user_photos/photoscars/slT58NJXoYZz7mw/AC-cobra.PNG';
			$urllink='http://rankpion.com/aaaejemplofacebook.php';
			$title2="caballuco title";
			$summary2="summarysing...";
			
			
			$urlphoto=urlencode($photolink);
			$urlurl=urlencode($urllink);
			$title=urlencode($title2);
			$summary=urlencode($summary2);
			
			echo $urlphoto.$urlurl.$title;
		?>

		<a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $urlurl; ?>&amp;p[images][0]=<?php echo $urlphoto;?>','sharer','toolbar=0,status=0,width=550,height=300');" href="javascript: void(0)">aa</a>
		
		
		<?php
		
		$nombre="Martin E";
		$trimeao=str_replace(' ', '_', $nombre);
		echo $trimeao;
		
		
		?>
		
	</body>
</html>