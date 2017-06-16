<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");

$page_id = intval(implode("",@mysql_fetch_row(@mysql_query("SELECT page_id FROM codersess WHERE id = '".$_SESSION['codersess']."';"))));
if ($page_id<1)
{
Header("Location: forms.php");
exit();
}


$res = @mysql_query("SELECT name, form_id FROM pages WHERE id = ".$page_id.";");
$row = @mysql_fetch_row($res);
$form_id = $row[1];
$page_name = $row[0];

$fname = mysql_fetch_row(mysql_query("SELECT name FROM forms WHERE id = ".$form_id.";"));
$fname = $fname[0];

$t = new Template("tpl");
$t->set_file(array( "page" => $index2_tpl, "main"=>"addfield.tpl"));
$t->set_var(array("pageid" => $page_id,
				  "field"  => $field,
				  "pos"    => $pos,
				  "ftitle" => (empty($_POST['title']) ? $_GET['title'] : $_POST['title'])	));
				  
		   $t->set_var(array("title"     => $page_name,
							 "pagename"  => $page_name,
							 "uname"     => $uname,
	    					 "path"      => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <a href=\"formedit.php?form=".$form_id."\"><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <span id=\"selected\"><b>".$_LANG['msg_PAGE'].":</b> ".$page_name."</span>",
							 "subheader_icon" => "images/application_form.png",
					   		 "path_info" => $page_name));

   $res = @mysql_query("SELECT id, title FROM flds WHERE page_id = ".$page_id." ORDER BY title;");
   while ($row = @mysql_fetch_row($res))
   {
   	$flds .= "<option value=".$row[0].">".$row[1]."</option>\n";
   }
   
   $t->set_var("flds", $flds);
   
   $t->set_file(array("main1"=>"calc.tpl"));
   $t->set_block("main1","row","rows");
   

if ($_GET['do'] == 'add')
{
	$_POST['flds_id'][]		= $_POST['newfld'];
	$_POST['flds_title'][]	= implode(NULL,@mysql_fetch_row(@mysql_query("SELECT title FROM flds WHERE id = ".intval($_POST['newfld']).";")));
}

if (is_array($_POST['flds_title']))
{
	$i = 0;
	foreach ($_POST['flds_title'] as $field)	
	{
		$t->set_var(array(	"fld_id"	=> $_POST['flds_id'][$i],
							"fld_title"	=> $field,
							"class" => (is_int(++$l/2) ? " bgcolor=\"#FFFFFF\"" : " class=\"dataodd\"")));	
		
		$t->parse("rows", "row", true);
		$i++;
	}
}
	

$t->set_var($_LANG);   
$t->parse("out1", array("main1", "main")); 
$t->parse("OUT", array("out1","page"));
$t->p("OUT");

?>