<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");

$form_id = intval($_GET['form']);
if ($form_id==0)
{
 Header("Location: forms.php");
}

if ($_GET['do']=='update')
{
 @mysql_query("UPDATE errors SET data = '".mysql_escape_string($_POST['error'])."' WHERE form_id = ".$form_id.";");
 Header("Location: formedit.php?form=".$form_id);
 exit();
}

$res = @mysql_query("SELECT data FROM errors WHERE form_id = ".$form_id.";");
$row = @mysql_fetch_row($res);

$fname = mysql_fetch_row(mysql_query("SELECT name FROM forms WHERE id = ".$form_id.";"));
$fname = $fname[0];

	 $t = new Template("tpl");
  	 $t->set_file(array("page" => $index2_tpl, "main"=>"errortpl.tpl"));		 
 	 $t->set_var("formsn","images/title-form.gif"); 

	  $t->set_var(array("uname"  => $uname,
					    "path"    => "<a href=\"forms.php\">Forms</a> / <a href=\"formedit.php?form=".$form_id."\"><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <span id=\"selected\">Error template</span>",
						"subheader_icon" => "images/error.png",
					   	"path_info" => "Error template"));
					   
	 $t->set_var(array("formid" => $form_id,
	 				   "errortpl"  => $row[0]));
	 
	 
	 $t->set_var($_LANG);
 	 $t->parse("OUT", array("main", "page"));
     $t->p("OUT");
?>