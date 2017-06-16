<?php 
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/generate.inc.php");
require_once("./db.conf.php");

$log = intval($_GET['log']);
$id  = intval($_GET['id']);

if ((($id < 1)&&($_GET['do'] != 'group'))||($log < 1)) { header("Location: forms.php"); exit(); }

$res = @mysql_query("SELECT form_id FROM dbs WHERE id = ".$log.";");
$row = @mysql_fetch_row($res);
$form_id = $row[0];

if ($_GET['do'] == 'update')
{
	$res	= @mysql_query("SELECT tbl FROM dbs WHERE id = ".$log.";");
	$row	= @mysql_fetch_row($res);
	$tbl	= $row[0];
	
	
	$update_sql = "UPDATE ".$tbl." SET ";
	foreach ($_POST as $key => $val)
	{
		if (substr($key,0,1) == 'f')
			$update_sql .= $key." = '".@mysql_escape_string($val)."', ";
	}
	
	$update_sql .= "ip = '".$_POST['ip']."', referer='".$_POST['referer']."', date='".$_POST['date']."', time='".$_POST['time']."', ";
	$update_sql .= "comments = '".mysql_escape_string($_POST['comments'])."' WHERE id = ".$id.";";
	
	@mysql_query($update_sql);
	header("Location: browse.php?form=".$form_id."&id=".$log);
	exit();
}

if ($_GET['do'] == 'comment')
{
	$_GET['comment'] = ereg_replace('%([[:alnum:]]{2})', '&#x\1;',ereg_replace('%u0([[:alnum:]]{3})', '&#x\1;',$_GET['comment']));


	$res	= @mysql_query("SELECT tbl FROM dbs WHERE id = ".$log.";");
	$row	= @mysql_fetch_row($res);
	$tbl	= $row[0];

	@mysql_query("UPDATE ".$tbl." SET comments = '".mysql_escape_string($_GET['comment'])."' WHERE id=".$id.";");
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$_GET['ref']."\">";
	exit();
}

if ($_GET['do'] == 'group')
{
	$_GET['comment'] = ereg_replace('%([[:alnum:]]{2})', '&#x\1;',ereg_replace('%u0([[:alnum:]]{3})', '&#x\1;',$_GET['comment']));
	if (is_array($_POST['chk']))
	{
		$res	= @mysql_query("SELECT tbl FROM dbs WHERE id = ".$log.";");
		$row	= @mysql_fetch_row($res);
		$tbl	= $row[0];
		
		foreach ($_POST['chk'] as $id)
		{
			@mysql_query("UPDATE ".$tbl." SET comments = '".mysql_escape_string($_GET['comment'])."' WHERE id=".$id.";");
		}

		echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$_GET['ref']."\">";
		exit();
	}
}

$t = new Template("tpl");
$t->set_file(array("page" => $index2_tpl, "main"=>"logedit.tpl"));
$t->set_block("main","row","rows");
$fname  = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM forms WHERE id = ".$form_id.";")));
$lname  = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM dbs WHERE id = ".$log.";")));

$t->set_var(array(	"uname"		=> $uname,
					"path"      => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <a href=\"formedit.php?form=".$form_id."\"><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <a href=\"db.php?do=edit&form=".$form_id."&db=".$log."\"><b>".$_LANG['msg_LOG'].":</b> ".$lname."</a> / <span id=\"selected\">Record preferences</span>",
					"subheader_icon" => "images/application_form.png",
					"path_info" => "Log edit"));
					
	$table	= array();

	$res	= @mysql_query("SELECT tbl, flds, show_ip, show_ref, show_date, show_date, show_time FROM dbs WHERE id = ".$log.";");
	$row	= @mysql_fetch_row($res);
	
	$tbl	= $row[0];
	$fields	= empty($row[1]) ? array() : explode("|",$row[1]);

	foreach ($fields AS $field)
	{
		$res = @mysql_query("SELECT title FROM flds WHERE id = '".$field."';");
		$row = @mysql_fetch_row($res);
		
		$record				= array();
		$record['title']	= $row[0];
		
		$table[]			= $record;
	}

	
	$res2 = @mysql_query("SELECT * FROM ".$tbl." WHERE id = ".$id.";");
	$row2 = @mysql_fetch_array($res2);


	for($i=0, $k=count($table); $i<$k; $i++)
	{
		$table[$i]['value']	= $row2['f'.$i];
		$table[$i]['name']	= 'f'.$i;

		$t->set_var($table[$i]);
		$t->parse("rows", "row", true);
	}
	
	/** Real-time date **/
	if ($row[2]>0)	{
		$t->set_var(array("title"=>"IP Address", "name"=>"ip", "value"=>$row2['ip']));
		$t->parse("rows", "row", true);
	}
	if ($row[3]>0)	{
		$t->set_var(array("title"=>"HTTP Referer", "name"=>"referer", "value"=>$row2['referer']));
		$t->parse("rows", "row", true);
	}
	if ($row[4]>0)	{
		$t->set_var(array("title"=>"Date", "name"=>"date", "value"=>$row2['date']));
		$t->parse("rows", "row", true);
	}
	if ($row[5]>0)	{
		$t->set_var(array("title"=>"Time", "name"=>"time", "value"=>$row2['time']));
		$t->parse("rows", "row", true);
	}
	/***********************/
	
		
	$t->set_var("log", $log);
	$t->set_var("form_id", $form_id);
	$t->set_var("id",  $id);
	$t->set_var("comments",  nl2br(str_replace("\"","&quot;",$row['comments'])));
	$t->set_var($_LANG);
	$t->parse("OUT", array("main","page"));
	$t->p("OUT");
?>