<?php

include('lang.inc.php');
include('conf.inc.php');
include('mysql.inc.php');
include('functions.inc.php');

connect_db($mysql['hostname'], $mysql['user'], $mysql['pass'], $mysql['db']);

$cyear = escape_cyear();

calendar($cyear);

?>
