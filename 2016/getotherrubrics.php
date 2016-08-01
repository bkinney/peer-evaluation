<html><head/><body>

<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 1);
//harvest rubrics from db
session_start();
$info = $_SESSION['_basic_lti_context'];

	$emplid = $info['lis_person_sourcedid'];
	$facid = $emplid . "9";

	
include "/www/canvas/canvasapi.php";
include "/home/bkinney/includes/db_peer_sqli.php";//?;
//print_r($_SESSION);
if(array_key_exists("surveyid",$_REQUEST)){//just grab the one field for the one course

	$query = sprintf("select %s from survey where surveyid= '%s'",
mysqli_real_escape_string($link,$_GET['field']),
mysqli_real_escape_string($link,$_GET['surveyid'])
);
	$result = mysqli_query($link,$query);
	if($result){
		$row = mysqli_fetch_array($result);
		print_r($row);
		$rubric = $row[$_GET['field']];
		echo $rubric;
		return;
	}else{
		die("no result");
	}
exit();
}else{
	
	echo "no key";
}
echo "<h3>Other Rubrics</h3><p>Select a project from the database. Only standalone projects and projects associated with a published Canvas course will appear here.</p>";
/*if(!$api){
	$api= new CanvasAPI($_SESSION['token_arr']['domain'],$_SESSION['_basic_lti_context']['custom_canvas_api_domain'],$_SESSION['_basic_lti_context']['custom_canvas_user_id']);
	}*/
	
	$uri = '/api/v1/users/' . $info['custom_canvas_user_id'] . '/courses';
	echo $uri;
	$mycourses = $api->get_canvas($uri,true);//only gets active courses :(
	$query = "select name,surveyid from survey where instructorID ='" . $facid . "'";
	foreach($mycourses as $course){
		$query .= " or instructorID='can" . $course['id'] . "'";
	}
	echo $query;
	
	$result = mysqli_query($link,$query);
	if($result){
		echo '<form onsubmit="loadOtherRubric()"><select id="surveyselect">';
		while ($row = mysqli_fetch_assoc($result)) {
			echo '<option value="'.$row['surveyid'].'" >' . $row['name'] . '</option>';
		}
		echo '</select><input type="submit" value="Import Rubric">';
	}

?>

<script>

function loadOtherRubric(){
	
	var id=document.getElementById("surveyselect").value;
	var currentEditor =$("div[id*=custominstructions]:visible");
   var field = currentEditor == $("div[id=custominstructions]") ? "instructions" : "instructions_p";
	
	currentEditor.load("<?php echo $_SESSION['peerhtml']?>getotherrubrics.php","surveyid="+id.value + "&field="+field);
}

</script>
</body>