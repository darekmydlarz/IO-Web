<?php
	header('Access-Control-Allow-Origin: http://localhost');
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link rel='stylesheet' type='text/css' href='./css/style.css' />
		<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
		<script type='text/javascript' src='./js/graph.js'></script>
		<meta http-equiv="Access-Control-Allow-Origin" content="*"> 
		<script type='text/javascript'>jQuery(document).parseXml();</script>
	</head>
	<body>
		<canvas id="myCanvas" width="1800" height="800"></canvas>
	</body>
</html>
