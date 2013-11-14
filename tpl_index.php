<?php
require "include/common.php";

$smarty=new WSmarty();
$smarty->set('title', 'We Do Cycle Count');

$smarty->set('data',Menu::ReadMenuFile());
$smarty->show();
//echo "Smarty";
?>
