<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");

$t = new Template("tpl");
$t->set_file("page","splash.tpl");

$t->set_var(array("sites" => intval(@implode("",mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM sites WHERE uid = ".$uid.";")))),
				  "forms" => intval(@implode(NULL,@mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM forms WHERE uid = ".$uid.";")))),
				  "storages" => intval(mysql_num_rows((@mysql_query("SELECT dbs.id as 'log_id' FROM dbs, forms WHERE dbs.form_id = forms.id && forms.uid = ".$uid.";")))),
"uname"	=> $uname));

$t->set_var($_LANG);
$t->parse("OUT", "page");
$t->p("OUT");

?>