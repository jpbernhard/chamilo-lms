<?php
// dérivé de Booking Calendar Lite de Chris@KreCi.net
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

$TABLECALDATES = Database :: get_course_table(cal_dates);
$TABLECALHORAIRE  = Database :: get_course_table(cal_horaire);
$TABLECALTEMP  = Database :: get_course_table(cal_temp);
$course_code = $_course['real_id'];

$sql0 = "DELETE FROM $TABLECALTEMP 
WHERE user = '$my_user_id'" ;
api_sql_query($sql0);// or die('Erreur SQL !<br>'.$sql0.'<br>'.mysql_error());

$view = (isset($_REQUEST['view'])?$_REQUEST['view']:'');

$nameTools = get_lang('ToolIndividualise');
 Display::display_header($nameTools, 'ToolIndividualise');

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>Horaire</title>
  
  <script language="javascript" src="ks.js"></script>
</head>
<body>

<div class="actions">
  
   <a href="formulaire_create_horaire.php"<?php is_active('lang', $page); ?><img src="../img/calendar_add.png" border="0" ><?php echo get_lang('create_empty_calendar'); ?><img src="../img/calendar_add.png" border="0" ></a> 
  <a href=" formulaire_delete_horaire.php"<?php is_active('lang', $page); ?><img src="../img/calendar_delete.png" border="0" ><?php echo get_lang('delete_calendar'); ?><img src="../img/calendar_delete.png" border="0" ></a>
   <a href=" formulaire_clone_horaire.php"<?php is_active('lang', $page); ?><img src="../img/clone.png" border="0" ><?php echo get_lang('clone_calendar'); ?><img src="../img/clone.png" border="0" ></a>
 
</div>
    <font face="Verdana"><?php  echo  get_lang('see_calendar') ;?></font>  
    <form action="insert_temp.php" method="post" >
  <SELECT NAME='hor_name'>
            <OPTION VALUE='<?php echo"$horaire_name" ?>'><?php echo get_lang('select_calendar'); ?></OPTION>
            <?php
            $sql = "SELECT distinct name FROM $TABLECALHORAIRE
            where c_id = $course_code  ";
        $result2 = api_sql_query($sql);// OR die(mysql_error());

                                                while ( $row = Database::fetch_array( $result2)) {
                                                        $horaire_name = $row["name"];
                                                            ?>
            <OPTION VALUE='<?php echo $horaire_name; ?>'><?php echo "$horaire_name "; ?></OPTION>
            <?php      }
                              ?>
           </SELECT>
           <td  class="submit"><input type="submit" name="Submit2" value="<?php echo get_lang('validate'); ?>"></td>
          
         
   
 </form></td></tr>
</body>
</html>
 <?php 
Display::display_footer();
  ?>
