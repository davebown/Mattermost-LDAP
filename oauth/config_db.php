<?php

$port  	  = intval(getenv('DB_PORT'));
$host  	  = getenv('DB_HOST');
$name  	  = getenv('DB_NAME');
$type	  = "pgsql";
$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$dsn	  = $type . ":dbname=" . $name . ";host=" . $host . ";port=" . $port; 

/* Uncomment the line below to set date.timezone to avoid E.Notice raise by strtotime() (in Pdo.php)
 * If date.timezone is not defined in php.ini or with this function, Mattermost could return a bad token request error
*/
date_default_timezone_set ('UTC');