<?php 
	$begining = $_POST["begining"];

	$hours = explode(':',$begining)[0]*3600;
	$minutes = explode(':', $begining )[1]*60;

	//begining time in secs
	$begining_time = $hours+$minutes;

	$amount_rest_day_1 = $_POST["amount_rest_day_1"];
	$amount_rest_day_2 = $_POST["amount_rest_day_2"];

	$rest_time = $_POST["duration_rest"];
	
	$minutes_rest = explode(':', $rest_time)[0]*60;
	$seconds_rest = explode(':',$rest_time)[1];
	
	//rest time in secs
	$rest_time = $minutes_rest + $seconds_rest;


	// sql->connect
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

	//day 1
	$sql_28 = "SELECT id, COUNT(*) as row_amount, user_id,nomination, duration, team_name, dance_style, fio, city, file_name, TIME_TO_SEC(duration) as sec_dur  FROM `DATA_INPUT` WHERE nomination != 'Street Show' and nomination !='Show Girls' ORDER by min_age  , skill_level";
	//day 2
	$sql_29 = 'SELECT id, COUNT(*) as row_amount, user_id,nomination, duration, team_name, dance_style, fio, city, file_name, TIME_TO_SEC(duration) as sec_dur FROM `DATA_INPUT` WHERE nomination = "Street Show" or  nomination ="Show Girls" ORDER by min_age  , skill_level;';
	
	//max_form
	$sql_max = 'SELECT max(id) as max_form from DATA_INPUT;';


	$res_day_1 = $conn->query($sql_28);
	$res_day_2 = $conn->query($sql_29);
	$query_form_day_1 = $res_day_1->fetch_assoc();
	$query_form_day_2 = $res_day_2->fetch_assoc();

	$interval_day_1 = $query_form_day_1["row_amount"]/($amount_rest_day_1+ 1);
	$interval_day_2 = $query_form_day_2["row_amount"]/($amount_rest_day_2 + 1);


	$result_28 = $conn->query($sql_28);
	$result_29 = $conn->query($sql_29);
	$result_max = $conn->query($sql_max);
	
	//get result of sql_max query 
	$amount_in_section = $result_max->fetch_assoc();

	//how much dances in 1 section (before rest)
	$interval = $amount_in_section["max_form"]/($amount_rest + 1);
	
	//day 1
	

	
	$counter = 1;
	//amount of rests
	$counter_rest = 1;
	//
	$index = 1;
	
	$day1 = array();
	$day2 = array();


	while($day_1 = $result_28->fetch_assoc()) {
		// if ($index%$amount_rest==0) {
		// 	echo  $counter_rest . "::".$rest_time."::" .gmdate("H:i:s",$begining_time).":::"; 
		// 	$begining_time+= $rest_time;
		// 	$counter_rest++;
		// 	echo $counter."::".$day_1["id"]."::".$day_1["duration"]."::".$day_1["nomination"]."::".$day_1["team_name"]."::".$day_1["dance_style"]."::".$day_1["fio"]."::".$day_1["city"]."::".$day_1["file_name"]."::".gmdate("H:i:s",$begining_time).":::";
			
		// 	$counter++;
		// }
		// else{
			$row1 = $counter."::".$day_1["id"]."::".$day_1["duration"]."::".$day_1["nomination"]."::".$day_1["team_name"]."::".$day_1["dance_style"]."::".$day_1["fio"]."::".$day_1["city"]."::".$day_1["file_name"]."::".gmdate("H:i:s",$begining_time).":::";
			$counter++;
			array_push($day1, $row1);
			$begining_time+=$day_1["sec_dur"]+60;
		// }

		// $index++;
		// echo $result_info;
	}
	//day 2
	
	while($day_2 = $result_29->fetch_assoc()) {
		// if ($index%$amount_rest==0) {
		// 	echo $counter_rest . "::".$rest_time."::" .gmdate("H:i:s",$begining_time).":::"; 
		// 	$begining_time+= $rest_time;
		// 	$counter_rest++;
		// 	$begining_time+=$day_2["sec_dur"];

		// 	echo $counter."::".$day_2["id"]."::".$day_2["duration"]."::".
		// 	$day_2["nomination"]."::".$day_2["team_name"]."::".$day_2["dance_style"]."::".$day_2["fio"]."::".$day_2["city"]."::".$day_2["file_name"]."::".gmdate("H:i:s",$begining_time).":::";
		// 	$begining_time+=$day_2["sec_dur"]+60;
		// 	$counter++;
		// }else{

			$row2 = $counter."::".$day_2["id"]."::".$day_2["duration"]."::".
			$day_2["nomination"]."::".$day_2["team_name"]."::".$day_2["dance_style"]."::".$day_2["fio"]."::".$day_2["city"]."::".$day_2["file_name"]."::".gmdate("H:i:s",$begining_time).":::";
			array_push($day2, $row2);
			$begining_time+=$day_2["sec_dur"]+60;
			// $counter++;
		// }
		// $index++;
		// echo $result_info;
	}
	echo "28 Марта:::";
	$chunked_day_1 = array_chunk($day1, $interval_day_1);
	$chunked_day_2 = array_chunk($day2, $interval_day_2);
	
	var_dump($chunked_day_1);
	var_dump($chunked_day_2);

	for ($i=0; $i < count($chunked_day_1); $i++) { 
		for ($j=0; $j < count($chunked_day_1[i]) ; $j++) { 
			echo $chunked_day_1[i][j];
			$begining_time+=$day_1["sec_dur"]+60;
		}
		echo  $counter_rest . "::".$rest_time."::" .gmdate("H:i:s",$begining_time).":::"; 
		$begining_time+= $rest_time;
	}
	echo  "29 Марта:::";

	for ($i=0; $i < count($chunked_day_2); $i++) { 
		for ($j=0; $j < count($chunked_day_2[i]) ; $j++) { 
			echo $chunked_day_2[i][j];
			$begining_time+=$day_2["sec_dur"]+60;
		}
		echo  $counter_rest . "::".$rest_time."::" .gmdate("H:i:s",$begining_time).":::"; 
		$begining_time+= $rest_time;
	}



	// echo $result_info;

 ?>