<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/draw.php");
$do = "add";

 /**
  * Getting form ID
  */
  
	$form_id = intval($_GET['form']);
	if ($form_id < 1)
	{
 		Header("Location: forms.php");
 		exit();
	}


 /**
  * Doing an action
  */
 
  	switch($_GET['do'])
  	{
		case 'add':
			AddLog();
			break;
		case 'delete':
			DeleteLog();
			break; 
		case 'edit':
			EditLog();
			break; 		
		case 'update':
			UpdateLog();
			break;
  	}

$fname = mysql_fetch_row(mysql_query("SELECT name FROM forms WHERE id = ".$form_id.";"));
$fname = $fname[0];

 $t = new Template("tpl");
 $t->set_file(array("page" => $index2_tpl, "main"=>"log.tpl")); 
 $t->set_var("formsn","images/title-form.gif");

 $f1 = (intval($_POST['format'])==0) ? ' checked' : '';
 $f2 = (intval($_POST['format'])==1) ? ' checked' : '';

 $t->set_var(array("formid"   => $form_id,
				   "form_name"          => $fname,
				   "do"   => $do,
				   "name" => $_POST['name'],
				   "file" => $_POST['file'],
				   "body" => $_POST['body'],
				   "error" => FormatError($error),
                   "log" => $hidden));
				   
	  $t->set_var(array("uname"  => $uname,
					    "path"    => "<a href=\"forms.php\">Forms</a> / <b>".$_LANG['msg_FORM'].":</b> <a href=\"formedit.php?form=".$form_id."\">".$fname."</a> / <span id=\"selected\">Log template</span>",
						"subheader_icon" => "images/application_form.png",
					   	"path_info" => $_LANG['msg_log_tpl']));

 $t->set_block("main", "row", "rows");
 
$res = @mysql_query("SELECT id, name FROM pages WHERE form_id = '".$form_id."' ORDER BY pos;");
while ($row = @mysql_fetch_row($res))
{
 $fields = '';
 $i = 0;
 $res2 = @mysql_query("SELECT * FROM flds WHERE page_id = ".$row[0]." && type <> 7 ORDER BY pos;");
 while($row2 = @mysql_fetch_array($res2))
 {
  $type = "unknown";
  $type = ($row2['type'] == TEXT)      ? "TextField"    : $type;
  $type = ($row2['type'] == SELECT)    ? "Choise"       : $type;
  $type = ($row2['type'] == BROWSE)    ? "Browse"       : $type;
  $type = ($row2['type'] == TEXTAREA)  ? "TextArea"     : $type;
  $type = ($row2['type'] == MULTILIST) ? "MultipleList" : $type;
  $type = ($row2['type'] == CHECKBOX)  ? "CheckBox"     : $type;
  $type = ($row2['type'] == RADIO)     ? "Radio"        : $type;
  
  $fname = FieldPrefix($row2).$row2['name'];
  $fields .= "<tr ".((is_int($i++/2)) ? 'class="dataodd"' : 'bgcolor="#FFFFFF"').">\n";
  $fields .= "<td><a class=\"nlink\" href=\"#\" onclick = \"InsertName('".$fname.$uploaded."',".$row2['type'].");\">".$row2['title']."</a></td>\n";
  $fields .= "<td>".$type."</a></td>\n";
  $fields .= "</tr>\n";
 }
$t->set_var(array("pageid"   => $row[0],
                   "pagename" => $row[1],
                   "fields"   => $fields)); 
 $t->parse("rows", "row", true);
}
 
 $t->parse("OUT", array("main","page"));
 $t->p("OUT");


function FormatError($msg)
{
 if (empty($msg))
 {
  return "";
 }
 else
 {
 
  $error = '<tr>
            <td class="color9"><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr valign="top">
            <td valign="center"><img src="images/sysmsg-icon-warnings.gif" alt="warning" width="33" height="33" hspace="10" vspace="9"></td>
            <td width="100%" class="color2"><table width="100%" border="0" cellspacing="9" cellpadding="0">
            <tr>
            <td height="26"><strong>Eror mesage:</strong><br>'.
            $msg.'</td>
            </tr>
            </table></td>
            </tr>
            </table></td>
            </tr>';
			
			return $error;
 }
}


 /**
  * AddLog
  * @return void
  * @desc Add new log
  */
 
function AddLog()
{
	global $form_id, $error;
	
	$error  = '';
 	$error .= (trim($_POST['name'])=='') ? "&nbsp;&nbsp;Template's name is empty or incorrect.<br>\n" : "";
 	$error .= (trim($_POST['file'])=='')   ? "&nbsp;&nbsp;\"File name\" field is empty or incorrect.<br>\n" : "";

 	if (empty($error))
 	{
  		if (mysql_query("INSERT INTO logs (name, file, body, form_id) VALUES ('".mysql_escape_string($_POST['name'])."','".mysql_escape_string($_POST['file'])."','".mysql_escape_string($_POST['body'])."',".$form_id.");"))
		{
   			Header("Location: formedit.php?form=".$form_id);
   			exit();
  		}
  		else
  		{
   			$error = "Database error.<br>\n";
	  	}
 	}
}

 /**
  * DeleteLog
  * @return void
  * @desc Delete log
  */
  
function DeleteLog()
{
	global $form_id;
	
	@mysql_query("DELETE FROM logs WHERE id = ".intval($_GET['log']).";");
 	Header("Location: formedit.php?form=".$form_id);
 	exit();	
}

 /**
  * EditLog
  * @return void
  * @desc Edit log
  */
  
function EditLog()
{
	global $do, $hidden;
	
	$tpl = @mysql_fetch_array(@mysql_query("SELECT * FROM logs WHERE id = ".intval($_GET['log']).";"));
	$_POST['name'] = $tpl['name'];
 	$_POST['file'] = $tpl['file'];
 	$_POST['body'] = $tpl['body'];
 
 	$do = 'update';
 	$hidden = '<input type="hidden" name="log" value="'.intval($_GET['log']).'">';	
}

 /**
  * UpdateLog
  * @return void
  * @desc Update Log
  */
  
function UpdateLog()
{
	global $error;
	
 	$error  = '';
 	$error .= (trim($_POST['name'])=='') ? "Please, enter template's name.<br>\n" : "";
	$error .= (trim($_POST['file'])=='') ? "\"File\" field is empty or incorrect.<br>\n" : "";

 	if (empty($error))
 	{
		mysql_query("UPDATE logs SET name = '".mysql_escape_string($_POST['name'])."', file = '".mysql_escape_string($_POST['file'])."', body = '".mysql_escape_string($_POST['body'])."' WHERE id = ".intval($_POST['log']).";");
		Header("Location: formedit.php?form=".$form_id);
  		exit();
	}	
}
?>