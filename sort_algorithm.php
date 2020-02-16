<?php 
	$servername = "bestda01.mysql.tools";
	$username = "bestda01_db";
	$password = "LuyjNXUD";
	$dbname = "bestda01_db";


	$conn = new mysqli($servername, $username, $password, $dbname);
		
	if(!$conn->set_charset("utf8")){
		echo "ошибка кодировки";
	}
	if ($conn->connect_error){
		die("Connection error: ");
	}

	$sql = "SELECT * FROM DATA_INPUT";
	if ($conn->query($sql_input) === TRUE) {
		// echo "record updated successfully";	
	}
	$date = array();
	while($row = $result->fetch_assoc()) {
		array_push($date, array($row["id"], $row["user_id"],
								$row["nomination"], $row["category"],
								$row["skill_level"], $row["group_age"],
								$row["fio"], $row["email"],$row["facebook"],
								$row["city"], $row["number_name"], $row["team_name"],
								$row["duration"], $row["max_age"], $row["min_age"],
								$row["file_name"], $row["dance_style"]));
	}

 ?>