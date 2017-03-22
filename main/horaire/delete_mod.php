<?php
//pour la date de fin de la formation Par André Boivin
// name of the language file that needs to be included 
$language_file[] = 'admin';
$language_file[] = 'tracking';

// including the global chamilo file
require '../inc/global.inc.php';
$my_user_id=api_get_user_id();
include_once('functions.inc.php');
// the section (for the tabs)
$this_section = "session_my_space";

$is_allowedToTrack = $is_courseAdmin || $is_platformAdmin || $is_courseCoach || $is_sessionAdmin;

if (!$is_allowedToTrack) {
	Display :: display_header(null);
	api_not_allowed();
	Display :: display_footer();
	exit;
}
// including additional libraries

require_once api_get_path(LIBRARY_PATH).'tracking.lib.php';
require_once api_get_path(LIBRARY_PATH).'course.lib.php';

$view = (isset($_REQUEST['view'])?$_REQUEST['view']:'');

$nameTools = get_lang('ToolIndividualise');
// Display::display_header($nameTools, 'Tracking');

$id =isset($_GET['id'])?$_GET['id']:"";
 
$sql4 = "DELETE FROM c_cal_set_module  
 		WHERE id ='$id' 

    ";

			api_sql_query($sql4);// OR die("<p>Erreur Mysql2<br/>$sql4<br/>".mysql_error()."</p>");
header('Location: config_mod.php');
?>	
