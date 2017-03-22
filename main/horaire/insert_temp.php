<?php
//on insère le nom de l'horaire et le user dans la table temp
 $hor_name=isset($_POST['hor_name'])?$_POST['hor_name']:"";
 
// including the global Dokeos file
require '../inc/global.inc.php';
$my_user_id=api_get_user_id(); 
include('lang.inc.php');


$is_allowedToTrack = $is_courseAdmin || $is_platformAdmin || $is_courseCoach || $is_sessionAdmin;

if (!$is_allowedToTrack) {
	Display :: display_header(null);
	api_not_allowed();
	Display :: display_footer();
	exit;
}
$course_code = $_course['real_id']; 
$TABLECALTEMP  = Database :: get_course_table(cal_temp);

$sql1 = "INSERT INTO $TABLECALTEMP (temp,user,c_id) Values ('$hor_name','$my_user_id','$course_code')";
api_sql_query($sql1);// or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
  
header('Location: admin.php');

?>
