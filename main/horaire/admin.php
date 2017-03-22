<?php  
 // name of the language file that needs to be included 
$language_file[] = 'admin';
$language_file[] = 'tracking';

// including the global Dokeos file
require '../inc/global.inc.php';
$my_user_id=api_get_user_id(); 
include('lang.inc.php');

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

$TABLECALDATES = Database :: get_course_table(cal_dates);
$TABLECALHORAIRE  = Database :: get_course_table(cal_horaire);
$TABLECALTEMP  = Database :: get_course_table(cal_temp);
$course_code = $_course['real_id'];   
(isset($_GET['page'])) ? $page = $_GET['page'] : $page = 'manage';
$cyear = escape_cyear();
 
$nameTools = get_lang('ToolIndividualise');
 Display::display_header($nameTools, 'ToolIndividualise');;


if (isset($_POST['Submit']) && isset($_POST['stan']) )update_db($_POST, $cyear,$course_code);
 $course_id  = api_get_course_int_id();

$sql2 = "SELECT * FROM $TABLECALTEMP
WHERE user = '$my_user_id'";
         $result2 = api_sql_query($sql2);// OR die(mysql_error());
        $data2 = Database::fetch_array($result2);
        $hor_name2 = $data2["temp"];
        if ($hor_name2 =='') {
        ?> 
<tr>
      <td colspan="32" style="text-align: center;">
        <input style="font-size:12pt; border : 1px solid #90A3A9; width:325px; background-color:#FFD6D6;"  value=" <?php echo get_lang('not_select'); ?>" name="Submit" />
      </td>
    </tr>
  <?php
    break;
  }




$sql = "SELECT * FROM $TABLECALHORAIRE 
        WHERE c_id = '$course_code'
        AND name =  '$hor_name2'
        ";
        $result2 = api_sql_query($sql);// OR die(mysql_error());
         $row = Database::fetch_array( $result2); 
       
       $num_minute = $row["num_minute"];
       $num_hours = $row["num_hours"];
       $name = $row["name"]; 
     
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>Édition Horaire</title>
    
  <script language="javascript" src="ks.js"></script>
</head>
<body>

<div class="actions">

  <a href="index.php"<?php is_active('lang', $page); ?>><?php echo get_lang('gestion_cal'); ?></a>
     <a href="formulaire_create_horaire.php"<?php is_active('lang', $page); ?><img src="../img/calendar_add.gif" border="0" ><?php echo get_lang('create_empty_calendar'); ?><img src="../img/calendar_add.gif" border="0" ></a> 
  <a href=" formulaire_delete_horaire.php"<?php is_active('lang', $page); ?><img src="../img/calendar_delete.png" border="0" ><?php echo get_lang('delete_calendar'); ?><img src="../img/calendar_delete.png" border="0" ></a>
   <a href=" formulaire_clone_horaire.php"<?php is_active('lang', $page); ?><img src="../img/clone.png" border="0" ><?php echo get_lang('clone_calendar'); ?><img src="../img/clone.png" border="0" ></a>
          

</div>
<form action="edit_hor_conf.php?formulaire" method="post"> 
 <div>
 <tr>  <td ><input name="num_hours" type="text" id="num_hours" style=width:60px size="10" maxlength="20" value="<?php echo $num_hours ; ?>"><?php echo get_lang('hours'); ?></td>
        <td ><input name="num_minute" type="text" id="num_minute" style=width:60px size="10" maxlength="20" value="<?php echo $num_minute ; ?>"><?php echo get_lang('enter_num_minute_day'); ?></td>
          </tr>
          <INPUT  type=hidden name=name value= <?php echo "$name" ?> >
            	&nbsp;&nbsp;<input type="submit" value="Modifier" />
             </tr>
 </div> 

        
</form>
 </div> 
<?php if ($page == 'config') : ?>

<?php elseif ($page == 'lang') :
 ?>

<?php else: ?>
<?php
$sql2 = "SELECT * FROM $TABLECALTEMP
WHERE user = '$my_user_id'";
         $result2 = api_sql_query($sql2);// OR die(mysql_error());
        $data2 = Database::fetch_array($result2);
        $hor_name2 = $data2["temp"];
        if ($hor_name2 =='') {
        ?> 
<tr>
      <td colspan="32" style="text-align: center;">
        <input style="font-size:12pt; border : 1px solid #90A3A9; width:325px; background-color:#FFD6D6;"  value=" <?php echo get_lang('not_select'); ?>" name="Submit" />
      </td>
    </tr>
  <?php
    break;
  }
       
echo get_lang('selected_cal');?>
<td><?php echo"&nbsp;&nbsp;$hor_name2";?></td><br />
 
<p>
<?php get_lang('select_cel');?>
</p>
<form name="myform" method="post">
<?php calendar($cyear, 1); ?>

</form>


<?php endif; ?>

</div>

</body>
</html>
 <?php
Display::display_footer();
  ?>
