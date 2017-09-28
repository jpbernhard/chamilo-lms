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
$TABLECALHORAIRE  = Database :: get_course_table(TABLE_CAL_HORAIRE);
$TABLECALDATES = Database :: get_course_table(TABLE_CAL_DATE);
                                           
$nom_hor=isset($_POST['nom_hor'])?$_POST['nom_hor']:"";
$nom_hor=Security::remove_XSS($nom_hor);
$nom_hor=disable_dangerous_file($nom_hor);

// Francois Belisle Kezber
// now api_replace_dangerous_char

// $nom_hor=api_replace_dangerous_char(($nom_hor));

$course_code = $_course['real_id'];
$nom_hor_target=isset($_POST['nom_hor_target'])?$_POST['nom_hor_target']:"";


   

//on r�cup�re les donn�es de l'horaire source
$sql2 = "SELECT * FROM $TABLECALDATES
            where horaire_name = '$nom_hor'
             and c_id = $course_code";


             
         $res2 = api_sql_query($sql2);// or die(mysql_error());

// OR die("<p>Erreur Mysql2<br/>$sql4<br/>".mysql_error()."</p>");



            while($resulta = Database::fetch_array($res2)) {

                   $date=$resulta['date'];
                    $status=$resulta['status'];
                     $nom_hor=$resulta['horaire_name']; 
               $course_code =$resulta['c_id'];              


//on ins�re les donn�es dans l'horaire target
// Avec un replace, comme ca, si l'entr�e existe d�j�, on l'�crase...



 $sql4 = "REPLACE INTO $TABLECALDATES (date,status,horaire_name,c_id)
          VALUES('$date','$status','$nom_hor_target',' $course_code')     
          ";
            api_sql_query($sql4);// OR die("<p>Erreur Mysql2<br/>$sql4<br/>".mysql_error()."</p>");
 }

header('Location: index.php');

?>