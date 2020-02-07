	<?php
		$url_addres = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		
			$servername = "bestda01.mysql.tools";
			$username = "bestda01_db";
			$password = "LuyjNXUD";
			$dbname = "bestda01_db";

			$form_num = $_POST['id'];
			$conn = new mysqli($servername, $username, $password, $dbname);
			if(!$conn->set_charset("utf8")){
		 		echo "ошибка кодировки";
		 	}
		 	if ($conn->connect_error){
		 		die("Connection error: ");
		 	}
			if ($conn->connect_error) {
        		die("Connection failed: " . $conn->connect_error);
    		} 
			$sql = "SELECT * FROM DATA_INPUT WHERE id=$form_num";
			$result = $conn->query($sql);
			
			while($row = $result->fetch_assoc()) {
	            $nomination = $row["nomination"];
	            $category = $row["category"];
	            $skill_level = $row["skill_level"];
	            $group_age = $row["group_age"];
	            $fio = $row["fio"];
	            $number = $row["number"];
	            $email = $row["email"];
	            $facebook = $row["facebook"];
	            $city = $row["city"];
	            $number_name = $row["number_name"];
	            $team_name = $row["team_name"];
	            $duration = $row["duration"];
	            $amount = $row["amount"];
	            $max_age = $row["max_age"];
	            $min_age = $row["min_age"];
	            $photo_name = $row["photo_name"];
	            $file_name = $row["file_name"];
	            $dance_style = $row["dance_style"];

	            echo "".$nomination."::".$category."::".$skill_level."::".$group_age.
	            "::".$fio."::".$number."::".$email."::".$facebook."::".$city.
	            "::".$number_name."::".$team_name."::".$duration."::".$amount.
	            "::".$max_age."::".$min_age."::".$photo_name."::".$file_name.
	            "::".$dance_style;
	        }
	        $conn->close();
    	
        
?>
