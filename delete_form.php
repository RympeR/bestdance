<?php 
			$servername = "bestda01.mysql.tools";
			$username = "bestda01_db";
			$password = "LuyjNXUD";
			$dbname = "bestda01_db";
			
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