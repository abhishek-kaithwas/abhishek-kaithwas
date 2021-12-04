<?php

// include connection file
include "conn.php";

// catching json string from Android App
$inputJSON = file_get_contents('php://input');
$obj = json_decode($inputJSON);

$_userName =        trim($obj->{'userName'});
$_userEmail =       trim($obj->{'userEmail'});
$_userMobile =      trim($obj->{'userMobile'});
$_userGender =      trim($obj->{'userGender'});
$_userPass =        trim($obj->{'userPass'});

// imagewill be in base64 formate
$_userProfileImg =  trim($obj->{'userProfileImg'});

$_msg = "";
// $_imgName = "";

// check request variable is not empty
if(($_userName != "") &&($_userEmail != "")){
    
    $query_select_user = mysqli_query($conn, "SELECT `id` FROM `user_signup_tbl` WHERE `user_mobile` = '$_userMobile'");
    if(mysqli_num_rows($query_select_user) > 0){
        // $_msg = "mobile number already exist";
        $response->r_msg = "mobile number already exist";
    }
    else{
        // saving base64 image into server folder
        $_imgName = 'user'.$_userMobile.".jpg";
        $_imgPath = './byteImages/';

        if (!file_exists($_imgPath)) {
            mkdir($_imgPath, 0777, true);
            file_put_contents($_imgPath.$_imgName, base64_decode($_userProfileImg));
        }
        else{
            mkdir($_imgPath, 0777, true);
            file_put_contents($_imgPath.$_imgName, base64_decode($_userProfileImg));
        }

        $sql_insert_signup_details = mysqli_query($conn, "INSERT INTO `user_signup_tbl`(`user_name`, `user_email`, `user_mobile`, `user_gender`, `user_pass`, `user_profile_img`) 
        VALUES ('$_userName','$_userEmail','$_userMobile','$_userGender','$_userPass','$_imgName')");

        if($sql_insert_signup_details){
            $_msg = "success";
            $response->r_msg = $msg;
        }
        else{
            $_msg = "failed";
            $response->r_msg = $_msg;
        }

    }

    // set header as json for response
	header("Content-type: application/json");

	//sending json response
	echo json_encode($response);
}
else{
	$response->r_msg = 'empty';
	header("Content-type: application/json");

	//sending json response
	echo json_encode($response);
}
?>