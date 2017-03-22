<?php
$language_file[] = 'tracking';

// including the global Dokeos file

require '../inc/global.inc.php';
require_once api_get_path(LIBRARY_PATH).'fileUpload.lib.php';
// the section (for the tabs)
$this_section = "session_my_space";

$is_allowedToTrack = $is_courseAdmin || $is_platformAdmin || $is_courseCoach || $is_sessionAdmin;

if (!$is_allowedToTrack) {
	Display :: display_header(null);
	api_not_allowed();
	Display :: display_footer();
	exit;
}
$TABLECALHORAIRE  = Database :: get_course_table(cal_horaire);

                                           
$nom_hor=isset($_POST['nom_hor'])?$_POST['nom_hor']:"";
$nom_hor=Security::remove_XSS($nom_hor);
$nom_hor=Security::remove_XSS(($nom_hor));
$nom_hor=disable_dangerous_file($nom_hor); 

$num_hours=isset($_POST['num_hours'])?$_POST['num_hours']:"";
$num_hours=Security::remove_XSS($num_hours);
$num_hours=Security::remove_XSS(($num_hours));
$num_hours=disable_dangerous_file($num_hours); 

$num_minute=isset($_POST['num_minute'])?$_POST['num_minute']:"";
$num_minute=Security::remove_XSS($num_minute);
$num_minute=Security::remove_XSS(($num_minute));
$num_minute=disable_dangerous_file($num_minute); 

$course_code = $_course['real_id'];   

$nom_hor= $nom_hor.'.'.$course_code;

if ($nom_hor =='') {
        ?> 
        <div class="actions"> 
      <a href="formulaire_create_horaire.php"<img src="../img/calendar_add.gif" border="0" ><?php echo get_lang('create_empty_calendar'); ?></a> 
     </div>
      <td colspan="32" style="text-align: center;">
        <input style="font-size:12pt; border : 1px solid #90A3A9; width:305px; background-color:#FFD6D6;"  value=" <?php echo get_lang('no_name'); ?>" name="Submit" />
              </td>
    </tr>
    
  <?php
      break;
        }
$sql1 = "INSERT INTO $TABLECALHORAIRE (name,c_id,num_hours,num_minute) Values ('".Database::escape_string (Security::remove_XSS($nom_hor))."','$course_code','$num_hours','$num_minute')";
api_sql_query($sql1);// or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

header('Location: formulaire_create_horaire.php');
?>
