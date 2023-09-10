<?php
define('IN_ET', '1');
require_once('../define.inc.php');
$url=$_GET['u'];

if (!$url) {
    header("location: ".ET_URL."/index.php");
} else {
    header("location: ".ET_URL."/index.php?u=".$url);
}
?>