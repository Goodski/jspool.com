<?php
error_reporting(0);
@session_start();
@include("inc/init.php");
if (isset($_SESSION['codersess']))
{
 @mysql_query("DELETE FROM codersess WHERE id = '".$_SESSION['codersess']."';");
 @mysql_query("DELETE FROM codertmp WHERE sid = '".$_SESSION['codersess']."';");
 unset($_SESSION['codersess']);
}

@session_destroy();
@header("Location: ./");
?>