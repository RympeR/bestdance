<?php 

	$servername = "bestda01.mysql.tools";
	$username = "bestda01_db";
	$password = "LuyjNXUD";
	$dbname = "bestda01_db";
			
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error){
		die("Connection error: ");
	}
	if(!$conn->set_charset("utf8")){
			echo "ошибка кодировки";
		}
		if ($conn->connect_error){
			die("Connection error: ");
		}
	$flag = 0;
	try{

		$select_user_id = "SELECT user_id FROM TICKET_AMOUNT;";
		$res_select = $conn->query($select_user_id);

		while ($row = $res_select->fetch_assoc() ){
			$flag = ($row["user_id"] == $_POST["user_id"]) ? 1 : 0;
			if ($flag == 1){
				// echo "Билеты добавлены";
				break;	
			}
		}
	}
	catch (Exception $e){
		// echo "Вы еще не добавили ни 1й заявки";
	}
	// echo "::";
	// echo $flag;
	$max_form = "SELECT email, fio  FROM DATA_INPUT WHERE user_id=".$_POST["user_id"].";";
	$res_max = $conn->query($max_form);
	$row1 = $res_max->fetch_assoc(); 
		
	echo $row1["email"]."::".$row1["fio"];
	if ($flag == 0){	
		
		$insert_amount = "INSERT INTO TICKET_AMOUNT VALUES(NULL,".$_POST["user_id"].','.'"'.$row1["fio"].'"'.','.'"'. $row1["email"].'"'.','.$_POST["ticket_amount"].");";
		$res_max = $conn->query($insert_amount);

	}
	else {
		$insert_amount = "UPDATE TICKET_AMOUNT SET ".
		'fio='.'"'.$row["fio"].'"'.','. 
		'email='.'"'.$row["email"].'"'.','.
		'amount='.$_POST["ticket_amount"]." WHERE user_id=".$_POST["user_id"].';';
		$res_max = $conn->query($insert_amount);
	}
 ?>