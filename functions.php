<?php
error_reporting(0);
require_once('wp-bootstrap-navwalker.php');
register_nav_menus( array(
  'primary' => __( 'Primary Menu', 'Menu' ),
) );
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );




//Define the key to store in the database
define( 'CF7_COUNTER', 'cf7-counter' );
 
//Create the shortcode which will set the value for the DTX field
function cf7dtx_counter(){
    $val = get_option( CF7_COUNTER, 0) + 1;  //Increment the current count
    return $val;
}
add_shortcode('CF7_counter', 'cf7dtx_counter');
 
//Action performed when the mail is actually sent by CF7
function cf7dtx_increment_mail_counter(){
    $val = get_option( CF7_COUNTER, 0) + 1; //Increment the current count
    update_option(CF7_COUNTER, $val); //Update the settings with the new count
}
add_action('wpcf7_mail_sent', 'cf7dtx_increment_mail_counter');

/**
 * Enqueue scripts and styles.
 */
function bestdancefest_theme_scripts() {
	wp_enqueue_script( 'jquery-js', get_template_directory_uri() . '/libs/JQ_1-9-1/jquery.min.js');
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/libs/bootstrap/js/bootstrap.min.js');
	wp_enqueue_script( 'pageScroll2id-js', get_template_directory_uri() . '/libs/PageScroll2id/PageScroll2id.min.js');
	wp_enqueue_script( 'site-functions', get_template_directory_uri() . '/js/common.js');
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bestdancefest_theme_scripts' );

add_filter('manage_edit-wpcf7s_columns', 'my_columns', 4);
function my_columns($columns) {
	$num = 2;
   $new_columns = array(
		'post_id' => 'Post ID',
	);

	return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
}
// заполняем колонку данными
add_action( 'manage_wpcf7s_posts_custom_column', 'my_manage_wpcf7s_columns', 10, 2 );

function my_manage_wpcf7s_columns( $colname, $post_id ){
	if( $colname === 'post_id' ){ 
		echo $post_id; 
	}
}


function custom_shortcode() {
	 return get_current_user_id();
}
add_shortcode( 'get-login', 'custom_shortcode' );

	
function generate_links(){
	$user_id = get_current_user_id();
	$user_info = get_userdata(get_current_user_id());

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


	$sql = "SELECT id,user_id,number_name FROM DATA_INPUT
				WHERE user_id =  $user_id";

	$result = $conn->query($sql);

	echo '<div id="lk-content" class="rcl-content"><div id="tab-zakazy_25" class="zakazy_25_block recall_content_block active"><div id="subtab-subtab-1" class="rcl-subtab-content">';
	echo '<h1 style="margin: 35px 0 0 10px;font-size: 26pt;color: #fafafa;text-align: center;">Ваши заявки</h1>';
	if (custom_shortcode() == "1"){
		echo "<br><p><a class='user-order-link' style='color:#000;' href='http://www.bestdancefest.com.ua/form_timing'>Сформировать тайминг</a><br></p>";
	}

	while($row = $result->fetch_assoc()) {

		//echo "num form:".$row["id"]."<br>";
		echo "<a class='user-order-link' style='color:#000;filter: drop-shadow(2px 2px 2px #222);-webkit-filter: drop-shadow(2px 2px 2px #222);' href='http://www.bestdancefest.com.ua/form?num_form=".$row["id"]."'/>".$row["number_name"].'</a>';
		echo "<br>";
	}

	echo '<a class="user-order-link" href="http://www.bestdancefest.com.ua/wp-login.php?action=logout&amp;redirect_to=http%3A%2F%2Fwww.bestdancefest.com.ua&amp;_wpnonce=cd7dd09db6" class="recall-button "><i class="rcli fa-external-link"></i><span>Выход</span></a>';
	// echo "<button onclick=[logout]>Выйти</button>";
	echo "</div></div></div>";
	//echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

}
add_shortcode('gen_links','generate_links');

function get_tickets_amount(){
	$user_id = get_current_user_id();
	$user_info = get_userdata(get_current_user_id());

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


	$sql = "SELECT amount FROM TICKET_AMOUNT
				WHERE user_id =  $user_id";
	try{
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();

		return $row["amount"];	
	}
	catch (Exception $e)
	{
		return 0;
	}
	
}
add_shortcode('get_amount','get_tickets_amount');

function get_max_id(){
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

add_shortcode('get_max_id_incr','get_max_id');
	
function get_audio_name(){
	return $_FILES["file_name"]["name"];
}

add_shortcode('get_audio','get_audio_name');

function login_out(){
	wp_loginout("/");
}

add_shortcode('logout','login_out');
?>

