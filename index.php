<?php
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    die('require PHP > 5.4 !');
}
include("./includes/common.php");

$mod = isset($_GET['mod'])?$_GET['mod']:'index';
$loadfile = \lib\Template::load($mod);
include $loadfile;