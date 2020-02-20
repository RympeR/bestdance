	<?php
		function get_max_id_incr(){
			$servername = "bestda01.mysql.tools";
			$username = "bestda01_db";
			$password = "LuyjNXUD";
			$dbname = "bestda01_db";
			
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error){
				die("Connection error: ");
			}

			$max_form = "SELECT MAX(id) as value FROM DATA_INPUT;";
			$res_max = $conn->query($max_form);
			$row = $res_max->fetch_assoc(); 

			$url_addres = 'http://'.$_SERVER['HTTP_REFERER'].$_SERVER['REQUEST_URI'];

			if(preg_match("/num_form=[0-9]+/", $url_addres, $array)){
				$res=preg_match("/num_form=[0-9]+/", $url_addres, $array);
				return $form_num = substr($array[0], 9);
			}
			else
				return $row["value"]+1;
		}

		error_reporting(0);
		$user_id = $_POST["id_user"];
		try{
			mkdir('wp-content/themes/bestdancefest.com.ua/upload_files/photo_payment/'.get_max_id_incr().'/');
			mkdir('wp-content/themes/bestdancefest.com.ua/upload_files/music/'.get_max_id_incr().'/');
			$upload_dir_photo = 'wp-content/themes/bestdancefest.com.ua/upload_files/photo_payment/'.get_max_id_incr().'/';
			$upload_dir_music = 'wp-content/themes/bestdancefest.com.ua/upload_files/music/'.get_max_id_incr().'/';
			
		}
		catch (Exception $e){
			$upload_dir_photo = 'wp-content/themes/bestdancefest.com.ua/upload_files/photo_payment/'.get_max_id_incr().'/';
			$upload_dir_music = 'wp-content/themes/bestdancefest.com.ua/upload_files/music/'.get_max_id_incr().'/';
		}
		
		
		$photo = $_FILES['photo_name']['name'];
		$audio = $_FILES['file_name']['name'];
		if (isset($_FILES['photo_name']) || isset($_FILES['file_name'])){
			$errors = array();
			$photo = $_FILES['photo_name']['name'];
			$audio = $_FILES['file_name']['name'];
			$photo_size = $_FILES['photo_name']['size'];
			$audio_size = $_FILES['file_name']['size'];
			$photo_tmp = $_FILES['photo_name']['tmp_name'];
			$audio_tmp = $_FILES['file_name']['tmp_name'];

			$expension_photo = array('jpeg','png');
			$expension_photo = array('mp3','wav');

			if($photo_size > 50000000){
				$errors[] = "Фотография не больше 5мб.";
			}
			if($audio_size > 240000000){
				$errors[] = "Аудио не больше 24мб.";
			}

			if (empty($errors) == true){
				try{
					move_uploaded_file($photo_tmp,$upload_dir_photo.$photo);	
				}
				catch (Exception $e) {
					echo "photo trouble";
				}
				try{
					move_uploaded_file($audio_tmp,$upload_dir_music.$audio);
				}
				catch (Exception $e) {
					echo "video trouble";
				}
			}
			else{
				echo"$errors";
			}
		}
		else echo "error";

		
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


		$url_addres = 'http://'.$_SERVER['HTTP_REFERER'].$_SERVER['REQUEST_URI'];

		if(preg_match("/num_form=[0-9]+/", $url_addres, $array)){

			$res=preg_match("/num_form=[0-9]+/", $url_addres, $array);
			$form_num = substr($array[0], 9);
			$sql_input = "UPDATE DATA_INPUT SET user_id= $user_id,nomination=".'"'.
				$_POST["nomination"].'",'.
				"category=".'"'.$_POST["category"].'",'.
				"skill_level=".'"'.$_POST["skill_level"].'",'.
				"group_age=".'"'.$_POST["group_age"].'",'.
				"fio=".'"'.$_POST["fio"].'",'.
				"number=".'"'.$_POST["tel_number"].'",'.
				"email=".'"'.$_POST["email"].'",'.
				"facebook=".'"'.$_POST["facebook"].'",'.
				"city=".'"'.$_POST["city"].'",'.
				"number_name=".'"'.$_POST["number_name"].'",'.
				"team_name=".'"'.$_POST["team_name"].'",'.
				"duration=".'"00:'.$_POST["duration"].'",'.
				"amount=".$_POST["amount"].','.
				"max_age=".$_POST["max_age"].','.
				"min_age=".$_POST["min_age"].','.
				"photo_name=".'"'.$photo.'",'.
				"file_name=".'"'.$audio.'",'.
				"dance_style=".'"'.$_POST["dance_style"].'" WHERE'." id=$form_num;";

			

			if ($conn->query($sql_input) === TRUE) {
		    	// echo "record updated successfully";	
			}

			$to_email = 'bestdancefest@gmail.com';
			$subject = 'DanceForm';
			$message = "UPDATED: \n".
					'Номинация '. $_POST["nomination"] . "\n" .
					'Категория '. $_POST["category"] . "\n" . 
					'Уровень навыка '. $_POST["skill_level"] . "\n" .
					'Возраст группы '. $_POST["group_age"] . "\n" .
					'ФИО '. $_POST["fio"] . "\n" . 
					'Номер телефона '. $_POST["tel_number"] . "\n" .
					'Адрес электронной почты '. $_POST["email"] . "\n" .
					'facebook '. $_POST["facebook"] . "\n" .
					'Город '. $_POST["city"] ."\n" .
					'Номер телефона '. $_POST["number_name"] . "\n" .
					'Название команды '. $_POST["team_name"] . "\n" .
					'Длительность '. $_POST["duration"] ."\n" .
					'Колличество '. $_POST["amount"] . "\n" .
					'Максимальный возраст '. $_POST["max_age"] . "\n" .
					'Минимальный возраст '. $_POST["min_age"] . "\n" .
					'Путь к чеку с оплатой '. $photo . "\n" .
					'Путь/имя трека '. $audio . "\n" .
					'Стиль танца '. $_POST["dance_style"];
			
			$headers = $_POST["email"];
				
		}
		else{
			$sql_input = "INSERT INTO DATA_INPUT VALUES (NULL".
				", $user_id,".'"'.$_POST["nomination"].'"'.
				",".'"'.$_POST["category"].'"'.",".'"'.
				$_POST["skill_level"].'"'.",".'"'.$_POST['group_age'].'"'.",".'"'.$_POST['fio'].'"'.",".'"'.$_POST['tel_number'].'"'.",".'"'.
				$_POST['email'].'"'.",".'"'.$_POST['facebook'].'"'.",".'"'.$_POST['city'].'"'.",".'"'.$_POST['number_name'].'"'.",".'"'.
				$_POST['team_name'].'"'.",".'"00:'.$_POST['duration'].'"'.",".$_POST['amount'].",".$_POST['max_age'].",".
				$_POST['min_age'] .",".'"'."NULL" .'"'.",".'"'.$audio.'"'.",".'"'.$_POST['dance_style'].'"'.");";
			// echo $sql_input;
			if ($conn->query($sql_input) === TRUE) {
		    	// echo "New record created successfully";
			} 

			$to_email = 'bestdancefest@gmail.com';
			$subject = 'DanceForm';
			$message = 
					'Номинация '. $_POST["nomination"] . "\n" .
					'Категория '. $_POST["category"] . "\n" . 
					'Уровень навыка '. $_POST["skill_level"] . "\n" .
					'Возраст группы '. $_POST["group_age"] . "\n" .
					'ФИО '. $_POST["fio"] . "\n" . 
					'Номер телефона '. $_POST["tel_number"] . "\n" .
					'Адрес электронной почты '. $_POST["email"] . "\n" .
					'facebook '. $_POST["facebook"] . "\n" .
					'Город '. $_POST["city"] ."\n" .
					'Номер телефона '. $_POST["number_name"] . "\n" .
					'Название команды '. $_POST["team_name"] . "\n" .
					'Длительность '. $_POST["duration"] ."\n" .
					'Колличество '. $_POST["amount"] . "\n" .
					'Максимальный возраст '. $_POST["max_age"] . "\n" .
					'Минимальный возраст '. $_POST["min_age"] . "\n" .
					'Путь/имя трека '. $audio . "\n" .
					'Стиль танца '. $_POST["dance_style"];
		}	
			$headers = $_POST["email"];
			// echo $message;
			mail($to_email,$subject,$message,$headers);
		

		$conn->close();
	 ?> 