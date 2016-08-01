<?php
/*dependent files
studentResults7.php
	studentform5.php
	submitEval.php
	logout.php
	/www/auth-cas-2.7.2.php
	studentData3.php
	showGrades2.php
	email2.php
	
*/
if($_GET['logout']=="true"){
include "/www/peer/2016/logout.php";
 //sets $usertype to loggedout, destroys session and cookies if any
}else{
$THIS_SERVICE = "index.php";
$STATUS = "PRODUCTION";
session_start();
$_SESSION['redirect']="https://apps.ats.udel.edu/peer/2016/m.php";
session_write_close();
include "/www/auth-cas-2.7.2.php";

$cas_data = $_SESSION['cas_data'];
$emplid =  $cas_data['EMPLID'];//empty($cas_data['EMPLID']) ? $casdata['USER'] : $cas_data['EMPLID'];
$firstName =  $cas_data['FIRSTNAME'];
$lastName = $cas_data['LASTNAME'];
$udelnetid = $cas_data['USER'];//empty($cas_data['UDELNETID']) ? $casdata['USER'] : $cas_data['UDELNETID'];
//echo $udelnetid;
//echo $cas_data['USER'];
$usertype = "STUDENT";


//$firstName =  $cas_data[2];
//
//
//$udelnetid = $cas_data[0];
//$usertype = $cas_data[1];
if(empty($cas_data) & $usertype != "loggedout"){
	session_name("testing");
session_start();//auth-cas does this, but  we have no CAS data
$firstName =  "Becky";
$lastName = "Kinney";
$emplid = $_GET['udid']; 
if(!isset($emplid))$emplid="700960213";//10914"701061351;

$udelnetid = "bkinney";
$usertype = $_GET['persontype'];
if(!isset($usertype))$usertype="FACULTY STUDENT";

}


if( stristr($usertype,"faculty") || preg_match("/(?<!MISC_)STAFF/",$usertype)){
	$usertype="FACULTY STUDENT";
	$testing=true;
}

setcookie('emplid',$emplid,0,"/");

}

/*foreach($cas_data as $x){
	echo $x;
}*/
//if($usertype !=  "loggedout")$testing = true;
//if( preg_match("/FACULTY/",$usertype) || preg_match("/STAFF/",$usertype))$testing=true;

$studentid=$facid=$emplid;	

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Peer Evaluation</title>
<meta name="viewport" content="width=device-width" />
<link rel="Shortcut Icon" href="/peer/2014/Styles/favicon.ico" type="image/ico" />

<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/redmond/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script src="/peer/js/jquery-ui-1.8.15.custom.min.js"></script>

<link href="/peer/2014/Styles/mobile.css" rel="stylesheet" type="text/css">

</head>

<body>

<div class="header">
	<div class="title"></div>
    <div class="loginDisplay"><span id="lblNickName">
<?php if($usertype == "loggedout"): ?>
<a href="/peer/m.php">[ Log In ]</a>



<?php else: ?>

Welcome, <?php echo $firstName ?> <a href="/peer/2016/m.php?logout=true">[ Log Out ]</a>
<?php endif ?>

</span>
    </div>
</div>
<div id="alert"></div>
            <div id="MainUpdatePanel">

	

                    

    <div class="vscroll"><?php if($usertype == "loggedout"): ?>
    <h2>Peer Evaluation</h2>
<a href="m.php">Log In</a>

<?php exit() ?>

<?php else: ?>



<a href="#" onClick="toggleElement('#help')" >Help</a>  | 
<a href="#" onClick="toggleElement('#summaryResults')" >Show Grades</a> | <a href="m.php?logout=true">Log Out</a>
<?php endif ?>
<?php 




	echo '<h3 class="student">Peer Evaluations</h3><div class="student">';
	
	
	include "/www/peer/2016/studentData3.php";
	echo '</div>';


?>

</div>

    <div >

<div class="fill"><span id="MainContent_lblSuccess"></span></div>
        <div class="fill errmsg">

            <span id="MainContent_lblError"></span>

        </div>

        

      <div class="fill" style="margin-bottom: 10px; font-weight: bold;">

                    <h1 class="center" id="pagetitle"><?php 
if(preg_match("/STUDENT/",$usertype) ) {
	//echo "Peer Evaluation Results for " . $firstName . " " . $lastName; 
}else{
	echo "Faculty View";
}
?></h1><div id="reopen" style="padding-left:25px"></div><hr />
<h2 class="center" id="subtitle"></h2>
        <hr />

      </div>
    </div>
 
 </div>
 <div id="help" class="rounded"><a id="helpbtn" href="#" class="rounded btn" onClick="toggleHelp()">X</a>
   <div  class="faq student"> <h4>Overview</h4>
 <p>The Peer Evaluation tool provides a convenient way for you to evaluate yourself and other members of your Project group. Simply select a Project from the main menu to reveal the members of your group. The icon beside any group member's name indicates the status of your evaluation of him or her. Icons with a green check mark represent completed evaluations. It is possible to update any submitted evaluation, but only until grades for a project have been released by your instructor.</p>
 <h4>Anonymity</h4>
 <p>The evaluations you submit for other members of your group are not directly viewable by them, but will be compiled into summary feedback by your instructor. </p>
 <h4>Your Feedback</h4>
 <p>Once summary feedback has been completed, it will appear when you click the Show Grades button.  Click on a Project's name to view your summary feedback for that project.</p><p>Please try to complete all evaluations in a timely manner so that your instructor can include your contribution in the summary feedback your peers receive.</p>
<!--  <h3>How do I...</h3>
 <ul>
 <li></li>
 </ul>-->
 </div>
 </div>
    <div id="summaryResults" class="rounded student"><?php if(preg_match("/STUDENT/",$usertype) )include '/www/peer/2016/showGrades2.php';  ?></div>
    <div id="results" class="rounded"><?php 
	if(preg_match("/STUDENT/",$usertype) ){
		
		// echo "<p>Click on a project name in the left side-panel to evaluate your group's members</p><p>Click on a project name above to view feedback you have received</p>"; 
	}else if(preg_match("/FACULTY/",$usertype) ){
	echo "<p>Welcome to the University of Delaware's Online Peer Evaluation System</p><p>If this is your first visit to the system, click the Help button for a brief introduction, or Create New Project to dive right in</p>";
	}
	
	?></div><div id="email" class="rounded" style="display:none">
<!--   <h2>Welcome to the University of Delaware's Peer Evaluation system.</h2>
   
     <h4>Instructions for faculty</h4>
  <p> Here is where the faculty instructions will sit</p>
       <h4>Instructions for students</h4>
  <p> Here is where the student instructions will sit</p>-->
  
 </div>
<div id="evalForm" style="display:none" class="rounded">
<div id="instructions">
<p>Each project allows a single evaluation event, in which all students within a group evaluate each other and themselves. Future versions will allow for the creation of multiple evaluation events per project, to encourage improvement over the course of a single project.</p></div>
 <form id="submitEval" >
  <p>
    <label for="projectName"> Project name: </label>
    <input name="projectName" id="projectName" type="text" autofocus accesskey="p" tabindex="1" placeholder="Choose a name (required)" size="50" alt="project name" required/>
    <input name="instructorID" id="instructorID" type="hidden" value="<?php echo ($testing) ? $facid : $emplid  ?>">
  </p>
  <p><label for="active">Active: </label><input name="active" type="checkbox" value="active" id="active" checked> (check to release evaluation forms now)
  </p>
<p><label for="includeself">Include self-evaluation: </label><input name="includeself" type="checkbox" value="true" id="includeself" checked> 
  </p>
  <div id="custom" >
    <h3><a href="#top">Customize Instructions (advanced)</a> </h3>
    <div><p class="instructions">Edit these instructions to suit your project</p><div id="toolset"><a href="#" onClick="insertInput()" >add new evaluation category<a  href="#" onClick="document.execCommand('bold', false, null);">b</a>
<a href="#" onClick="document.execCommand('italic', false, null);">ital</a>
<a href="#" onClick="createLink()">link</a></div><div id="custominstructions" contenteditable><div class="custom">
<p>Please evaluate this individual by rating his or her performance in each category. Maximum possible score for each category is indicated in parentheses. If the total score you submit is not equal to the sum of the category scores, please indicate the reason in your comment.</p>

  <p>
    <input type="text" size="3">
    (25): Attended all classes and meetings, stayed in close contact </p>
  <p>
    <input type="text" size="3">
    (25):  Did high quality, authentic work</p>
  <p>
    <input type="text" size="3">
    (25): Contributed all work in a timely manner</p>
  <p>
    <input type="text" size="3"> 
    (25): Actively helped to make the project a good educational experience for other group members</p>

</div></div>
<blockquote><p class="instructions">The remaining fields will appear beneath the instructions in every evaluation, and can not be customized. Total score will be summed automatically as component scores are entered.</p>
<p>
  Total score: 
    <input name="grade" type="text" value=""  disabled >
</p>
<p>
 Comment : <br><textarea cols="50" rows="5" name="comments" disabled ></textarea>
</p></blockquote>
</div></div>
<!--  <p>
    <label for="start">Start Date: </label>
    <input name="start" type="text" id="start" tabindex="2"/>
    <label for="end">(leave blank to accept submissions immediately)<br>
      End Date: </label>
    <input name="end" type="text" id="end" tabindex="3"/><span>(leave blank to allow submissions indefinately)</p>
  <p>Release results: <input name="release" type="radio" value="immediate">immediately
    <input type="radio" name="release"  value="end">after end date
    <input type="radio" name="release"  value="approve">manually
  
  </p>-->
  <div id="rostertools"> Randomly generate groups of <input type="text" name="numGroups" size="5" id="groupSize" /> or fewer <input type="button" onClick="randomGroups()" value="go" /><br><input type="button" value="create empty group" onClick="getNames()"/><input type="button"  value="Create Project"  onClick="compileAndSubmit()"></div>
  <div id="groups"></div>
  <div id="groupcreation">
  <p class="instructions">
      <label for="idlist">Groups: </label>
      enter a list of student ids or usernames, separated by lines, spaces, or tabs. After each group is created, enter a new list to create another group. <i>An initial one-person group has been created for you so that you can see your project in student view.</i></label>
  </p>
 

<p><textarea name="idlist" id="idlist" rows="5"  cols="23" tabindex="4" >10530
10914
11847
13391
14562
15577
15702
17886
19047
19399o
23339
24229
25073
28177
28396
31817
32203
32359
32629
33579
35117
37501
37502
38466
39208
39210
40002
40410
40459
40813
40867
40926
42411
43658
43966
43970
43985
47152
50672
52156
53148
53253
53816
54584
57043
57502
58731
60502
</textarea></p>
 
    <input type="hidden" id="startdate" name="startdate" value="0" >
    <input type="hidden" id="enddate" name="enddate"  value="0">
    
    <p>
      <input type="button" value="create group" onClick="getNames()"/><input type="button" value="use as roster" onClick="getNames(true)"/>
  </p>
    <p>
      <input type="button" name="submit" id="submit"  value="Create Project" accesskey="s" tabindex="4" onClick="compileAndSubmit()">
      
    </p>
</div>

</form>


      </div>          
<div id="ajax" ></div>

</div>

        </div>

        <div class="clear">

        </div>

    </div>


</body>
<script>
/*

35117
52156
32359
16305
700980257
700584865
27009
701067414
60155
19399


*/
var groupdata = "";
var projectRoster;
function createLink()
{
	var selectedtext="";
	if(!window.getSelection){//older IE
		var sText = document.selection.createRange();
		selectedtext = sText.text;
	}else{
		selectedtext = window.getSelection();
	}
	if(selectedtext == ""){
		 alert("please select some text to be used as a hyperlink");
	}else{
		var url = prompt("Enter URL:", "http://");
		if (url){
			document.execCommand("createLink", false, url);
			$("div.custom a").removeAttr("style");
			$("div.custom a").attr("target","_new");
		}
	}
}
function storeCustom(op){
	if(op=="put"){
		var arr_str = "";
		$("#results div.custom input").each(function(){
			arr_str += $(this).val() + ",";
		});
		return arr_str;
	}else{
		var arr = op.split(",");
		$("#results div.custom input").each(function(n){
			$(this).val(arr[n]);
		});
	}
}
function insertInput(){// called on line 265v
$("div.custom").append('<p><input type="text" size="3"> (pts): Description</p>');
	//insertTextAtCursor
	//$("#custom").get(0).insertAdjacentHTML('beforeEnd','<input type="text" size="3">');
}
var trashme = null;
function showInstructorForm(n,deleteOrig){
	$("#email").hide();
	$("#rostertools").hide();
	$("#groups").html("").removeClass("roster");
	trashme = null;
	if(n){
		var ref = "#eval" + n;
		if($(ref).attr("data-self")=="0"){
			$("#includeself").removeAttr("checked");
		}else{
			$("#includeself").attr("checked",true);
		}
		
		$("#custominstructions").load("/peer/2016/studentResults7.php","survey=" + n + "&copy=true",function(){
			if(deleteOrig){
				if(confirm("Editing an active project can be problematic. Continue anyway?")){
					
					trashme = n;
					$("#submit").val("Update Project");
					$("#projectName").val($(ref).text());
				}else{
					trashme = null;
					alert("Your original project is intact. Any changes you submit here will create a copy. Previously submitted evaluations will be associated with the original, not the copy.");
					$("#projectName").val($(ref).text() + " Copy");
				}
			}else{
				$("#projectName").val($(ref).text() + " Copy");
			}
				
			if(deleteOrig){
				$("#pagetitle").text("Edit Project: " + $(ref).text());
			}else{
				$("#pagetitle").text("Copy Project: " + $(ref).text());
			}
			//alert($(ref).nextUntil("li[id^='eval']").length);
			$(ref).nextUntil("li[id^='eval']").each(function(i,e){
				var collection = new Array();
				$(this).children("li:not('.label')").each(function(){
					collection.push($(this).attr('id'));
					});
					$("#idlist").val(collection.join(" "));
					if(collection.length)getNames();
			});
		});
	

	}else if (<?php echo $studentid ?>=="10914"){
		//its me, testing the student roster
		
	}else{//blank
	
		$("#projectName").val("");
		//$("#evalForm").children().val("");
		//$("#idlist").text("");
		$("#includeself").attr("checked",true);
		$("#pagetitle").text("Create New Project");
		$("#idlist").val('<?php echo $studentid ?>');
		getNames();
	}
	//projectRoster = new Array();
			//$("#pagetitle").html("");
		$("#subtitle").text("");
	$("#evalForm").show();
	$("#results").hide();
	
}


var activegroup;




function showGroup(n,prefix,reopen){
	var msg = saveUnsubmitted();
	var opengroup = "#" + $(".formlist").find("li.ui-state-active").attr("id");
	$(opengroup).removeClass("ui-state-active");
	//$("#MainContent_lblError").text(msg);
	var ref = "#" + prefix + n;
	
	//$(ref).next("ul").children("li").attr("data-proj",n);
	$("#reopen").html("");
	if(opengroup==ref){//close it
		
		$("ul.formlist ul li").removeClass("ui-state-active");
		activegroup=null;
		var pt = prefix == "eval" ? "Faculty View" : "Peer Evaluation Results for <?php echo  $firstName . " " . $lastName ?>";
		//$("#pagetitle").html(pt);
		if(prefix=="stu"){
			//$("#summaryResults").show();
			//$("#results").hide();
		}else{
			$("#email").hide();
		}
		
		//return;
	}else{
		$(ref).addClass("ui-state-active");
		$(opengroup).nextAll("ul").hide();
		//$("#pagetitle").html($(ref).text());
		if(prefix=="stu"){
			$("#summaryResults").hide();
			//$("#results").html("<p>Select a peer from the left panel to submit an evaluation of him or her.</p>").show();
		}else{
			
			$("#email").html('<div id="managementoptions" style="padding:12px"></div><div id="email_acc"><h3><a href="#top">Email Project Members</a></h3><div><iframe  src="email2.php?projectID='+n+'&from=<?php echo $udelnetid ?>@udel.edu&fullname=<?php echo $firstName . ' ' . $lastName ?>" height="300" width="90%" frameborder="0" marginheight="0" marginwidth="0"></iframe></div><h3><a href="#top">Project Summary</a></h3><div><iframe onload="emailAccordion()" src="summaryTable6.php?proj='+n+'" height="640" width="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe></div></div>');
			$("#email").show();
		}
		activegroup=n;
	}
	//$(ref).nextAll("ul").hide();
	

		$(ref).next("ul").toggle();

	$("#evalForm").hide();
	$("#subtitle").text("");
	
}

var currentRole;

function testAs(s){
	currentRole=s;
	if(s=="student"){
		$("#email").hide();
		//$("#summaryResults").append("<p>Click on a project name in the left side-panel to evaluate your group's members</p><p>Click on a project name above to view feedback you have received</p>");
		activegroup=null;
		$(".student").show();
		$(".faculty").hide();
		$("#evalForm").hide();
		//$("#summaryResults").show();
		//$("#pagetitle").html("Peer Evaluation Results for <?php echo  $firstName . " " . $lastName ?>");
		
	}else{
		$(".student").hide();
		$(".faculty").show();
		$("#summaryResults").hide();
		$("#pagetitle").html("Faculty View");
		toggleHelp();
	}
	$("#results").hide();
	
}
var testing = '<?php echo $testing?>';
function clearMessages(){
	$("#MainContent_lblError, #MainContent_lblSuccess").html("");
}

function submitMe(btn){
	//$("#alert").dialog("close");
	var totscore = 0;
	var maxscore=0;
	var validates=true;
		var obj = new Object();
		obj['custom']="";
	$(btn).parent().find("input").each(function(){
		if($(this).attr("type")!= "button"){
			var name = $(this).attr("name");
			var value = $(this).val();
			
			if(!name || name=="undefined" || name=="nosubscores"){//this is an unnamed category field
				obj['custom'] += $(this).val() + ",";
			
				if((isNaN(value) || Number(value)<0 || value=="" || value > Number($(this).attr("max")))&& $(this).css("display")!= "none" ){//
									$(this).addClass("ui-state-highlight");
					validates = false;
				}else{
					$(this).removeClass("ui-state-highlight");
				}
				totscore+=Number(value);
				maxscore += Number($(this).attr("max"));
			}else if(name=="grade"){
					
				if($(btn).parent().find("input[name='nosubscores']").length==0){
				//there are category scores, so correct the math
					$(this).val(totscore);
				}
				
				
				
				obj[name]=Number($(this).val());
			
			}else{//not a grade
				obj[name]=value;
			}
			
		}
	
		
		obj['comments'] = $(btn).parent().find("textarea").val();
		});
			if(!validates){
			alert("Please enter a score for each highlighted field. Scores may not exceed the value indicated by parentheses.");
			$("input.ui-state-highlight").get(0).focus();
			return;
		}
		
		var testnum =  Number($("input[name=grade]").val());
				var testbool = $.isNumeric(testnum);
				obj.emplid='<?php echo $_SESSION['cas_data']['EMPLID']; ?>';

	if(testbool  && obj.grade>=0 && obj.grade<=maxscore){$("#ajax").load("<?php echo $peerhtml ?>submitEval.php",obj,function(a,status,c){
		$("input[name=grade]").removeClass("ui-state-highlight");
		if(a == "Thank you"){//I don't know how to set status to failure
			//alert($("#ajax").html());
			$(btn).val("update");
			var prefix =  currentRole == "faculty" ? "#eval" : obj.evaluatee < 2000 ? "#prod" :"#stu";

			var survey = prefix + obj['surveyid'];
		
			var sdone = obj['evaluatee'];
			$(survey).nextUntil("li").find("li#"+obj['evaluatee']).removeClass("pending").removeClass("waiting").addClass("complete").prev("span.waiting").hide();
			if($("#results p.ui-state-highlight").length){
				$("#results p.ui-state-highlight").hide().text("Your submission has been updated").fadeIn(500);
			}else{
				$("#results").prepend('<p align="center" class="ui-state-highlight">'+ a +'. Your submission has been recorded. You may modify this evaluation, select another evaluation, or log out.</p>');
			}
			
			/*$("#results").prepend('<p align="center" class="ui-state-highlight">Thank-you</p>');
			$(survey).next("ul").find("li").each(function(){
				
				if($(this).attr("id")==obj['evaluatee']){
					$(this).toggleClass("pending").addClass("complete");
				}
				});*/
		}else{
			alert('There has been a problem with your submission. Please <a href="https://sites.google.com/a/udel.edu/peer/features-for-testing/2014s-bugs" target="_blank"> report this bug.</a>');
		}
	});
	}else{
		
		alert("Please enter a score between 0 and "+maxscore);
		$("input[name=grade]").addClass("ui-state-highlight");
	}
    
	
}// submitme
var cookieNotification = "";
function saveUnsubmitted(){//called when any list item is clicked
	clearMessages();
	var activeitem = $("ul.formlist ul li.ui-state-highlight");
	//if(activeitem.hasData()){
	var oldData = activeitem.data("grade") + activeitem.data("comment") + activeitem.data("custom");
						 // }else{
							//  var oldData="";
						 // }
	var cc = storeCustom("put");
			var currentData = $("input[name=grade]:first").val() + $("textarea[name=comments]:first").val() + cc;
			//alert(oldData+  "?" + currentData);
		if(currentData != oldData && activeitem.length>0){
		
			var msg = "saving unsubmitted form data for " +$(activeitem).text() +". this data will be lost if you log out or refresh your browser";
			
			activeitem.data("grade",$("input[name=grade]:first").val());
			activeitem.data("comment",$("textarea[name=comments]:first").val());
			activeitem.data("custom",storeCustom("put"));
			//alert(activeitem.data("comment"));
		}else{
			//activeitem.removeData();
			var msg="";
		}
		
			
			//$("#MainContent_lblError").text(msg);
		
		return msg;
}
//var msgActive=true;false when summary eval loads, true if changed, or student form loads
function toggleHelp(){
	$('#help').toggle();
	if($('#helpbtn').text()=="X"){
		$('#helpbtn').text("?");
		$("div.vscroll").show();
	}else{
		$('#helpbtn').text("X");
		$("div.vscroll").hide();
	}
}
function toggleElement(selector){
	$(selector).toggle();
	$("div.vscroll").toggle();
	if($("div.vscroll").is(":hidden")){
		$("#pagetitle, #footer").html("<a href=\"#\" onclick=\"toggleElement('"+selector+"')\">Go Back</a>");
	}else{
		$("#pagetitle,#subtitle,#footer").html("");
	}
}
function emailAccordion(){
	$( "#email_acc" ).accordion({
	
		collapsible: true,
		autoHeight:false
		});
}
function compileFromCustom(obj){
	var ts = 0;
	var subform = $(obj.target).parents(".custom").find("input");
	var ctotal = $(obj.target).parents("form").find("input[name=grade]");
	
	$(subform).each(function(index, element){
	//$(".custom input").not(".custominstructions .custom input").each(function(index, element) {
        ts += Number($(this).val());
    });
	$(ctotal).val(ts);
}
function showStatus(e,t){
	
	$("#tooltip").css({"top":(e.clientY-10)+ "px","left":e.clientX + "px"}).text(t).show().hide(2000);
}
function showList(){
	$("div.vscroll").show();
}
$(document).ready(function(e) {

	$("#summaryResults").hide();
	$("#groups").scroll(function(e){
		$("ul.roster").css("margin-top",e.target.scrollTop);
	});

	$(".faq ul:first").delegate("li","click",function(){
		$(this).children("ul,ol").toggle();
	});
	//know when data has changed
/*	$("#accordion4 div form").delegate("input","blur",function(){
						msgActive=true;alert(msgActive);
											 
																							});*/
//$('body').bind('click',null,clearMessages);
	//enable accordion for multiple results
	$( "#custom" ).accordion({
	
		collapsible: true,
		autoHeight:false,
		active:false});
$( "#accordion3" ).accordion({
	
		collapsible: true,
		autoHeight:false,
		active:false});
//
	//enable datepicker on date fields
	if(testing){
		testAs('faculty' ); 
	}else if(<?php echo preg_match("/FACULTY/",$usertype) ?> ){
		currentRole="faculty";
		toggleHelp();
		$(".student").hide();
	}else if(<?php echo preg_match("/STUDENT/",$usertype) ?> ){
		$(".faculty").hide();
		toggleHelp();
	}
	
	
		
   // $("#start").datepicker({altField:"#startdate",altFormat:"yy-mm-dd",defaultDate:new Date(),selectDefaultDate:true});
	//$("#end").datepicker({altField:"#enddate",altFormat:"yy-mm-dd"});
	$("ul li ul").hide();
	
	//set up function for member links
	//$(".vscroll").css("height",($(window).height() -60)+"px");
/*	$("ul.formlist ul").delegate("li:not('.label,.archived')","mouseover",function(e){
		showStatus(e,$(this).attr("class"))
	});*/

	$("ul.formlist ul").delegate("li:not('.label,.archived')","click",function(e){
		
		//if($(this).hasClass('ui-state-highlight')) return;this is already the active record
		//if($(this).parent().prev("li").hasClass("archived")) return;
		var msg =	saveUnsubmitted();														
		if(currentRole =="faculty") $("#reopen").html('<a href="#" class="rounded btn" onclick="showOptions()">Project Options</a></div>');
		var id = $(e.target).attr("id");
			$("#email").hide();//management tools also
		$("ul.formlist ul li").removeClass("ui-state-highlight");
		$(this).addClass("ui-state-highlight");															
				var type =  currentRole == "faculty" ? "eva" : "stu";
				if($(this).attr("data-email")=="presentation") type="prod";
		if(testing){
			var roleid = type == "eva" ? <?php echo $facid ?> : <?php echo $studentid ?>;
		}else{
			var roleid = <?php echo $emplid ?>;
		}	

			var stuname = $(e.target).text().split(" (")[0];
		var pd = new Object();//get evaluation submitted for/by evaluatee/evaluator
		pd.id=id;
		pd.survey=activegroup;
		pd.evaluator=roleid;
		pd.name = stuname;
		pd.type = type;
		//var datastr = "id=" + id + "&survey=" + activegroup + "&emplid=" + roleid + "&name=" + stuname + "&type=" + type;
		var persontype = "<?php echo $usertype ?>";
		if (type=="eva"){
			
			$("#subtitle").text("Results for " + $(e.target).text());
			datastr += "&showall=true";
		
		}else{
		
		$("#subtitle").text("Your evaluation of " + $(e.target).text());
		}
		
		$("#results").load("/peer/2016/studentResults7.php",pd,function(){
			toggleElement("#results");
					var li = $(e.target);
	//$("#MainContent_lblError").text(msg);
		if(jQuery.hasData(e.target)){
			//$("#MainContent_lblError").text("restoring unsubmitted data");
			
			$("input[name=grade]:first").val(li.data("grade"));
			$("textarea[name=comments]:first").val(li.data("comment"));
			storeCustom(li.data("custom"));
			//return;
		}else{
		li.data("grade",$("input[name=grade]:first").val());
			li.data("comment",$("textarea[name=comments]:first").val());
			//alert(storeCustom("put"));
			li.data("custom",storeCustom("put"));
		}
		if(li.hasClass("pending")){
				$("input[value=update]").attr("value","submit");	   
					   }
			$( "#accordion" ).accordion({
	
		collapsible: true,
		autoHeight:false,
		active:false});
				$( "#accordion2" ).accordion({
	
		collapsible: true,
		autoHeight:false,
		active:false}
	
			   );	
			   	
		});
	});
});

</script>
<h1 id="footer"></h1>
</html>