<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default']['hostname'] = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.5.187)(PORT=1521))(CONNECT_DATA=(SID=EQUIPMENT)))";
$db['default']['username'] = "GCG"; //username database oracle kamu
$db['default']['password'] = "GeCeGe"; //password database oracle kamu
$db['default']['database'] = '';
$db['default']['dbdriver'] = 'oci8';  //secara default udah terisi mysql
// $db['default']['dbprefix'] = '';
// $db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;