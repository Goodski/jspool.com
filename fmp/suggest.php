<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");

 if ($_GET['do'] == 'send')
 {
	$error  = "";
	$error .= (!is_email($_POST['email']))		? "Email address is not valid <br>\n"   : "";
	$error .= (trim($_POST['request']) == "")	? "Request cannot be empty<br>\n"		: "";
	
	if (empty($error))
	{
		$res = @mysql_query("SELECT email FROM help_addresses");
		while ($row = mysql_fetch_row($res))
		{
			mail($row[0], "[Form Maker Pro] Suggestions", $_POST['request'], "From: ".$_POST['email']);
		}
		
		ShowThanks();
		exit();
		
	}
 }

 $t = new Template("tpl");
 $t->set_file(array("page" => "index2_notips.tpl", "main"=>"suggest.tpl"));
 
 $t->set_var(array(	"uname"		=> $uname,
					"path"		=> "Suggestions",
					"subheader_icon" => "images/email_add.png.png",
					"path_info"	=> "Suggestions"));
					
 $sel = array();
 $sel["sel".intval($_POST['req_type'])] = " selected";

 $t->set_var("error", FormatError($error));
 $t->set_var("login", isset($_POST['login']) ? $_POST['login'] : $uname);
 $t->set_var("email", isset($_POST['email']) ? $_POST['email'] : $uemail);
 $t->set_var("request", $_POST['request']);
 $t->set_var("ref", isset($_POST['ref']) ? $_POST['ref'] : $_SERVER['HTTP_REFERER']);
 $t->set_var($sel);
 $t->set_var($_LANG);
 $t->parse("OUT", array("main","page"));
 $t->p("OUT");


function ShowThanks()
{
 global $_LANG;
 $t = new Template("tpl");
 $t->set_file(array("page" => "index2_notips.tpl", "main"=>"suggest_thanks.tpl"));
 
 $t->set_var(array(	"uname"		=> $uname,
					"path"		=> "Suggestions",
					"subheader_icon" => "images/email_add.png.png",
					"path_info"	=> "Suggestions"));
					
 $t->set_var("ref", $_POST['ref']);
 $t->set_var($_LANG);
 $t->parse("OUT", array("main","page"));
 $t->p("OUT");
}

function FormatError($msg)
{
global $_LANG;

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
            <td height="26"><strong>'.$_LANG['msg_error_message'].':</strong><br>'.
            $msg.'</td>
            </tr>
            </table></td>
            </tr>
            </table></td>
            </tr>';
			
			return $error;
 }
}
function is_email($str)
{
	if(ereg("^.+@.+\\..+$", $str))
		return true;
	else
		return false;
}
?>