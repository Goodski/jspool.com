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

$pos = intval($_GET['pos']);
$field = intval($_GET['field']);
   $fnum = intval($_POST['field_num']);
   $fnum = ($fnum == 0) ? intval($_GET['field_num']) : $fnum;


$size ="<tr><td><b>Size:</b></td><td align=\"left\">".(empty($_POST['size']) ? $_GET['size'] : $_POST['size'])."</td></tr>";

$default = (($field==6)||($field==5)) ? '<th><a id="notselected">Default</a></th>' : '';   

$res = @mysql_query("SELECT name, form_id FROM pages WHERE id = ".$page_id.";");
$row = @mysql_fetch_row($res);
$form_id = $row[1];
$page_name = $row[0];

$fname = mysql_fetch_row(mysql_query("SELECT name FROM forms WHERE id = ".$form_id.";"));
$fname = $fname[0];

$t = new Template("tpl");
$t->set_file(array( "page" => $index2_tpl, "main"=>"addfield.tpl"));
$t->set_var(array("pageid" => $page_id,
				  "cancel_red" => $is_thx ? "formedit.php?form=".$form_id : "coder.php?page=".$page_id,
				  "field"  => $field,
				  "pos"    => $pos,
				  "ftitle" => (empty($_POST['title']) ? $_GET['title'] : $_POST['title']),
				  "fname"  => (empty($_POST['field_name']) ? $_GET['field_name'] : $_POST['field_name']),
				  "req"    => (empty($_POST['req']) ? $_GET['req'] : $_POST['req']),
				  "field_num" => $fnum+1,
				  "size"   => (($field==4) ? $size : ""),
				  "sizeval" => (empty($_POST['size']) ? $_GET['size'] : $_POST['size']),
				  "default" => $default,
				  "descr"     => $_LANG['msg_draw_second_page_tip']));
				  
		   $t->set_var(array("title"     => $page_name,
							 "pagename"  => $page_name,
							 "uname"     => $uname,
	    					 "path"      => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <a href=\"formedit.php?form=".$form_id."\"><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <span id=\"selected\"><b>".$_LANG['msg_PAGE'].":</b> ".$page_name."</span>",
							 "subheader_icon" => "images/application_form.png",
					   		 "path_info" => $page_name));

   $t->set_file(array("main1"=>"fields.tpl"));
   $t->set_block("main1","row","rows");
   

   
   for($i=0;$i<$fnum;$i++)
   {
   $def = ($field==6) ? '<td align="center"><input type="radio" name="default" value="'.$i.'"></td>' : "";
   $def = ($field==5) ? '<td align="center"><a href="#"></A><input type="checkbox" name="default[]" value="'.$i.'"></td>' : $def;
   $t->set_var(array("num"=>($i+1),
                     "class" => (is_int(++$l/2) ? " bgcolor=\"#FFFFFF\"" : " class=\"dataodd\""),
					 "capval" => $_POST['caparray'][$i],
					 "valval" => $_POST['valarray'][$i],
					 "def"    => $def,
					 "tabindex" => ($i+1)));
   $t->parse("rows","row",true);
   }

$t->set_var($_LANG);   
$t->parse("out1", array("main1", "main")); 
$t->parse("OUT", array("out1","page"));
$t->p("OUT");

?>