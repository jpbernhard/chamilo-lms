<?php
//pour la date de fin de la formation Par André Boivin
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
  
//Display::display_header($nameTools, "Tracking");


$id =isset($_POST['id'])?$_POST['id']:"";
$minute=isset($_POST['minute'])?$_POST['minute']:"";



foreach($_POST as $index => $valeur) {
    $$index = Database::escape_string(trim($valeur));
}
$sql4 = "UPDATE c_cal_set_module SET  minutes='$minute'
		WHERE id = '$id'
    ";
			api_sql_query($sql4);// OR die("<p>Erreur Mysql2<br/>$sql4<br/>".mysql_error()."</p>");
header('Location: config_mod.php'); 
