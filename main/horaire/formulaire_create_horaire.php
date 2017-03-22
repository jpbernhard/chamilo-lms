 <?php

 // name of the language file that needs to be included 
$language_file[] = 'admin';
$language_file[] = 'tracking';
 
// including the global Dokeos file
require '../inc/global.inc.php';

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

include_once('functions.inc.php');    

$TABLECALDATES = Database :: get_course_table(cal_dates);
$TABLECALHORAIRE  = Database :: get_course_table(cal_horaire);
$TABLECALTEMP  = Database :: get_course_table(cal_temp);


$view = (isset($_REQUEST['view'])?$_REQUEST['view']:'');

$nameTools = get_lang('ToolIndividualise');
 Display::display_header($nameTools, 'ToolIndividualise');
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>Horaire créer</title>
  
  <script language="javascript" src="ks.js"></script>
</head>
<body>

<div class="actions">

 <a href="index.php"<?php is_active('lang', $page); ?>><?php echo get_lang('gestion_cal'); ?></a>
  
  <a href=" formulaire_delete_horaire.php"<?php is_active('lang', $page); ?><img src="../img/calendar_delete.png" border="0" ><?php echo get_lang('delete_calendar'); ?><img src="../img/calendar_delete.png" border="0" ></a>
   <a href=" formulaire_clone_horaire.php"<?php is_active('lang', $page); ?><img src="../img/clone.png" border="0" ><?php echo get_lang('clone_calendar'); ?><img src="../img/clone.png" border="0" ></a>
    
 
</div>
<p><font face="Verdana"><?php echo get_lang('created_cal'); ?></font></p>

	<font face="Verdana"><?php  echo  $horaire_name ;?></font>


<?php
 $course_id  = api_get_course_int_id();

$sql = "SELECT distinct name FROM $TABLECALHORAIRE 
        WHERE c_id = '$course_id'
        ";
        $result2 = api_sql_query($sql);// OR die(mysql_error());

                                                while ( $row = Database::fetch_array( $result2)) {
                                                        $horaire_name = $row["name"];
  
  ?>

<ul>
	<li><font face="Verdana"><?php  echo  $horaire_name ;?></font></li>
</ul>

<?php
  }

 ?>

  <form action="horaire_new.php" method="post" >
        <center><table>


  <tr>
            <td > <?php echo get_lang('enter_cal_name'); ?> </td>
            <td ><input name="nom_hor" type="text" id="uni2" size="30" maxlength="30" value=""></td>
            
    </tr>
    <tr>     <td colspan="2"  > <?php echo get_lang('know_end'); ?> </td>
     </tr>
    
     <tr>   <td > <?php echo get_lang('enter_num_hours'); ?> </td>     
            <td ><input name="num_hours" type="text" id="num_hours" size="30" maxlength="30" value=""><?php echo get_lang('hours'); ?></td>
          </tr>
          <tr>   <td > <?php echo get_lang('enter_num_minute'); ?> </td>     
            <td ><input name="num_minute" type="text" id="num_minute" size="30" maxlength="30" value=""><?php echo get_lang('enter_num_minute_day'); ?></td>
          </tr>
           <tr>
                   <td  class="submit"> <center><input style=" width:85px; background-color:#E5EDF9;"type="submit" name="Submit2" value="<?php echo get_lang('validate'); ?>"></td>
                   <td  class="submit"> <center><input style=" width:85px; background-color:#E5EDF9;" name="reset" type="reset" id="reset2" value="<?php echo get_lang('erase'); ?>"> </td>
  </table></center></form></td></tr></table>
 </body>

</html>
 <?php
Display::display_footer();

  ?>  
