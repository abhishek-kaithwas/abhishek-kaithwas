<?php

// include connection file
require('../include/conn.php');

// catching json string from Android App
$inputJSON = file_get_contents('php://input');
$obj = json_decode($inputJSON);

// set json string to php variables
$p_userId = $obj->{"userId"};
$p_loginSessionId = $obj->{"loginSessionId"};
$p_executionDate = $obj->{"executionDate"};
$p_siteState = $obj->{"siteState"};
$p_siteDistrict = $obj->{"siteDistrict"};
$p_siteVillageName = $obj->{"siteVillageName"};
$p_siteLandMark = $obj->{"siteLandMark"};
$p_siteDesign = $obj->{"siteDesign"};
$p_siteWall_si_no = $obj->{"wall_si_no"};
$p_siteSize = $obj->{"size"};
$p_siteSq_feet = $obj->{"sq_feet"};
$p_siteLat_long = $obj->{"lat_long"};
$p_siteNear_view_img = $obj->{"near_view_img"};
$p_siteRoad_view_img = $obj->{"road_view_img"};


	


// check request variable is not empty
if(($p_userId != "") && ($p_loginSessionId) != ""){

	// saving base64 near view image
	$nearViewImg = 'nearView'.$p_loginSessionId.'.png';
	$nearViewPath = "../images/site-images/near-view/";
	$nearViewImgPath = "../images/site-images/near-view/".$nearViewImg;
	if (!file_exists($nearViewPath)) {
	    mkdir($nearViewPath, 0777, true);
		file_put_contents($nearViewImgPath, base64_decode($p_siteNear_view_img));
	}
	else{
		file_put_contents($nearViewImgPath, base64_decode($p_siteNear_view_img));
	}

	// saving base64 road view image
	$roadViewImg = 'roadView'.$p_loginSessionId.'.png';
	$roadViewPath = "../images/site-images/road-view/";
	$roadViewImgPath = "../images/site-images/road-view/".$roadViewImg;
	if (!file_exists($roadViewPath)) {
	    mkdir($roadViewPath, 0777, true);
		file_put_contents($roadViewImgPath, base64_decode($p_siteRoad_view_img));
	}
	else{
		file_put_contents($roadViewImgPath, base64_decode($p_siteRoad_view_img));
	}
	$msg = "";

	$sql_insert_site1_data = mysqli_query($conn, "INSERT INTO `site_data_tbl`(`user_id`, `session_id`, `execution_date`, `state`, `district`, `village_name`, `land_mark`, `design`, `wall_si_no`, `size`, `sq_feet`, `lat_long`, `near_view_img`, `road_view_img`) VALUES 
		(
			'$p_userId',
			'$p_loginSessionId',
			'$p_executionDate',
			'$p_siteState',
			'$p_siteDistrict',
			'$p_siteVillageName',
			'$p_siteLandMark',
			'$p_siteDesign',
			'$p_siteWall_si_no',
			'$p_siteSize',
			'$p_siteSq_feet',
			'$p_siteLat_long',
			'$nearViewImgPath',
			'$roadViewImgPath'
		)");

	if($sql_insert_site1_data){
		$msg = 'success';

		$response->r_userId = $p_userId;
		$response->r_msg = $msg;
		$response->r_login_session_id = $login_session_id;
	}else{
		$msg = 'failed';

		$response->r_userId = "";
		$response->r_msg = $msg;
		$response->r_login_session_id = "";
	}


	// set header as json for response
	header("Content-type: application/json");

	//sending json response
	echo json_encode($response);

}
else{

	$response->r_msg = 'empty';
	$response->r_login_session_id = "NA";

	header("Content-type: application/json");

	//sending json response
	echo json_encode($response);
}
?>