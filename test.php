<?php 
	$servername = "bestda01.mysql.tools";
	$username = "bestda01_db";
	$password = "LuyjNXUD";
	$dbname = "bestda01_db";

	$sql = "SELECT `AUTO_INCREMENT` AS increment
			FROM  INFORMATION_SCHEMA.TABLES
			WHERE TABLE_SCHEMA = 'bestda01_db'
			AND   TABLE_NAME   = 'DATA_INPUT';";
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_error){
		die("Connection error: ");
	}
	$res_max = $conn->query($sql);
	$row = $res_max->fetch_assoc(); 
	echo $row["increment"];

 ?>