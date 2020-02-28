<?php 
	$begining = $_POST["begining"];
	$hours = explode(':',$begining)[0]*3600;
	$minutes = explode(':', $begining )[1]*60;
	$file_name_date_time = "'autotiming_". date("h:i:sa")."_". date("Y/m/d").".csv'";
	echo $file_name_date_time;
	$file_open = fopen("autotiming_". date("h_i")."_". date("Y_m_d").".csv", 'w');
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
	$sql_28 = "SELECT id, nomination,number_name, category, amount, duration, team_name, dance_style, fio, city, file_name, TIME_TO_SEC(duration) as sec_dur  FROM `DATA_INPUT` WHERE nomination != 'Street Show' and nomination !='Show Girls' ORDER by min_age  , skill_level";
	//day 2
	$sql_29 = 'SELECT id, nomination,number_name, category, amount, duration, team_name, dance_style, fio, city, file_name, TIME_TO_SEC(duration) as sec_dur FROM `DATA_INPUT` WHERE nomination = "Street Show" or  nomination ="Show Girls" ORDER by min_age  , skill_level;' ;
	

	$sql_little_stars = "SELECT * FROM DATA_INPUT WHERE group_age = '4-6 Little stars';";
	$sql_street_show = "SELECT * FROM DATA_INPUT WHERE nomination = 'Street Show' and group_age != '4-6 Little stars';";
	$sql_show_girls = "SELECT * FROM DATA_INPUT WHERE nomination = 'Show Girls' and group_age != '4-6 Little stars';";
	$sql_modern = "SELECT * FROM DATA_INPUT WHERE nomination = 'Современная хореография' and group_age != '4-6 Little stars';";
	$sql_people_dance = "SELECT * FROM DATA_INPUT WHERE nomination = 'Народный танец' and group_age != '4-6 Little stars';";
	$sql_classic = "SELECT * FROM DATA_INPUT WHERE nomination = 'Классическая хореография' and group_age != '4-6 Little stars';";

	$result_little = $conn->query($sql_little_stars);	
	$result_street_show = $conn->query($sql_street_show);
	$result_show_girls = $conn->query($sql_show_girls);
	$result_modern = $conn->query($sql_modern);
	$result_people_dance = $conn->query($sql_people_dance);
	$result_classic = $conn->query($sql_classic);

	while ($row = $result_little->fetch_assoc()) {
		# code...
	}
	while ($row = $result_street_show->fetch_assoc()) {
		# code...
	}
	while ($row = $result_show_girls->fetch_assoc()) {
		# code...
	}
	while ($row = $result_modern->fetch_assoc()) {
		# code...
	}
	while ($row = $result_people_dance->fetch_assoc()) {
		# code...
	}
	while ($row = $result_classic->fetch_assoc()) {
		# code...
	}

// 	$result_28 = $conn->query($sql_28);
// 	$result_29 = $conn->query($sql_29);

// 	$counter = 0;
// 	$counter_day_2 = 2;
// 	//amount of rests
// 	$counter_rest_1 = $interval_day_1;
// 	$counter_rest_2 = $interval_day_2;

	

// 	echo "28 Марта::" .gmdate("H:i:s",$begining_time).":::";

// 	$file_data = array("28 March","","","","","","","","","",gmdate("H:i:s",$begining_time));
// 	array_push($global_data, $file_data);
// //	fputcsv($file_open, $file_data); 
// 	while($day_1 = $result_28->fetch_assoc()) {
// 		$counter_day_2 ++;
// 		$file_data = array(
// 						"=SUM(B".$counter_day_2.";"."Sum("."K".($counter_day_2-1).';"00:01:00")'.")",
// 						$day_1["id"],
// 						$day_1["duration"],
// 						$day_1["category"],
// 						$day_1["nomination"],
// 						$day_1["team_name"],
// 						$day_1["dance_style"],
// 						$day_1["fio"],
// 						$day_1["city"],
// 						$day_1["amount"],
// 						$day_1["file_name"],
// 	 	);
// 	 	array_push($global_data, $file_data);
// 	 	// fputcsv($file_open, $file_data); 
// 		echo $counter."::".$day_1["id"]."::".$day_1["duration"]."::".$day_1["category"]."::".$day_1["nomination"]."::".$day_1["team_name"]."::".$day_1["dance_style"]."::".$day_1["fio"]."::".$day_1["city"].$day_1["amount"]."::"."::".$day_1["file_name"]."=SUM(B".$counter_day_2.";"."Sum("."K".($counter_day_2-1).';"00:01:00")'."):::";
// 	}
// 	$counter_day_2++;
// 	$counter = 0;
// 	//day 2
// 	echo "29 Марта::" .gmdate("H:i:s",$begining_time).":::";
// 	$file_data = array("29 March","","","","","","","","","",gmdate("H:i:s",$begining_time));
// 	array_push($global_data, $file_data);
// 	// fputcsv($file_open, $file_data); 
// 	while($day_2 = $result_29->fetch_assoc()) {
// 		$counter_day_2 ++;
// 		$counter++;
// 		$file_data = array(
// 						$day_2["id"],
// 						$day_2["category"],
// 						$day_2["nomination"],
// 						$day_2["team_name"],
// 						$day_2["dance_style"],
// 						$day_2["fio"],
// 						$day_2["city"],
// 						$day_2["amount"],
// 						$day_2["file_name"],
// 						$day_2["duration"],
// 						"=SUM(B".$counter_day_2.";"."Sum("."K".($counter_day_2-1).';"00:01:00")'.")",
						
// 	 	);
// 	 	array_push($global_data, $file_data);
// 	 	// fputcsv($file_open, $file_data); 
		
// 		echo $counter."::".$day_2["id"]."::".$day_2["duration"]."::".$day_2["category"]."::".
// 		$day_2["nomination"]."::".$day_2["team_name"]."::".$day_2["dance_style"]."::".$day_2["fio"]."::".$day_2["city"]."::".$day_2["amount"]."::".$day_2["file_name"]."::=SUM(B".$counter_day_2.";"."Sum("."K".($counter_day_2-1).';"00:01:00")'."):::";
// 	}

	
// 	print_r($global_data);
// 	$file_open = fopen("autotiming_". date("h_i")."_". date("Y_m_d").".csv", 'w');
// 	foreach ($global_data as $row) {
// 		fputcsv($file_open, $row);
// 	}

// 	fclose($file_open);

	$to_email = 'bestdancefest@gmail.com';
	$subject = 'autotiming';
	$mail_file_name = "autotiming_". date("h_i")."_". date("Y_m_d").".csv";
	// // $to = "bestdancefest@gmail.com";
	// $to = "georg.rashkov@gmail.com";
	// $from = "s-thng@gmail.com";
	// $subject = "autotiming"; 
 //  	$message = "Автотайминг фестиваль";
 //  	$boundary = "---"; 
  	
 //  	$headers = "From: $from\nReply-To: $from\n";
 //  	$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
	// $body = "--$boundary\n";
	// $body .= "Content-type: text/html; charset='utf-8'\n";
	// $body .= "Content-Transfer-Encoding: quoted-printablenn";
	// $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($mail_filename)."?=\n\n";
	// $body .= $message."\n";
	// $body .= "--$boundary\n";
	// $filem = fopen("autotiming_". date("h_i")."_". date("Y_m_d").".csv", "r"); 
	// $text = fread($filem, filesize($mail_filename)); 
	// fclose($filem); 
	
	// $body .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode($mail_filename)."?=\n";
	// $body .= "Content-Transfer-Encoding: base64\n";
	// $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($mail_filename)."?=\n\n";
	// $body .= chunk_split(base64_encode($text))."\n";
	// $body .= "--".$boundary ."--\n";
	// mail($to, $subject, $body, $headers); //Отправляем письмо
	$message = '<p>http://bestdancefest.com.ua/'.$mail_file_name.'</p>';
	$headers = "Content-type: text/html; charset=utf-8\r\n";
	mail($to_email,$subject,$message,$headers);
 ?>