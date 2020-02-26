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
		$sql = "SELECT `AUTO_INCREMENT` AS increment
				FROM  INFORMATION_SCHEMA.TABLES
				WHERE TABLE_SCHEMA = 'bestda01_db'
				AND   TABLE_NAME   = 'DATA_INPUT';";

		$url_addres = 'http://'.$_SERVER['HTTP_REFERER'].$_SERVER['REQUEST_URI'];
		$res_max = $conn->query($sql);
		$row = $res_max->fetch_assoc(); 
		
		if(preg_match("/num_form=[0-9]+/", $url_addres, $array)){
			$res=preg_match("/num_form=[0-9]+/", $url_addres, $array);
			return $form_num = substr($array[0], 9);
		}
		else
			return $row["increment"];


	}

	// error_reporting(0);
	$user_id = $_POST["id_user"];
	$upload_dir_music;
	$upload_dir_photo;
	$uploaded_files = "wp-content/themes/bestdancefest.com.ua/upload_files/";
	$upload_dir_photo = $uploaded_files . 'photo_payment/' . $_POST["id_user"] . '/' . get_max_id_incr() . '/';
	$upload_dir_music = $uploaded_files . 'music/' . $_POST["id_user"] . '/' . get_max_id_incr() . '/';
	echo "$upload_dir_photo \n\r";

	try {
		if (!mkdir($uploaded_files . 'photo_payment')) {
			echo "step 1 - fail \n\r";
		}
		if (!mkdir($uploaded_files . 'music')) {
			echo "step 2 - fail \n\r";
		}
		if (!mkdir($uploaded_files . 'photo_payment/' . $_POST["id_user"])) {
			echo "step 3 - fail \n\r";
		}
		if (!mkdir($uploaded_files . 'music/' . $_POST["id_user"])) {
			echo "step 4 - fail \n\r";
		}
		if (!mkdir($upload_dir_photo)) {
			echo "step 5 - fail \n\r";
		}
		if (!mkdir($upload_dir_music)) {
			echo "step 6 - fail \n\r";
		}
	} catch (Exception $e) {
	}

	$photo = get_max_id_incr() . '_' . $_FILES['photo_name']['name'];
	$audio = get_max_id_incr() . '_' . $_FILES['file_name']['name'];
	if (isset($_FILES['photo_name']) || isset($_FILES['file_name'])) {

		$errors = array();

		$photo_size = $_FILES['photo_name']['size'];
		$audio_size = $_FILES['file_name']['size'];
		$photo_tmp = $_FILES['photo_name']['tmp_name'];
		$audio_tmp = $_FILES['file_name']['tmp_name'];

		if ($photo_size > 20000000) {
			$errors[] = "Фотография не больше 20мб.";
			echo "Cлишком большое фото";
		}
		if ($audio_size > 24000000) {
			$errors[] = "Аудио не больше 24мб.";
			echo "Cлишком большое аудио";
		}
		if (empty($errors) == true) {
			try {
				move_uploaded_file($photo_tmp, $upload_dir_photo . $photo);
				echo $photo_tmp . "\r\n";
				echo $upload_dir_photo . "\r\n";
				echo $photo . "\r\n";
			} catch (Exception $e) {
				echo "photo trouble";
			}
			try {
				move_uploaded_file($audio_tmp, $upload_dir_music . $audio);
				echo $audio_tmp . "\r\n";
				echo $upload_dir_music . "\r\n";
				echo $audio . "\r\n";
			} catch (Exception $e) {
				echo "аудио trouble";
			}
		} else {
			echo "$errors";
		}
	} else echo "error";


	$servername = "bestda01.mysql.tools";
	$username = "bestda01_db";
	$password = "LuyjNXUD";
	$dbname = "bestda01_db";


	$conn = new mysqli($servername, $username, $password, $dbname);

	if (!$conn->set_charset("utf8")) {
		echo "ошибка кодировки";
	}
	if ($conn->connect_error) {
		die("Connection error: ");
	}


	$url_addres = 'http://' . $_SERVER['HTTP_REFERER'] . $_SERVER['REQUEST_URI'];

	if (preg_match("/num_form=[0-9]+/", $url_addres, $array)) {

		$res = preg_match("/num_form=[0-9]+/", $url_addres, $array);
		$form_num = substr($array[0], 9);
		$sql_input = "UPDATE DATA_INPUT SET user_id= $user_id,nomination=" . '"' .
			$_POST["nomination"] . '",' .
			"category=" . '"' . $_POST["category"] . '",' .
			"skill_level=" . '"' . $_POST["skill_level"] . '",' .
			"group_age=" . '"' . $_POST["group_age"] . '",' .
			"fio=" . '"' . $_POST["fio"] . '",' .
			"number=" . '"' . $_POST["tel_number"] . '",' .
			"email=" . '"' . $_POST["email"] . '",' .
			"city=" . '"' . $_POST["city"] . '",' .
			"number_name=" . '"' . $_POST["number_name"] . '",' .
			"team_name=" . '"' . $_POST["team_name"] . '",' .
			"duration=" . '"00:' . $_POST["duration"] . '",' .
			"amount=" . $_POST["amount"] . ',' .
			"max_age=" . $_POST["max_age"] . ',' .
			"min_age=" . $_POST["min_age"] . ',' .
			"photo_name=" . '"' . $photo . '",' .
			"file_name=" . '"' . $audio . '",' .
			"dance_style=" . '"' . $_POST["dance_style"] . '" WHERE' . " id=$form_num;";


		echo $sql_input;
		if ($conn->query($sql_input) === TRUE) {
			echo "record updated successfully";
		}

		$to_email = 'bestdancefest@gmail.com';
		$subject = 'DanceForm';
		$message =
			'<p>Номинация ' . $_POST["nomination"] . "<br>" .
			'Категория ' . $_POST["category"] . "<br>" .
			'Уровень навыка ' . $_POST["skill_level"] . "<br>" .
			'Возраст группы ' . $_POST["group_age"] . "<br>" .
			'ФИО ' . $_POST["fio"] . "\n" .
			'Номер телефона ' . $_POST["tel_number"] . "<br>" .
			'Адрес электронной почты ' . $_POST["email"] . "<br>" .
			'Город ' . $_POST["city"] . "\n" .
			'Номер телефона ' . $_POST["number_name"] . "<br>" .
			'Название команды ' . $_POST["team_name"] . "<br>" .
			'Длительность ' . $_POST["duration"] . "<br>" .
			'Количество ' . $_POST["amount"] . "<br>" .
			'Максимальный возраст ' . $_POST["max_age"] . "<br>" .
			'Минимальный возраст ' . $_POST["min_age"] . "<br>" .
			'Путь к чеку с оплатой ' . '<a href="http://bestdancefest.com.ua/' . $upload_dir_photo . $photo . '"><img width="400" src="http://bestdancefest.com.ua/' . $upload_dir_photo . $photo . '"></a>' . '<br>' .
			'Путь/имя трека ' . 'http://bestdancefest.com.ua/' . $upload_dir_music . $audio . " <br>" .
			'Стиль танца ' . $_POST["dance_style"] . "</p>";

		$headers = "Content-type: text/html; charset=utf-8\r\n";
	} else {
		$sql_input = "INSERT INTO DATA_INPUT VALUES (NULL" .
			", $user_id," . '"' . $_POST["nomination"] . '"' .
			"," . '"' . $_POST["category"] . '"' . "," . '"' .
			$_POST["skill_level"] . '"' . "," . '"' . $_POST['group_age'] . '"' . "," . '"' . $_POST['fio'] . '"' . "," . '"' . $_POST['tel_number'] . '"' . "," . '"' .
			$_POST['email'] . '"' . "," . '"' . $_POST['city'] . '"' . "," . '"' . $_POST['number_name'] . '"' . "," . '"' .
			$_POST['team_name'] . '"' . "," . '"00:' . $_POST['duration'] . '"' . "," . $_POST['amount'] . "," . $_POST['max_age'] . "," .
			$_POST['min_age'] . "," . '"' . $photo . '"' . "," . '"' . $audio . '"' . "," . '"' . $_POST['dance_style'] . '"' . ");";
		echo $sql_input;
		if ($conn->query($sql_input) === TRUE) {
			echo "New record created successfully";
		}

		$to_email = 'bestdancefest@gmail.com';
		$subject = 'DanceForm';
		$message =
			'<p>Номинация ' . $_POST["nomination"] . "<br>" .	
			'Категория ' . $_POST["category"] . "<br>" .
			'Уровень навыка ' . $_POST["skill_level"] . "<br>" .
			'Возраст группы ' . $_POST["group_age"] . "<br>" .
			'ФИО ' . $_POST["fio"] . "\n" .
			'Номер телефона ' . $_POST["tel_number"] . "<br>" .
			'Адрес электронной почты ' . $_POST["email"] . "<br>" .
			'Город ' . $_POST["city"] . "\n" .
			'Номер телефона ' . $_POST["number_name"] . "<br>" .
			'Название команды ' . $_POST["team_name"] . "<br>" .
			'Длительность ' . $_POST["duration"] . "<br>" .
			'Количество ' . $_POST["amount"] . "<br>" .
			'Максимальный возраст ' . $_POST["max_age"] . "<br>" .
			'Минимальный возраст ' . $_POST["min_age"] . "<br>" .
			'Путь к чеку с оплатой ' . '<a href="http://bestdancefest.com.ua/' . $upload_dir_photo . $photo . '"><img width="400" src="http://bestdancefest.com.ua/' . $upload_dir_photo . $photo . '"></a>' . '<br>' .
			'Путь/имя трека ' . 'http://bestdancefest.com.ua/' . $upload_dir_music . $audio . " <br>" .
			'Стиль танца ' . $_POST["dance_style"] . "</p>";
	}

	// echo $message;

	$headers = "Content-type: text/html; charset=utf-8\r\n";

	mail($to_email, $subject, $message, $headers);


	$conn->close();
	?> 