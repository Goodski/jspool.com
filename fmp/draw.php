<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");

$res = @mysql_query("SELECT page_id FROM codersess WHERE id = '".$_SESSION['codersess']."';");
$row = @mysql_fetch_row($res);
$page_id = intval($row[0]);

if (($page_id<1)&&($_GET['do'] != 'edit'))
{
Header("Location: forms.php");
exit();
}

$pos = intval($_GET['pos']);

$res = @mysql_query("SELECT COUNT(*) FROM codertmp WHERE page_id = ".$page_id." && sid = '".$_SESSION['codersess']."';");
$row = @mysql_fetch_row($res);

$pos = ($row[0]==0) ? 1 : $pos;

if (($pos<1)&&($_GET['do'] != 'edit')&&($_GET['field'] != CALCULATION))
{
Header("Location: selpos.php?page=".$page_id."&field=".$_GET['field']);
exit();
}

$field = intval($_GET['field']);
$do    = ($_GET['do']=='edit') ? 'update&id='.$_GET['id'] : 'add';

$res = @mysql_query("SELECT name, form_id FROM pages WHERE id = ".$page_id.";");
$row = @mysql_fetch_row($res);
$page_name = $row[0];

$res_f = @mysql_query("SELECT id FROM pages WHERE form_id = ".$row[1]." ORDER BY pos;");
while($row_f = @mysql_fetch_row($res_f))
{

$sql = ($row_f[0]==$page_id) ? "SELECT name FROM codertmp WHERE page_id = ".$row_f[0]." && type <> 7 && sid = '".$_SESSION['codersess']."' ORDER BY pos" : "SELECT name FROM flds WHERE page_id = ".$row_f[0]." && type <> 7 ORDER BY pos";
$res = @mysql_query($sql);
while ($row = @mysql_fetch_row($res))
{
 $used_fields .= "<option value='".$row[0]."'>".$row[0]."</option>\n";
}

}

$res = @mysql_query("SELECT name, form_id, thx FROM pages WHERE id = ".$page_id.";");
$row = @mysql_fetch_row($res);
$form_id = $row[1];
$page_name = $row[0];
$is_thx = ($row[2] == 1);

$fname = mysql_fetch_row(mysql_query("SELECT name FROM forms WHERE id = ".$form_id.";"));
$fname = $fname[0];

$t = new Template("tpl");
$t->set_file(array( "page" => $index2_tpl, "main"=> "addfield.tpl"));
$t->set_var(array("pageid" => $page_id,
				  "cancel_red"=> $is_thx ? "formedit.php?form=".$form_id : "coder.php?page=".$page_id,
				  "pagename" => $page_name,
				  "field"  => $field,
				  "pos"    => $pos,
				  "usedf"  => $used_fields));
				  
		   $t->set_var(array("pagename"  => $page_name,
							 "uname"     => $uname,
	    					 "path"      => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <a href=\"formedit.php?form=".$form_id."\"><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <span id=\"selected\"><b>".$_LANG['msg_PAGE'].":</b> ".$page_name."</span>",
							 "subheader_icon" => "images/application_form.png",
					   		 "path_info" => $page_name));


switch ($field)
{
 case CAPTCHA:
  $t->set_file(array( "main1"=>"captcha.tpl"));
  $t->set_var(array("do"     => $do,
					"descr"     => $_LANG['msg_draw_captcha_tip']));
 break;
 
 case TEXT:
  $t->set_file(array( "main1"=>"textfield.tpl"));
  $t->set_var(array("do"     => $do,
					"descr"     => $_LANG['msg_draw_textfield_tip']));
 break;
 
 case SELECT:
  $t->set_file(array( "main1"=>"select.tpl"));
  $t->set_var(array( "descr"     => $_LANG['msg_draw_select_tip']));
 break;
 
 case BROWSE:
  $t->set_file(array( "main1"=>"attach.tpl"));
  $t->set_var(array(  "do"   => $do,
					"descr"     => $_LANG['msg_draw_browse_tip']));
 break;
 
 case TEXTAREA:
  $t->set_file(array( "main1"=>"textarea.tpl"));
  $t->set_var(array("do"    => $do,
					"descr"     => $_LANG['msg_draw_textarea_tip']));
 break;

 case MULTILIST:
  $t->set_file(array( "main1"=>"multiple.tpl"));
  $t->set_var(array( "descr"     => $_LANG['msg_draw_multilist_tip']));
 break; 
 
 case CHECKBOX:
  $t->set_file(array( "main1"=>"checkbox.tpl"));
  $t->set_var(array( "descr"     => $_LANG['msg_draw_checkbox_tip']));
 break;
 
 case RADIO:
  $t->set_file(array( "main1"=>"radio.tpl"));
  $t->set_var(array( "descr"     => $_LANG['msg_draw_radio_tip']));
 break;
 
 case LABEL:
   $t->set_file(array("main1"=>"label.tpl"));
   $t->set_var(array("do" => $do,
					"descr"     => $_LANG['msg_draw_label_tip']));
 break;
 
 case CALC_OUT:
  $t->set_file(array( "main1"=>"calc.tpl"));
  
  $res = @mysql_query("SELECT t1.id, t1.title FROM flds AS t1, pages AS t2 WHERE t1.type = 8 && t1.page_id = t2.id && t2.form_id = ".$form_id." ORDER BY t1.page_id, t1.title");
  //echo "SELECT t1.id, t1.title FROM flds AS t1, forms pages AS t2 WHERE t1.type = 8 && t1.page_id = t2.id && t2.form_id = ".$form_id." ORDER BY t1.page_id, t1.title";
  while($row = @mysql_fetch_row($res))
  {
  	$calcs .= "<option value=".$row[0].">".$row[1]."</option>\n";
  }
  
  $res = @mysql_query("SELECT id, title FROM codertmp WHERE type = 8 && sid = '".$_SESSION."' ORDER BY title");
  while($row = @mysql_fetch_row($res))
  {
  	$calcs .= "<option value=".$row[0].">".$row[1]."</option>\n";
  }
    
  $t->set_var(array("do"     => $do,
  					"calcs"	 => $calcs,
					"descr"     => $_LANG['msg_draw_calcout_tip']));
  break;
   
 case CALCULATION:
   $t->set_file(array("main1"=>"addcalc.tpl"));
   
   $t->set_block("main1","row","rows");
   
   $letter = "A";
   $calc_flds = array();
   
   $sql = "SELECT t1.id, t1.title FROM flds as t1, pages as t2 WHERE t1.page_id = t2.id && t2.form_id = ".$form_id." && t2.pos < ".intval(@implode(NULL, @mysql_fetch_row(@mysql_query("SELECT pos FROM pages WHERE id = ".$page_id.";"))))." && (t1.valid = 2 || t1.type = 8) ORDER BY t2.pos, t1.pos;";
   $res = @mysql_query($sql);
   while($row = @mysql_fetch_row($res))
   {
	if ($_GET['id'] != $row[0])
	{ 	
	$t->set_var(array(	"fld_id"	=> $row[0],
						"fld_title"	=> $row[1],
						"letter"	=> $letter,
						"class" 	=> (is_int(++$l/2) ? " bgcolor=\"#FFFFFF\"" : " class=\"dataodd\"")));	
							
   	$t->parse("rows", "row", true);
   
   	$calc_flds[$row[0]] = $letter;
   	
   	$letter++;
	}
   }

   
   $sql = "SELECT id, title FROM codertmp WHERE (valid = 2 || valid = 3 || type = 8) && sid = '".$_SESSION['codersess']."' ORDER BY pos;";
   $res = @mysql_query($sql);
   while($row = @mysql_fetch_row($res))
   {
	if ($_GET['id'] != $row[0])
	{ 	
	$t->set_var(array(	"fld_id"	=> $row[0],
						"fld_title"	=> $row[1],
						"letter"	=> $letter,
						"class" 	=> (is_int(++$l/2) ? " bgcolor=\"#FFFFFF\"" : " class=\"dataodd\"")));	
							
   	$t->parse("rows", "row", true);
   
   	$calc_flds[$row[0]] = $letter;
   	
   	$letter++;
	}
   }

   $t->set_var(array("do" => $do,
						"descr"     => $_LANG['msg_draw_calculation_tip']));
 break;
 
 default:
  $t->set_file(array( "main1"=>"label.tpl"));
  $t->set_var(array("do"     => $do,
						"descr"     => $_LANG['msg_draw_calculation_tip']));
 break;
}

if ($_GET['do']=='edit')
{
 $res = @mysql_query("SELECT * FROM codertmp WHERE id = '".mysql_escape_string($_GET['id'])."' && sid = '".$_SESSION['codersess']."';");
 $row = @mysql_fetch_array($res);
 
 $t->set_var(array("ftitle"             => $row['title'],
                   "fname"              => $row['name'],
				   "fvals"				=> addslashes($row['vals']),
				   "freq"               => ($row['req']==1) ? " checked" : "",
				   "fval".$row['valid'] => " checked"));

 if ($field == CALCULATION)
 {
 	$formula = @implode(NULL, @mysql_fetch_row(@mysql_query("SELECT vals FROM codertmp WHERE id = '".mysql_escape_string($_GET['id'])."' && sid = '".$_SESSION['codersess']."';")));
 	
 	
 	foreach ($calc_flds as $c_id => $c_letter)
 	{
 		$formula = str_replace("||".$c_id."||", $c_letter, $formula);
 	}
 	
 	$t->set_var("formula", $formula);
 }
 
}
else
{
 $t->set_var(array("fval0" => ' checked'));
}

$t->set_var($_LANG);

$t->parse("out1", array("main1", "main")); 
$t->parse("OUT", array("out1","page"));
$t->p("OUT");

?>
