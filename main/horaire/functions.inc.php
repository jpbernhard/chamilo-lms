<?php

 
function update_db($post, $cyear,$course_code)
 {

$TABLECALDATES = Database :: get_course_table(cal_dates);
$TABLECALHORAIRE  = Database :: get_course_table(cal_horaire);
$TABLECALTEMP  = Database :: get_course_table(cal_temp);
$my_user_id=api_get_user_id();

 
$sql6 = "SELECT * FROM $TABLECALTEMP 
 WHERE user = '$my_user_id'";
         $result6 = api_sql_query($sql6);// OR die(mysql_error());
        $data6 = Database::fetch_array($result6);
        global $hor_name2; 
 $hor_name2 = $data6["temp"];

  for ($i = 1; $i <= 12; $i++) {
    for ($y = 1; $y <= dni_mies($i,$cyear); $y++) {
      $mies = str_pad($i, 2, "0", STR_PAD_LEFT);
      $day = str_pad($y, 2, "0", STR_PAD_LEFT);
      $data = "$cyear-$mies-$day";
      
      if($post["g" . $data]==$data) {
        $sql = "SELECT status FROM $TABLECALDATES WHERE date = '" . $data . "'AND horaire_name = '$hor_name2'AND c_id = '$course_code'";
        $result = api_sql_query($sql);// OR die(mysql_error());

        if(Database::num_rows($result)) {
        
          if ($post['stan']=='C' or $post['stan']=='E')
                $sql="UPDATE $TABLECALDATES SET status='$post[stan]' WHERE date='$data'AND horaire_name = '$hor_name2'AND c_id = '$course_code' ";
          if ($post['stan']=='F')$sql ="DELETE FROM $TABLECALDATES WHERE date='$data'AND horaire_name = '$hor_name2'AND c_id = '$course_code'";
          $result = api_sql_query($sql);
        } else {
          if ($post['stan']=='C' or $post['stan']=='E')
          $sql ="insert into $TABLECALDATES (date, status, horaire_name,c_id) values ('$data', '$post[stan]','$hor_name2','$course_code')";
          if ($post['stan']!=='F')$result =api_sql_query($sql);
        }
      }
    }
  }

}

function escape_cyear() {
  (!isset($_GET['y'])
   || !is_numeric($_GET['y'])
   || !checkdate(1, 1, $_GET['y']))
    ? $cyear=date("Y") : $cyear=Database::escape_string($_GET['y']);
  return $cyear;
}

function dni_mies($mies,$cyear) {
  $dni = 31;
  while (!checkdate($mies, $dni, $cyear)) $dni--;
  return $dni;
}

function wyswietl_dni($mies,$cyear,$admin=0) {
$TABLECALDATES = Database :: get_course_table(cal_dates);
$TABLECALTEMP  = Database :: get_course_table(cal_temp);
$my_user_id=api_get_user_id();     
    $sql3 = "SELECT * FROM $TABLECALTEMP 
     WHERE user = '$my_user_id'";
    $result3 = api_sql_query($sql3);// OR die(mysql_error());
     $data3 = Database::fetch_array($result3);
    $hor_name3 = $data3["temp"];
    $cid2=$data3["c_id"];
  
  $sql = "SELECT date, status FROM $TABLECALDATES WHERE YEAR(date) = '$cyear' AND MONTH(date) = '$mies'AND horaire_name= '$hor_name3'AND c_id = '$cid2' ";
  $result = api_sql_query($sql);// OR die(mysql_error());
  $dates = array();
  while ($row = Database::fetch_array($result, MYSQL_NUM))$dates[$row[0]] = $row[1];
  Database::free_result($result);

  for ($i = 1; $i <= dni_mies($mies,$cyear); $i++) {
    $mies = str_pad($mies, 2, "0", STR_PAD_LEFT);
    $day = str_pad($i, 2, "0", STR_PAD_LEFT);
    $data = "$cyear-$mies-$day";

    if(isset($dates[$data])) {
      if($dates[$data] == "C")$tdcolor="#FF0000";
      if($dates[$data] == "E")$tdcolor="#FFA042";
    } else $tdcolor="#00CC00";

    $td = "<td id=\"$data\" style=\"width: 18px; text-align: center;border : 1px solid #000000; background: $tdcolor; font-size: 15px; \"";
    if ($admin)$td .= " onclick=\"daty(this.id,'$tdcolor')\" ";
    $td .= ">";

    if ($admin) {
      $hidden_form="<input type=\"hidden\" id=\"g$data\" name=\"g$data\" value=\"\">";
      (isset($html)) ? $html = $html . $td . $hidden_form . $i . "</td>"
                     : $html = $td . $hidden_form . $i . "</td>";
    } else {
      (isset($html)) ? $html = $html . $td . $i . "</td>"
                     : $html = $td . $i . "</td>";
    }
    unset($td);
  }
  return $html;
}

function calendar($cyear, $admin=0) {
 
  global $lang, $conf;

  $ym = $cyear - 1;
  $yp = $cyear + 1;

  echo('
  <table id="calendar" style="font-family: Verdana; border: 0px; padding: 1px;">
    <tr>
      <td>&nbsp;</td>
      <td colspan="31">
      <div style="margin-left: 220px; float: left; font-weight: bold;">
          <a href="' . basename($_SERVER['PHP_SELF']) . '?y=' . $ym . '"><img border=0 src=larrow.gif></a>
              '.$lang['year'].' '.$cyear.'
          <a href="' . basename($_SERVER['PHP_SELF']) . '?y=' . $yp . '"><img border=0 src=rarrow.gif></a>
      </div>
  ');
    echo'<td>&nbsp;</td>';   

  echo('
      </td>
    </tr>
  ');

  $months = explode(",", $lang['months']);
  $months = array_slice($months, 0, 12);
 
foreach($months as $month) {
    (!isset($counter)) ? $counter="1" : $counter++;
    echo("
    <tr>
      <td style=\"font-size: 10px; font-weight: bold;\">$month</td>
      " . wyswietl_dni($counter,$cyear,$admin) . "
    </tr>
    ");
  }

  $states = explode(",", $lang['states']);
  echo('
    <tr>
      <td colspan=32 style="text-align: center; font-size: 13px; font-weight: bold;">
        <span style="color: #FF0000;">');
  echo '<INPUT TYPE="radio" NAME="stan" VALUE="C">';
  echo($states[0]."</span>
        <span style=\"color: #FFA042;\">");
  echo '<INPUT TYPE="radio" NAME="stan" VALUE="E">';
  echo($states[1]."</span>
        <span style=\"color: #00CC00;\">");
  echo '<INPUT TYPE="radio" NAME="stan" VALUE="F">';
  echo($states[2]."</span>
      </td>
    </tr>
  ");
 echo('
    <tr>
      <td colspan="32" style="text-align: center;">
        <input style="font-size:8pt; border : 1px solid #90A3A9; width:125px; background-color:#f3f3f3;" type="submit" value="Valider" name="Submit" />
      </td>
    </tr>
  ');
  echo('
  </table>
  ');
}

function is_active($page, $get) {
  if ($page == $get) {
    print ' id="current"';
  }
}

?>
