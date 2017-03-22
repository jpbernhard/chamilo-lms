<?php
// Par André Boivin
/*
==============================================================================

==============================================================================
		INIT SECTION
==============================================================================
*/
$pathopen = isset($_REQUEST['pathopen']) ? $_REQUEST['pathopen'] : null;
// name of the language file that needs to be included

$language_file[] = 'tracking';

include('../inc/global.inc.php');

$is_allowedToTrack = $is_courseAdmin || $is_platformAdmin || $is_courseCoach || $is_sessionAdmin;

if (!$is_allowedToTrack) {
	Display :: display_header(null);
	api_not_allowed();
	Display :: display_footer();
	exit;
}

//includes for SCORM and LP
api_block_anonymous_users();



/*
-----------------------------------------------------------
	Constants and variables
-----------------------------------------------------------
*/

$view = $_REQUEST['view'];
  
$name =isset($_POST['name'])?$_POST['name']:"";
$num_minute=isset($_POST['num_minute'])?$_POST['num_minute']:"";
$num_hours=isset($_POST['num_hours'])?$_POST['num_hours']:"";


foreach($_POST as $index => $valeur) {
    $$index = Database::escape_string(trim($valeur));
}
$sql4 = "UPDATE c_cal_horaire SET num_hours='$num_hours', num_minute='$num_minute'
		WHERE name = '$name'
    ";
			api_sql_query($sql4);// OR die("<p>Erreur Mysql2<br/>$sql4<br/>".mysql_error()."</p>");
header('Location: admin.php');
?> 
