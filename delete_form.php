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

			$select_user_id = "SELECT id,user_id FROM DATA_INPUT WHERE id =". $_POST["id"] .";";
			$res_select = $conn->query($select_user_id);
			$row = $res_select->fetch_assoc();

  			function rmdir_recursive($dir) {
 				foreach(scandir($dir) as $file) {
        			if ('.' === $file || '..' === $file) continue;
        			if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
        			else unlink("$dir/$file");
    			}
    			rmdir($dir);
			}

  			$uploaded_files = "wp-content/themes/bestdancefest.com.ua/upload_files/";
  			$upload_dir_photo = $uploaded_files . 'photo_payment/' . $row["user_id"] . '/' .$_POST["id"] . '/';
			$upload_dir_music = $uploaded_files . 'music/' . $row["user_id"] . '/' . $_POST["id"] . '/';

			$servername = "bestda01.mysql.tools";
			$username = "bestda01_db";
			$password = "LuyjNXUD";
			$dbname = "bestda01_db";
			echo $upload_dir_music."::".$upload_dir_photo;
			rmdir_recursive($upload_dir_music);
			rmdir_recursive($upload_dir_photo);

			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error){
				die("Connection error: ");
			}
			
		    
			$sql = "DELETE FROM DATA_INPUT WHERE id =" .$_POST["id"].";";
			if ($conn->query($sql) === TRUE) {
				 echo "record updated successfully";	
			}
			

			$conn->close();
 ?>