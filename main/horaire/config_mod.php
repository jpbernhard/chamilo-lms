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

$TABLECALDATES = Database :: get_course_table(TABLE_CAL_DATE);
$TABLECALHORAIRE  = Database :: get_course_table(TABLE_CAL_HORAIRE);
$TABLECALTEMP  = Database :: get_course_table(TABLE_CAL_TEMP);
$course_code = $_course['real_id'];



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
 <?php 
//on cherche les données de config
 $Req1 = "SELECT *
	FROM c_cal_set_module
  WHERE c_id = '$course_code'
 
 	";
    $res = api_sql_query($Req1);// or die(mysql_error());

    $result = Database::fetch_array($res);
    $id=$result['id'];
    $c_id=$result['c_id'];
  
   if ($c_id ==''){
?>     
<form action="create_config.php" method="post" name="create_config">
<table class='data_table'>
<tr>
<th colspan="2"><?php echo get_lang('create_config');?>
</tr>
<tr>

<th  style="width: 200px"><?php echo get_lang('minute_mod') ?></th> 
<th><?php echo get_lang('action') ?></th>
</tr>
          
<tr>

<td><input type="text" style="width: 60px" NAME="min_mod" size="1" <?php echo "$min_mod "?></textarea></td>
      
<td><input type="submit" name="submit" value="<?php echo  get_lang('Ok') ?>" /></td> 
<INPUT  type=hidden name=ex_user_id value= <?php echo $student_id ?> >

</td></th> 
</tr>
</table></form>
 <?php
   }
   else {
?>  
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
 $Req1 = "SELECT *
	FROM c_cal_set_module
  WHERE c_id = '$course_code'
 
 	";
    $res = api_sql_query($Req1);// or die(mysql_error());

    while($result = Database::fetch_array($res)) {
    $id=$result['id'];
    $c_id=$result['c_id'];
    $minutes=$result['minutes'];

     echo"
     <tr>
     	
				<td  style='width: 200px'>".$result['minutes']."</td>
					
				";
			
				?>
          			
	<td class="highlight"><a href="edit_mod.php?id=<?php echo $id ?>"><img src="../img/edit.gif" border="0" alt="<?php echo $lang_editer ;?>"></a>
	&nbsp;&nbsp;<a href="delete_mod.php?id=<?php echo $id ?>"><img src="../img/delete.gif" border="0" alt="<?php echo $lang_suprimer ;?>" onClick='return confirmDelete2()'></a>
   
   	 
<?php
   } }
?>  
 </table>
 
</body>
</html>
 <?php 
Display::display_footer();
  ?>
