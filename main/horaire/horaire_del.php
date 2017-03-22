<?php
        
require '../inc/global.inc.php';
  
$TABLECALHORAIRE  = Database :: get_course_table(cal_horaire);
$TABLECALDATES = Database :: get_course_table(cal_dates);                            
$nom_hor=isset($_POST['nom_hor'])?$_POST['nom_hor']:"";
 
$sql1 = "DELETE FROM  $TABLECALHORAIRE where name = '".Database::escape_string(Security::remove_XSS($nom_hor))."'";
api_sql_query($sql1);// or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

$sql2 = "DELETE FROM  $TABLECALDATES where horaire_name = '".Database::escape_string(Security::remove_XSS($nom_hor))."'";
api_sql_query($sql2);// or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
   
header('Location: formulaire_delete_horaire.php');
        
?>
