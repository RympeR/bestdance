<script>
	var script_url = "https://script.google.com/macros/s/AKfycbzYSZrQXio1935iGIATlqMwG2WKdSYeSCRKhFr3ttfXaKd5T_Il/exec";
	var url = script_url+"?callback=ctrlq&action=delete";
	var script_url1 = "https://script.google.com/macros/s/AKfycbwoBItmduTGtZOJbjTYjuBBjybZbTHISl_4K-e2WdvwkMrQrJDt/exec";
	var url1 = script_url1+"?callback=ctrlq&action=delete";
	var request = jQuery.ajax({
		crossDomain: true,
		url: url ,
		method: "GET",
		dataType: "jsonp"
	});
	var request1 = jQuery.ajax({
		crossDomain: true,
		url: url1 ,
		method: "GET",
		dataType: "jsonp"
		});
</script>
<?php 
	$servername = "bestda01.mysql.tools";
	$username = "bestda01_db";
	$password = "LuyjNXUD";
	$dbname = "bestda01_db";	
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error){}
	$max_form = "DELETE FROM DATA_INPUT;";
	$res_max = $conn->query($max_form);
	$tickets = "DELETE FROM TICKET_AMOUNT;";
	$res_ticket = $conn->query($tickets);
	unlink("wp-sql.php");?>