<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/draw.php");

$page_id = intval(implode("",@mysql_fetch_row(@mysql_query("SELECT page_id FROM codersess WHERE id = '".$_SESSION['codersess']."';"))));

$field   = intval($_GET['field']);
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
  	 $t->set_file(array("page" => $index2_tpl, "main"=>"genformain.tpl"));		 
     $t->set_block("main", "calc_row", "calc_rows");
     $t->set_var("formsn","images/title-generateform.gif"); 
		   $t->set_var(array("page_name"  => $page_name,
		   					 "pagename"  => $page_name,
							 "uname"     => $uname,
	    					 "path"      => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <a href=\"formedit.php?form=".$form_id."\"><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <span id=\"selected\"><b>".$_LANG['msg_PAGE'].":</b> ".$page_name."</span>",
							 "subheader_icon" => "images/application_form.png",
					   		 "path_info" => $page_name,
							"descr"     => $_LANG['msg_select_position_tip']));


	 $res = @mysql_query("SELECT * FROM codertmp WHERE page_id = ".$page_id." && type <> 8 && sid = '".$_SESSION['codersess']."' ORDER BY pos;");
 	 $fields .= '<tr><td align="center" colspan=2>'."<a class='nlink' href='draw.php?page=".$page_id."&pos=".($row['pos']+1)."&field=".$field."'>".$_LANG['msg_insert_here']."</a>".'</td><tr>'."\n";
	  while ($row = @mysql_fetch_array($res))
	  {
	    switch ($row['type'])
		{
		  case TEXT:
		  	$fields .= DrawTextfield($row);
			break;
		  case CAPTCHA:
		  	$fields .= DrawCaptchafield($row);
			break;
		  case SELECT:
		    $fields .= DrawSelectField($row);
			break;
		  case BROWSE:
		    $fields .= DrawBrowseField($row);
			break;
		  case TEXTAREA:
		    $fields .= DrawTextarea($row);
			break;
		  case MULTILIST:
		    $fields .= DrawMultilist($row);
			break;
		  case CHECKBOX:
		    $fields .= DrawCheckbox($row);
			break;
		  case RADIO:
		    $fields .= DrawRadiobox($row);
			break;
		  case LABEL:
		    $fields .= DrawLabel($row);
			break;
		  case CALC_OUT:
		  	$fields .= DrawCalculation($row);
		  	break;
		}
 	 $fields .= '<tr><td align="center" colspan=2>'."<a class='nlink' href='draw.php?page=".$page_id."&pos=".($row['pos']+1)."&field=".$field."'>".$_LANG['msg_insert_here']."</a>".'</td><tr>'."\n";
	}
	 
	 $res = @mysql_query("SELECT id, title FROM codertmp WHERE type = 8 && sid = '".$_SESSION['codersess']."' ORDER BY title");
	 while ($row = @mysql_fetch_row($res))
	 {
	 	$t->set_var(array("calc_id"		=> $row[0],
	 					  "calc_title"	=> $row[1],
	 					  "class" 	=> (is_int(++$l/2) ? " bgcolor=\"#FFFFFF\"" : " class=\"dataodd\"")));	
	 	
	 	$t->parse("calc_rows", "calc_row", true);
	 }
	 
	 $t->set_var($_LANG);
	 $t->set_var(array("pageid" => $page_id,
	 				   "fields" => $fields));
	 $t->parse("OUT", array("main", "page"));
     $t->p("OUT");

?>
