<?php 
	$begining = $_POST["begining"];
	$hours = explode(':',$begining)[0]*3600;
	$minutes = explode(':', $begining )[1]*60;
	$file_open = fopen("autotiming.csv", 'w');
	fputcsv($file_open,"");
	fclose($file_open);
	$global_data = array(
						array("Номер",
							"Длительность",
							"Категория",
							"Номинация",
							"Название команды",
							"Стиль танца",
							"ФИО",
							"Город",
							"Кол-во участников",
							"Музыка",
							"Начало"));
	//begining time in secs
	$begining_time = $hours+$minutes;
	$begining_time_2 = $hours+$minutes;
	// $rest_time = $_POST["duration_rest"];
	
	// $minutes_rest = explode(':', $rest_time)[0]*60;
	// $seconds_rest = explode(':',$rest_time)[1];
	
	// //rest time in secs
	// $rest_time = $minutes_rest + $seconds_rest;


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
	$sql_28 = "SELECT id, nomination, category, amount, duration, team_name, dance_style, fio, city, file_name, TIME_TO_SEC(duration) as sec_dur  FROM `DATA_INPUT` WHERE nomination != 'Street Show' and nomination !='Show Girls' ORDER by min_age  , skill_level";
	//day 2
	$sql_29 = 'SELECT id, nomination, category, amount, duration, team_name, dance_style, fio, city, file_name, TIME_TO_SEC(duration) as sec_dur FROM `DATA_INPUT` WHERE nomination = "Street Show" or  nomination ="Show Girls" ORDER by min_age  , skill_level;' ;
	
	$result_28 = $conn->query($sql_28);
	$result_29 = $conn->query($sql_29);

	$counter = 0;
	$counter_day_2 = 2;
	//amount of rests
	$counter_rest_1 = $interval_day_1;
	$counter_rest_2 = $interval_day_2;

	

	echo "28 Марта::" .gmdate("H:i:s",$begining_time).":::";

	$file_data = array("28 March","","","","","","","","","",gmdate("H:i:s",$begining_time));
	array_push($global_data, $file_data);
//	fputcsv($file_open, $file_data); 
	while($day_1 = $result_28->fetch_assoc()) {
		$counter_day_2 ++;
		$file_data = array($day_1["id"],$day_1["duration"],
						$day_1["category"],
						$day_1["nomination"],
						$day_1["team_name"],
						$day_1["dance_style"],
						$day_1["fio"],
						$day_1["city"],
						$day_1["amount"],
						$day_1["file_name"],
						"=SUM(B".$counter_day_2.";"."I".($counter_day_2-1).")"
	 	);
	 	array_push($global_data, $file_data);
	 	// fputcsv($file_open, $file_data); 
		echo $counter."::".$day_1["id"]."::".$day_1["duration"]."::".$day_1["category"]."::".$day_1["nomination"]."::".$day_1["team_name"]."::".$day_1["dance_style"]."::".$day_1["fio"]."::".$day_1["city"].$day_1["amount"]."::"."::".$day_1["file_name"]."::=SUM(B".$counter_day_2.";"."I".($counter_day_2-1)."):::";
	}
	$counter_day_2++;
	$counter = 0;
	//day 2
	echo "29 Марта::" .gmdate("H:i:s",$begining_time).":::";
	$file_data = array("29 March","","","","","","","","","",gmdate("H:i:s",$begining_time));
	array_push($global_data, $file_data);
	// fputcsv($file_open, $file_data); 
	while($day_2 = $result_29->fetch_assoc()) {
		$counter_day_2 ++;
		$counter++;
		$file_data = array($day_2["id"],$day_2["duration"],
						$day_2["category"],
						$day_2["nomination"],
						$day_2["team_name"],
						$day_2["dance_style"],
						$day_2["fio"],
						$day_2["city"],
						$day_2["amount"],
						$day_2["file_name"],
						"=SUM(B".$counter_day_2.";"."I".($counter_day_2-1).")"
	 	);
	 	array_push($global_data, $file_data);
	 	// fputcsv($file_open, $file_data); 
		
		echo $counter."::".$day_2["id"]."::".$day_2["duration"]."::".$day_2["category"]."::".
		$day_2["nomination"]."::".$day_2["team_name"]."::".$day_2["dance_style"]."::".$day_2["fio"]."::".$day_2["city"]."::".$day_2["amount"]."::".$day_2["file_name"]."::=SUM(B".$counter_day_2.";"."I".($counter_day_2-1)."):::";
	}

	
	print_r($global_data);
	$file_open = fopen("autotiming.csv", 'w');
	foreach ($global_data as $row) {
		echo "string";
		fputcsv($file_open, $row);
	}
	// fclose($file_open);
	fclose($file_open);
 ?>