<?php
//pour la date de fin de la formation Par André Boivin
$language_file[] = 'tracking';

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
                                           

$min_mod=isset($_POST['min_mod'])?$_POST['min_mod']:"";
$min_mod=Security::remove_XSS($min_mod);
$min_mod=api_replace_dangerous_char(($min_mod));
$min_mod=disable_dangerous_file($min_mod); 


$course_code = $_course['real_id'];   

if ($min_mod =='') {
        ?> 
        
      <td colspan="32" style="text-align: center;">
        <input style="font-size:12pt; border : 1px solid #90A3A9; width:305px; background-color:#FFD6D6;"  value=" <?php echo get_lang('no_name'); ?>" name="Submit" />
              </td>
    </tr>
    
  <?php
      break;
        }
$sql1 = "INSERT INTO c_cal_set_module (c_id,minutes) Values ('$course_code','$min_mod')";
api_sql_query($sql1);// or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

header('Location: config_mod.php');
?>
