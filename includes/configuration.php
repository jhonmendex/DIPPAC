<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
$config = Config::singleton();
$config->set('dbtype', 'postgres');
$config->set('dbport', '5432');
$config->set('dbhost', 'localhost'); 
$config->set('dbname', 'dippac');
$config->set('dbuser', 'dippac');
$config->set('dbpass', 'Inicio.123'); 

$config->set('lang', 'es');
$config->set('mail', 'jhon.mendez@docentes.umb.edu.co');
$config->set('company', 'UMB');
$config->set('direccion', '');
$config->set('telefono', '');
$config->set('nit', '');
date_default_timezone_set('America/Panama');
?>
