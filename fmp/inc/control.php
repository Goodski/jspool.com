<?php
session_set_cookie_params(0);
session_start(); 
if (!isset($_SESSION['auth'])) {
   header("Location: index.php");
   exit();
}
else
{
 $uid = intval($_SESSION['auth']);
 $rus = @mysql_fetch_row(@mysql_query("SELECT login, email, tips FROM users WHERE id = ".$uid.";"));

///////////////////
require_once("lang/english.lang.php");
 
 $uname   = $rus[0];
 $uemail  = $rus[1];
 $index_tpl = ($rus[2] == 1) ? "index.tpl" : "index_notips.tpl";
 $index2_tpl = ($rus[2] == 1) ? "index2.tpl" : "index2_notips.tpl";
}
?>