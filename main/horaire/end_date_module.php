<?php
//pour la date de fin de chaque module Par André Boivin
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




$view = (isset($_REQUEST['view'])?$_REQUEST['view']:'');

$nameTools = get_lang('ToolIndividualise');
 Display::display_header($nameTools, 'ToolIndividualise');


//on cherche les données de config
 $Req1 = "SELECT *
	FROM c_cal_set_module
  WHERE c_id = '$course_code'
 
 	";
    $res = api_sql_query($Req1);// or die(mysql_error());

    $result = Database::fetch_array($res);
    $id=$result['id'];
    $c_id=$result['c_id'];
    
    //On cherche le calendrier pour ce user dans ce cours, groupe
$sql = "SELECT * 
		FROM user
		WHERE user_id = '$student_id'
		";
        $result = api_sql_query($sql);
        $horaire_id = Database::fetch_array($result) ;
        $nom_hor = $horaire_id ['official_code'] ;
$course_code_real = $_course['real_id'];        
//avec le nom d'horaire= official code, on trouve le nombre de jour a faire
$sql = "SELECT * FROM $TABLECALHORAIRE
            where name = '$nom_hor'
             and c_id = '$course_code_real' ";  
             
         $res = api_sql_query($sql);// or die(mysql_error());
        $resulta = Database::fetch_array($res);
        
        $num_hours=$resulta['num_hours'];        
        $num_minute=$resulta['num_minute']; 
if ($num_minute=='0'){
$num_minute = '1' ;
}
$minute_mod=  $num_hours * 60 ;       
$num_days = $minute_mod / $num_minute ;      



// affichage des jours complétés dans les parcours l'élève


       
 //pours chaque cours dans lequel il est inscrit, on cherche les jours complétés
   
?><p></p>
<?php
 
  $Req1 = "SELECT *
	FROM c_lp_view
  WHERE user_id  =  '$user_c_id'
   AND c_id = '$c_id'
 	";
    $res = api_sql_query($Req1);// or die(mysql_error());

    while($result = Database::fetch_array($res)) {
    $lp_id=$result['lp_id'];
    $lp_id_view=$result['id'];
    $c_id_view = $result['c_id'];
   
		        $Req2 = "SELECT id, lp_id ,title ,item_type
				    FROM  c_lp_item
   			     WHERE lp_id =  '$lp_id'
   			     AND title LIKE '(+)%'
   			     AND c_id = '$c_id_view'
   			     AND item_type = 'document'
           	";
             $res2 = api_sql_query($Req2);// or die(mysql_error());

    			   while($resulta = Database::fetch_array($res2)) {
    			     $lp_item_id = $resulta['id'];
    			                   
                $Req3 = " SELECT Max(id)
                FROM  c_lp_item_view
   			   		   WHERE  lp_item_id =  '$lp_item_id'
   			   		   AND lp_view_id =  '$lp_id_view'
   			   		    AND c_id = '$c_id_view'
   			     		 AND status =  'completed'
   			     		 ";
                  $res3 = api_sql_query($Req3);// or die(mysql_error());

    		          while($resul = Database::fetch_array($res3)) { 
    				      $max = $resul['0'];
    			                                 
			                    $Req4= "SELECT COUNT( id )
						              FROM  c_lp_item_view
   			   		             WHERE  id = '$max'
                            AND c_id = '$c_id_view'    
           			            ";
                		        $res4 = api_sql_query($Req4);// or die(mysql_error());

    					               while ($resultat = Database::fetch_array($res4)){
						                
                             $Total= $Total+$resultat[0];                  
 }  }  }    } 
 
 ?>
