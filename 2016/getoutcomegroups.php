
<?php

//$secret = array("table"=>"key_token_view","key_column"=>"oauth_consumer_key","secret_column"=>"secret","context_column"=>"context_id");
session_start();
if(!$api){
	
include "/www/canvas/canvasapi.php";
//print_r($_SESSION);
$api= new CanvasAPI($_SESSION['token_arr']['domain'],$_SESSION['_basic_lti_context']['custom_canvas_api_domain'],$_SESSION['_basic_lti_context']['custom_canvas_user_id']);
}

	//$host = "https://udel.instructure.com";

if($_GET['courseid']){
	echo '<h3>Outcome Groups</h3>';
	$step=0;
	$uri="/api/v1/courses/" . $_GET['courseid'] . "/root_outcome_group?";
	//$uri = "/api/v1/accounts/101695/outcome_groups/170719";


	$roster = $api->get_canvas($uri,false);
	$foundsome=false;

//show groups as links
	if(count($roster)){
		
		$outcomes = $api->get_canvas($roster['subgroups_url']) ;
		if(count($outcomes))$foundsome=true;
		foreach($outcomes as $grp){
		//echo '<p><a href="' . $host . $grp['outcomes_url'] . '">' . $grp['title'] . '</a></p>';
		echo '<p><a href="#" onclick="loadCategory(' . $grp['id']. ' )">' . $grp['title'] . '</a></p>';
		}
	}
	if(!$foundsome){
		echo "No rubrics found";
		//echo $host . $roster['outcomes_uri'];
	}
	//end if count

}else if($_GET['catid']){
	$uri = '/api/v1/courses/'. $_GET['cid'].'/outcome_groups/'.$_GET['catid'];
	$desc = $api->get_canvas($uri,false);
	echo '<div class="custom" >
<p contenteditable="false" class="general instructions">Place your cursor in the instruction text below to edit it. To edit rubric categories, click the associated pencil icon.</p>';
	echo str_replace('href="','target="helper" href="',$desc['description']);
	$uri .= '/outcomes';
	$categories = $api->get_canvas($uri,false);
	
	foreach($categories as $cat){
		$points = $api->get_canvas("/api/v1/outcomes/" . $cat['outcome']['id'],false);
		$desc = $cat['outcome']['title'];
		$pt = $points['points_possible'];
		
		echo  '<p contenteditable="false">
    <a class="pencil"></a><input type="number" max="' . $pt . '" required>
    (' . $pt . '): ' . $desc . ' </p>';
	}
	echo '</div>';
}

?>
 
<script>
/**
convert a Canvas rubric for use in project, and push into appropriate editor
**/
function loadCategory(cat){
	currentEditor =$("div[id*=custominstructions]:visible");
var cid = <?php echo $_GET['courseid']; ?>;	
currentEditor.text(url);
	var url = "<?php echo $_SESSION['peerhtml']?>getoutcomegroups.php?catid=" + cat + "&cid=" + cid;
	

	currentEditor.load("<?php echo $_SESSION['peerhtml']?>getoutcomegroups.php", "catid=" + cat + "&cid=" + cid);
}
/**
grab rubric from database. Used primarily as a way to reuse rubrics created in a standalone project from within Canvas. Note that projects from inactive Canvas courses will not show up, since the API won't list them for me, so I can't get the instructorID ('can'+courseid).
**/
function loadOtherRubric(id){
	
	//var id=$("#surveyselect").value;
	var currentEditor =$("div[id*=custominstructions]:visible");
   var field = currentEditor == $("div[id=custominstructions]") ? "instructions" : "instructions_p";
	
	currentEditor.load("<?php echo $_SESSION['peerhtml']?>getotherrubrics2.php","surveyid="+id.value + "&field="+field);
}


</script>


<?php include $_SESSION['peerphp'] . "getasstrubrics.php" ?>