<?php 
	$begining = $_POST["begining"];

	$hours = explode(':',$begining)[0]*3600;
	$minutes = explode(':', $begining )[1]*60;

	//begining time in secs
	$begining_time = $hours+$minutes;
	$begining_time_2 = $hours+$minutes;
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
	$sql_28 = "SELECT id,  user_id,nomination, duration, team_name, dance_style, fio, city, file_name, TIME_TO_SEC(duration) as sec_dur  FROM `DATA_INPUT` WHERE nomination != 'Street Show' and nomination !='Show Girls' ORDER by min_age  , skill_level";
	//day 2
	$sql_29 = 'SELECT id, user_id,nomination, duration, team_name, dance_style, fio, city, file_name, TIME_TO_SEC(duration) as sec_dur FROM `DATA_INPUT` WHERE nomination = "Street Show" or  nomination ="Show Girls" ORDER by min_age  , skill_level;' ;
	
	$sql_amount_form_day_1 = "SELECT COUNT(*) as day1 FROM DATA_INPUT WHERE nomination != 'Street Show' and nomination !='Show Girls';" ;

	$sql_amount_form_day_2 = "SELECT COUNT(*) as day2 FROM DATA_INPUT WHERE nomination = 'Street Show' or nomination ='Show Girls';";

	$res_amount_for_day_1 = $conn->query($sql_amount_form_day_1);
	$res_amount_for_day_2 = $conn->query($sql_amount_form_day_2);

	$result_28 = $conn->query($sql_28);
	$result_29 = $conn->query($sql_29);

	$day_1_count =  $res_amount_for_day_1->fetch_assoc();
	$day_2_count =  $res_amount_for_day_2->fetch_assoc();

	$interval_day_1 = round($day_1_count["day1"] / ($amount_rest_day_1 + 1));
	$interval_day_2 = round($day_2_count["day2"] / ($amount_rest_day_1 + 1));
	//max_form


	// $interval_day_1 = $query_form_day_1["row_amount"]/($amount_rest_day_1+ 1);
	// $interval_day_2 = $query_form_day_2["row_amount"]/($amount_rest_day_2 + 1);


	
	
	$counter = 0;
	//amount of rests
	$counter_rest_1 = $interval_day_1;
	$counter_rest_2 = $interval_day_2;
	$day1 = array();
	$day2 = array();

	echo "28 Марта:::";
	while($day_1 = $result_28->fetch_assoc()) {

		if ($counter == $counter_rest_1) {
			$counter++;
			echo  $counter_rest . "::".$rest_time."::" .gmdate("H:i:s",$begining_time).":::"; 
			$begining_time+= $rest_time;
			$counter_rest++;
			echo $counter."::".$day_1["id"]."::".$day_1["duration"]."::".$day_1["nomination"]."::".$day_1["team_name"]."::".$day_1["dance_style"]."::".$day_1["fio"]."::".$day_1["city"]."::".$day_1["file_name"]."::".gmdate("H:i:s",$begining_time).":::";
			
			$counter_rest_1 += $interval_day_1;
		}
		else{
			$counter++;
			echo $counter."::".$day_1["id"]."::".$day_1["duration"]."::".$day_1["nomination"]."::".$day_1["team_name"]."::".$day_1["dance_style"]."::".$day_1["fio"]."::".$day_1["city"]."::".$day_1["file_name"]."::".gmdate("H:i:s",$begining_time).":::";
			$begining_time+=$day_1["sec_dur"]+60;
		}

	}

	$counter = 0;
	//day 2
	echo  "29 Марта:::";

	while($day_2 = $result_29->fetch_assoc()) {

		if ($counter == $counter_rest_2) {
			echo $counter_rest . "::".$rest_time."::" .gmdate("H:i:s",$begining_time_2).":::"; 
			$begining_time_2+= $rest_time;
			$counter_rest+=$interval_day_2;
			$begining_time+=$day_2["sec_dur"];

			$counter++;
			echo $counter."::".$day_2["id"]."::".$day_2["duration"]."::".
			$day_2["nomination"]."::".$day_2["team_name"]."::".$day_2["dance_style"]."::".$day_2["fio"]."::".$day_2["city"]."::".$day_2["file_name"]."::".gmdate("H:i:s",$begining_time).":::";
			$begining_time+=$day_2["sec_dur"]+60;
		}else{

			$counter++;
			echo $counter."::".$day_2["id"]."::".$day_2["duration"]."::".
			$day_2["nomination"]."::".$day_2["team_name"]."::".$day_2["dance_style"]."::".$day_2["fio"]."::".$day_2["city"]."::".$day_2["file_name"]."::".gmdate("H:i:s",$begining_time).":::";
			$begining_time+=$day_1["sec_dur"]+60;
		}
	}
	

 ?>