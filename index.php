<?php
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 10:52
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Константы:
define('ROOT', dirname(__FILE__));


require_once 'vendor/autoload.php';

$application1 = \App\Components\Application::getInstance();
$application1 -> run();