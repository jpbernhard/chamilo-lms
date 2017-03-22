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
  
Display::display_header($nameTools, "Tracking");

$id =isset($_GET['id'])?$_GET['id']:"";

?>
<form action="update_mod.php" method="post" name="save_mod">
<table class='data_table'>
<tr>
<th colspan="2"><?php echo get_lang('edit_config');?>
</tr>
<tr>

<th  style="width: 200px"><?php echo get_lang('minute_mod') ?></th> 
<th><?php echo get_lang('action') ?></th>
</tr>

						<?php

//on cherche les données de config

 $Req = "SELECT *
	FROM c_cal_set_module
  WHERE id = '$id'

 	";

    $res = api_sql_query($Req);// or die(mysql_error());
    $result = Database::fetch_array($res) ;
    
   
    $minutes=$result['minutes'];
?>
			
     
       <td><input type=text style=width:60px name=minute size=1 value= <?php echo $minutes; ?> </td>
       
				<INPUT  type=hidden name=id value= <?php echo "$id" ?> >
				 
				<td><input type="submit" value="Sauvegarder" name="B1"></td>
	</td>
      </tr>


	</table>
   </form>
<?php


	/*
==============================================================================
		FOOTER
==============================================================================
*/

Display::display_footer();
?>
