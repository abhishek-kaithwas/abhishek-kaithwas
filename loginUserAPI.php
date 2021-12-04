<?php

// include connection file
require('conn.php');

// catching json string from Android App
$inputJSON = file_get_contents('php://input');
$obj = json_decode($inputJSON);

// set json string to php variables
$p_userMobile = $obj->{"userMobile"};
$p_userPass = $obj->{"userPass"};


// check request variable is not empty
if(($p_userMobile != "") && ($p_userPass != "")){

	$login_session_id = uniqid();

	$msg = "";

	$sql_check_valid_user = mysqli_query($conn, "SELECT `id` FROM `user_signup_tbl` WHERE `user_mobile` = '$p_userMobile' and `user_pass` = '$p_userPass'");
	if(mysqli_num_rows($sql_check_valid_user) > 0){
		$msg = 'success';

		// $response->r_userId = $p_userMobile;
		$response->r_msg = $msg;
		$response->r_login_session_id = $login_session_id;
	}else{ 
		$msg = 'failed';

		// $response->r_userId = "";
		$response->r_msg = $msg;
		$response->r_login_session_id = "";
	}


	
	// set header as json for response
	header("Content-type: application/json");

	//sending json response
	echo json_encode($response);
	

	

}
else{
	// $response->r_userId = "";
	$response->r_msg = 'empty';
	$response->r_login_session_id = "NA";

	header("Content-type: application/json");

	//sending json response
	echo json_encode($response);
}
?>