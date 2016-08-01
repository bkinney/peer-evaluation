<?php


session_start();
include "/www/canvas/canvasapi.php";
//print_r($_SESSION);
$api= new CanvasAPI($_SESSION['token_arr']['domain'],$_SESSION['_basic_lti_context']['custom_canvas_api_domain'],$_SESSION['_basic_lti_context']['custom_canvas_user_id']);
$uri="/api/v1/courses/" . $_GET['courseid'] . "/users?enrollment_type=student&include[]=email";
if($api->ready){
	//echo "ready";
	//echo $uri;
}else{
	echo $api->error;
	
}


$roster = $api->get_canvas($uri,true);
$d = " | ";
foreach($roster as $member){
	if(empty($member['sis_user_id']))continue;
	echo "<li>" . $member['sortable_name'] . $d
	. $member['sis_user_id'] . $d
	. strtolower($member['email']) . "</li>";
}

?>