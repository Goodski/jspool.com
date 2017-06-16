<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/draw.php");

$form_id = intval($_GET['form']);

if ($form_id<1)
{
 Header("Location: forms.php");
 exit();
}


if ($_GET['do'] == 'add')
{
 $error  = '';
 $error .= (trim($_POST['name'])=='') ? $_LANG['msg_error_tpl_name'].".<br>\n" : "";
 $error .= (ValidTO($_POST['to']))    ? $_LANG['msg_error_to_fld'].".<br>\n" : "";
 $error .= (ValidTO($_POST['from']))  ? $_LANG['msg_error_from_fld'].".<br>\n" : "";

 if (empty($error))
 {
  if (mysql_query("INSERT INTO emails (name, komu, cc, bcc, ot, subject, attach, format, body, form_id, preset) VALUES ('".mysql_escape_string($_POST['name'])."','".mysql_escape_string($_POST['to'])."','".mysql_escape_string($_POST['cc'])."','".mysql_escape_string($_POST['bcc'])."','".mysql_escape_string($_POST['from'])."','".mysql_escape_string($_POST['subject'])."','".mysql_escape_string($_POST['attach'])."',".intval($_POST['format']).",'".mysql_escape_string($_POST['body'])."',".$form_id.", ".intval($_POST['preset']).");"))
  {
   Header("Location: formedit.php?form=".$form_id);
   exit();
  }
  else
  {
   $error = $_LANG['msg_db_error'].".<br>\n";
  }
 }
}

if ($_GET['do']=='delete')
{

 	@mysql_query("DELETE FROM emails WHERE id = ".intval($_GET['email']).";");
 
 Header("Location: formedit.php?form=".$form_id);
 exit();
}

$do = "add";

if ($_GET['do']=='edit')
{
 $do = 'update';
 
 $tpl = @mysql_fetch_array(@mysql_query("SELECT * FROM emails WHERE id = ".intval($_GET['email']).";"));
 
 $_POST['name']    = $tpl['name'];
 $_POST['to']      = $tpl['komu'];
 $_POST['cc']      = $tpl['cc'];
 $_POST['bcc']     = $tpl['bcc'];
 $_POST['from']    = $tpl['ot'];
 $_POST['subject'] = $tpl['subject'];
 $_POST['attach']  = $tpl['attach'];
 $_POST['format']  = $tpl['format'];
 $_POST['body']    = $tpl['body'];
 $_POST['preset']  = $tpl['preset'];
 
 $hidden = '<input type="hidden" name="email" value="'.$_GET['email'].'">';
 
}

if ($_GET['do'] == 'update')
{
 $do='update';
 $hidden = '<input type="hidden" name="email" value="'.$_POST['email'].'">';
 
 $error  = '';
 $error .= (trim($_POST['name'])=='') ? $_LANG['msg_error_tpl_name'].".<br>\n" : "";
 $error .= (ValidTO($_POST['to']))    ? $_LANG['msg_error_to_fld'].".<br>\n" : "";
 $error .= (ValidTO($_POST['from']))  ? $_LANG['msg_error_from_fld'].".<br>\n" : "";

 if (empty($error))
 {
  if (mysql_query("UPDATE emails SET name = '".mysql_escape_string($_POST['name'])."', komu = '".mysql_escape_string($_POST['to'])."', cc = '".mysql_escape_string($_POST['cc'])."', bcc = '".mysql_escape_string($_POST['bcc'])."', ot = '".mysql_escape_string($_POST['from'])."', subject = '".mysql_escape_string($_POST['subject'])."', attach = '".mysql_escape_string($_POST['attach'])."', format = ".intval($_POST['format']).", body = '".mysql_escape_string($_POST['body'])."', preset = ".intval($_POST['preset'])." WHERE id = ".intval($_POST['email']).";"))
  {
  Header("Location: formedit.php?form=".$form_id);
  exit();
  }
  else
  {
   $error = $_LANG['msg_db_error'].".<br>\n";
  }
 }
}

$fname = mysql_fetch_row(mysql_query("SELECT name FROM forms WHERE id = ".$form_id.";"));
$fname = $fname[0];

 $t = new Template("tpl");
 $t->set_file(array("page" => $index2_tpl, "main"=>"email.tpl")); 
 $f1 = (intval($_POST['format'])==0) ? ' checked' : '';
 $f2 = (intval($_POST['format'])==1) ? ' checked' : '';
 
 $_POST = array_map("htmlspecialchars", $_POST);
 $t->set_var(array("formid"		=> $form_id,
				   "form_name"	=> $fname,
				   "do"			=> $do,
				   "name"		=> $_POST['name'],
				   "to"			=> $_POST['to'],
				   "cc"			=> $_POST['cc'],
				   "bcc"		=> $_POST['bcc'],
				   "from"		=> $_POST['from'],
				   "subject"	=> $_POST['subject'],
				   "attach"		=> $_POST['attach'],
				   "f1"			=> $f1,
				   "f2"			=> $f2,
				   "body"		=> $_POST['body'],
				   "preset0"	=> ($_POST['preset'] == 0 ? " selected" : ""),
				   "preset1"	=> ($_POST['preset'] == 1 ? " selected" : ""),
				   "preset2"	=> ($_POST['preset'] == 2 ? " selected" : ""),
				   "error"		=> FormatError($error),
                   "email"		=> $hidden,
					"descr"	 => $_LANG['msg_mail_template_preferences_tip']));

 $res = @mysql_query("SELECT email FROM users WHERE id = ".$uid.";");
 $row = @mysql_fetch_row($res);
 
 $user_email = $row[0];
 
 
	  $t->set_var(array("uname"  => $uname,
					    "path"    => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <a href=\"formedit.php?form=".$form_id."\"><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <span id=\"selected\">".$_LANG['msg_email_tpl']."</span>",
						"subheader_icon" => "images/email_edit.png",
					   	"path_info" => $_LANG['msg_email_tpl']));
				   
 $t->set_block("main", "row", "rows");
 
$res = @mysql_query("SELECT id, name FROM pages WHERE form_id = '".$form_id."' AND thx = 0 && preview = 0 ORDER BY pos;");
while ($row = @mysql_fetch_row($res))
{
 $fields = '';
 $i = 0;
 $res2 = @mysql_query("SELECT * FROM flds WHERE page_id = ".$row[0]." && type <> 7 && type <> 9 ORDER BY pos;");
 while($row2 = @mysql_fetch_array($res2))
 {
	 if ( $row2['type'] == CAPTCHA )
		continue;
  $type = $_LANG['msg_unknown'];
  $type = ($row2['type'] == TEXT)      	? $_LANG['msg_textfield']   : $type;
  $type = ($row2['type'] == SELECT)    	? $_LANG['msg_select']      : $type;
  $type = ($row2['type'] == BROWSE)    	? $_LANG['msg_browse']      : $type;
  $type = ($row2['type'] == TEXTAREA)  	? $_LANG['msg_textarea']    : $type;
  $type = ($row2['type'] == MULTILIST) 	? $_LANG['msg_multilist'] 	: $type;
  $type = ($row2['type'] == CHECKBOX)  	? $_LANG['msg_checkbox']    : $type;
  $type = ($row2['type'] == RADIO)     	? $_LANG['msg_radio']       : $type;
  $type = ($row2['type'] == CALCULATION)? $_LANG['msg_calc']		: $type;
  
  $uploaded = ($row2['type'] == BROWSE) ? '_uploaded' : '';
  $fname = FieldPrefix($row2).$row2['name'];
 
  if ($row2['type'] == CALCULATION)
  {
  	$fname = "<".$fname.">";
  }
  if ($row2['type'] == BROWSE)
  {
 	$attaches .= "[".$fname."_uploaded],";
  }
  else
  {
	  $preset_flds .= $row2['title'].": [".$fname."]\\n";
  }
  
  
  $fields .= "<tr ".((is_int($i++/2)) ? 'class="dataodd"' : 'bgcolor="#FFFFFF"').">\n";
  $fields .= "<td><a class=\"nlink2\"  onclick = \"InsertName('".$fname.$uploaded."',".$row2['type'].");\">".$row2['title']."</a></td>\n";
  $fields .= "<td>".$type."</a></td>\n";
  $fields .= "</tr>\n";
 }
 $t->set_var(array("pageid"   => $row[0],
                   "pagename" => $row[1],
                   "fields"   => $fields));
 $t->parse("rows", "row", true);
}
 
 $attaches = substr($attaches,0,-1);
 
 $t->set_var(array(	"user_email"	=> $user_email,
 					"attaches"		=> $attaches,
 					"preset_fields"	=> $preset_flds ));
 					
 $t->set_var($_LANG);
 $t->parse("OUT", array("main","page"));
 $t->p("OUT");


function ValidTO($src)
{
global $form_id;

$valid = false;

 $src = explode(",", $src);
 foreach($src as $block)
 {
  if (preg_match("/\[((.)*?)\]/i",$block))
  {
   if (!((strtolower(substr($block,0,4))=='[re_')||(strtolower(substr($block,0,3))=='[e_')))
   {
    $name = substr(substr($block,1),0,-1);
	if ($name[1]=='_') $name=substr($name,2);
	if ($name[2]=='_') $name=substr($name,3);
    $res = mysql_query("SELECT t1.vals FROM flds as t1, pages as t2 WHERE t1.page_id = t2.id AND t2.form_id = ".$form_id." AND t1.name = '".$name."';");
	$row = mysql_fetch_row($res);
    $vals = explode("\r\n", $row[0]);
	$valid = false;
	 foreach($vals AS $val)
	 {
	  $email = explode("::",$val);

	  if (!preg_match('%[-\.\w]+@[-\w]+(?:\.[-\w]+)+%', $email[0]))
	  {
	   $valid = true;   
	  }
	 } 
   }
  }
  else
  {
   $valid = !preg_match('%[-\.\w]+@[-\w]+(?:\.[-\w]+)+%', $block);
  }
 }

return $valid;
}


function FormatError($msg)
{
 if (empty($msg))
 {
  return "";
 }
 else
 {
 
  $error = '<tr>
            <td class="color9"><table width="100%" border="0" cellspacing="2" cellpadding="0">
            <tr valign="top">
            <td valign="center"><img src="images/sysmsg-icon-warnings.gif" alt="warning" width="33" height="33" hspace="10" vspace="9"></td>
            <td width="100%" class="color2"><table width="100%" border="0" cellspacing="9" cellpadding="0">
            <tr>
            <td height="26"><strong>Error mesage:</strong><br>'.
            $msg.'</td>
            </tr>
            </table></td>
            </tr>
            </table></td>
            </tr>';
			
			return $error;
 }
}
?>
