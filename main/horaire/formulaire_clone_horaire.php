
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


$TABLECALDATES = Database :: get_course_table(TABLE_CAL_DATE);
$TABLECALHORAIRE  = Database :: get_course_table(cal_horaire);
$TABLECALTEMP  = Database :: get_course_table(cal_temp);
$course_code = $_course['real_id'];

$view = (isset($_REQUEST['view'])?$_REQUEST['view']:'');

$nameTools = get_lang('ToolIndividualise');
 Display::display_header($nameTools, 'ToolIndividualise');
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>Horaire cr�er</title>
  
  <script language="javascript" src="ks.js"></script>
</head>
<body>

<div class="actions">

 <a href="index.php"<?php is_active('lang', $page); ?>><?php echo get_lang('gestion_cal'); ?></a>
  
  <a href=" formulaire_delete_horaire.php"<?php is_active('lang', $page); ?><img src="../img/calendar_delete.png" border="0" ><?php echo get_lang('delete_calendar'); ?><img src="../img/calendar_delete.png" border="0" ></a>
     
 
</div>   
<p><font face="Verdana"><?php echo get_lang('created_cal'); ?></font></p>
    
	<font face="Verdana"><?php  echo  $horaire_name ;?></font>
  <form action="horaire_clone.php" method="post" >
<SELECT NAME='nom_hor'>
            <OPTION VALUE='<?php echo"$horaire_name" ?>'><?php echo get_lang('select_calendar_to_clone'); ?></OPTION> 
            <?php
            $sql = "SELECT distinct name FROM $TABLECALHORAIRE
             where c_id = $course_code  ";
        $result2 = api_sql_query($sql);// OR die(mysql_error());

                                                while ( $row = Database::fetch_array( $result2)) {
                                                        $horaire_name = $row['name'];
                                                        $c_id = $row['c_id'];
                                                        
                                                            ?>
            <OPTION VALUE='<?php echo Database::escape_string(Security::remove_XSS($horaire_name)); ?>'><?php echo Database::escape_string(Security::remove_XSS($horaire_name)); ?></OPTION>
            <?php
                                                }
                                                ?>
           </SELECT>
                  
 
        <table>
    <p>&nbsp; <font face="Verdana"><?php  echo  get_lang('add_content') ;?></font></p>
       
   
  <tr>
           <SELECT NAME='nom_hor_target'>
            <OPTION VALUE='<?php echo"$horaire_name" ?>'><?php echo get_lang('select_calendar_target'); ?></OPTION> 
            <?php
            $sql = "SELECT distinct name FROM $TABLECALHORAIRE
             where c_id = $course_code  ";
        $result2 = api_sql_query($sql);// OR die(mysql_error());

                                                while ( $row = Database::fetch_array( $result2)) {
                                                        $horaire_name = $row['name'];
                                                        $c_id = $row['c_id'];
                                                        
                                                            ?>
            <OPTION VALUE='<?php echo Database::escape_string(Security::remove_XSS($horaire_name)); ?>'><?php echo Database::escape_string(Security::remove_XSS($horaire_name)); ?></OPTION>
            <?php
                                                }
                                                ?>
           </SELECT>
             
          
                   <td  class="submit"> <center><input style=" width:85px; background-color:#E5EDF9;"type="submit" name="Submit2" value="<?php echo get_lang('validate'); ?>"></td>
                   <td  class="submit"> <center><input style=" width:85px; background-color:#E5EDF9;" name="reset" type="reset" id="reset2" value="<?php echo get_lang('erase'); ?>"> </td>
  </form></tr></table>
 </body>

</html>
 <?php
 
Display::display_footer();

  ?>

