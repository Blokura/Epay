<?php
session_start();
define('ROOT_PATH', dirname(__FILE__));
require '../includes/ValidateCode.class.php';
$_vc = new ValidateCode();
$_vc->doimg();
$_SESSION['vc_code'] = $_vc->getCode();
?>