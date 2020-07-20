<?php
// Version
define('VERSION', '2.3.0.2.3');
//if($_SERVER['REMOTE_ADDR'] == '37.115.242.204' ||  $_SERVER['REMOTE_ADDR'] == '185.181.19.175'){
//    
//}else{
//    echo 'Извините за неудобства. Работа сайта будет восстановлена в течении часа.';
//    die;
//}

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}


// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('catalog');

//
//    function micro(){
//                $t=microtime();
//                $t=explode(' ',$t);
//                $res['sec']=(float)$t[1];
//                $res['mcsec']=(float)$t[0];
//                $res=$res['sec']+$res['mcsec'];
//                return $res;
//        }