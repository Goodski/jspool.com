<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");

$page_id = intval(implode("",@mysql_fetch_row(@mysql_query("SELECT page_id FROM codersess WHERE id = '".$_SESSION['codersess']."';"))));
$id = mysql_escape_string($_GET['id']);

if ($page_id<1)
{
Header("Location: forms.php");
exit();
}

if ($_GET['do']=='delete')
{
$res = @mysql_query("SELECT vals FROM codertmp WHERE id = '".$id."' && sid = '".$_SESSION['codersess']."';");
$row = @mysql_fetch_array($res);

$opts = explode("\r\n",$row[0]);

$j = 1;
$newvals = "";
foreach ($opts AS $opt)
{
 if($_GET['option'] != $j)
 {
  $newvals .= $opt."\r\n";
 }
 $j++;
}

@mysql_query("UPDATE codertmp SET vals = '".mysql_escape_string(trim($newvals))."' WHERE id = '".$id."' && sid = '".$_SESSION['codersess']."';") ;
}

if ($_GET['do'] == 'moveup')
{
$on = intval($_GET['option']);
$res = @mysql_query("SELECT vals FROM codertmp WHERE id = '".$id."' && sid = '".$_SESSION['codersess']."';");
$row = @mysql_fetch_array($res);
$opts = explode("\r\n",$row[0]);
 if ($on>1)
 {
  $tmp = $opts[$on-2];
  $opts[$on-2] = $opts[$on-1];
  $opts[$on-1] = $tmp;
 }

 $newvals = implode("\r\n", $opts);
@mysql_query("UPDATE codertmp SET vals = '".mysql_escape_string(trim($newvals))."' WHERE id = '".$id."' && sid = '".$_SESSION['codersess']."';") ;
}


if ($_GET['do'] == 'movedown')
{
$on  = intval($_GET['option']);
$res = @mysql_query("SELECT vals FROM codertmp WHERE id = '".$id."' && sid = '".$_SESSION['codersess']."';");
$row = @mysql_fetch_array($res);
$opts = explode("\r\n",$row[0]);
 if ($on<count($opts))
 {
  $tmp = $opts[$on];
  $opts[$on] = $opts[$on-1];
  $opts[$on-1] = $tmp;
 }

 $newvals = implode("\r\n", $opts);
@mysql_query("UPDATE codertmp SET vals = '".mysql_escape_string(trim($newvals))."' WHERE id = '".$id."' && sid = '".$_SESSION['codersess']."';") ;
}

$res = @mysql_query("SELECT name, form_id FROM pages WHERE id = ".$page_id.";");
$row = @mysql_fetch_row($res);
$form_id = $row[1];
$page_name = $row[0];

$fname = mysql_fetch_row(mysql_query("SELECT name FROM forms WHERE id = ".$form_id.";"));
$fname = $fname[0];

$res = @mysql_query("SELECT * FROM codertmp WHERE id = '".$id."' && sid = '".$_SESSION['codersess']."';");
$row = @mysql_fetch_array($res);

$size   = ($row['type'] == MULTILIST) ? "<tr><td><b>".$_LANG['msg_opts_num'].":</b></td><td align=\"left\"><input type=\"text\" name=\"size\" size=\"10\" value=\"".$row['size']."\"></td></tr>" : "";

$checked = ($row['req'] == 1) ? " checked" : "";
//$rfield = ($row['type'] != CHECKBOX) ? "<tr><td><b>".$_LANG['msg_advance'].":</b></td><td align=\"left\"><input type=\"checkbox\" name=\"req\" size=\"10\" value=\"1\"".$checked."> ".$_LANG['msg_fld_req']."</td></tr>" : "";
$rfield =  "<tr><td><b>".$_LANG['msg_advance'].":</b></td><td align=\"left\"><input type=\"checkbox\" name=\"req\" size=\"10\" value=\"1\"".$checked."> ".$_LANG['msg_fld_req']."</td></tr>";

$default = (($row['type']==6)||($row['type']==5)) ? '<th><a id="notselected">Default</a></th>' : '';
$t = new Template("tpl");
$t->set_file(array( "page" => $index2_tpl, "main"=>"addfield.tpl"));
$t->set_var(array("id" => $id,
				  "pageid" => $row['page_id'],
				  "cancel_red" => $is_thx ? "formedit.php?form=".$form_id : "coder.php?page=".$page_id,
				  "pagename" => $page_name,
				  "subf"   => $lang[28],
				  "field"  => $row['type'],
				  "ftitle" => $row['title'],
				  "fname"  => $row['name'],
				  "rfield" => $rfield,
				  "size"   => $size,
				  "default" => $default));


				  
		   $t->set_var(array("title"     => $page_name,
							 "pagename"  => $page_name,
							 "uname"     => $uname,
	    					 "path"      => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <a href=\"formedit.php?form=".$form_id."\"><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <span id=\"selected\"><b>".$_LANG['msg_PAGE'].":</b> ".$page_name."</span>",
							 "subheader_icon" => "images/application_form.png",
					   		 "path_info" => $page_name));

$t->set_file(array("main1"=>"medit.tpl"));
$t->set_block("main1","row","rows");

$options = explode("\r\n",$row['vals']);
 
 $i=0;
 foreach ($options AS $option)
 {
   
   $opt = explode('::',$option);
   $value = $opt[0];
   $caption = $opt[1];
   
   $default = '';
   if ($value[0]=='^')
   {
    $default = ' checked';
	$value = substr($value,1); 
   }
   else
   {
    $default = '';
   }
   $def = ($row['type']==6) ? '<td align="center"><input type="radio" name="default" value="'.$i.'"'.$default.'></td>' : "";
   $def = ($row['type']==5) ? '<td align="center"><input type="checkbox" name="default[]" value="'.$i.'"'.$default.'></td>' : $def;
   $isup   = ($i>0) ? '<a href="medit.php?do=moveup&id='.$id.'&option='.($i+1).'"><img src="images/icon-arrow-up.gif" border="0" alt="'.$_LANG['msg_up'].'"></a>' : '<img src="images/1x1.gif" border=0 width=13 height=13">';
   $isdown = ((count($options)-1) != $i) ? '<a href="medit.php?do=movedown&id='.$id.'&option='.($i+1).'"><img src="images/icon-arrow-down.gif" border="0" alt="'.$_LANG['msg_down'].'"></a>' : '<img src="images/1x1.gif" border=0 width=13 height=13">';
   
   $t->set_var(array("num"=>($i+1),
                     "class" => (is_int(++$l/2) ? " bgcolor=\"#FFFFFF\"" : "  class=\"dataodd\""),
					 "value" => $value,
					 "caption" => $caption,
					 "def"    => $def,
					 "isup"   => $isup,
					 "isdown" => $isdown,
					 "tabindex" => ($i+1)));
   $t->parse("rows","row",true);   
   $i++;
 }
 
 if ($_GET['do'] == 'add')
 {
  $row = mysql_fetch_row(mysql_query("SELECT vals FROM codertmp WHERE id='".$id."' && sid = '".$_SESSION['codersess']."';"));
  @mysql_query("UPDATE codertmp SET vals='".mysql_escape_string($row[0]."\r\n::")."' WHERE id='".$id."' && sid = '".$_SESSION['codersess']."';");
  Header("Location: medit.php?id=".$id);
 }
 
$t->set_var(array("new" => $new+1));

$t->set_var($_LANG);
$t->parse("out1", array("main1", "main")); 
$t->parse("OUT", array("out1","page"));
$t->p("OUT");
?>