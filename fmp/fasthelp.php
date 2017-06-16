<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");

 if ($_GET['do'] == 'show')
 {
 	ShowRequest();
 	exit();	
 }
 
 if ($_GET['do'] == 'send')
 {
	$error  = "";
	$error .= (trim($_POST['login']) == "")		? "User name is empty or invalid<br>\n" : "";
	$error .= (!is_email($_POST['email']))		? "Email address is not valid <br>\n"   : "";
	$error .= (trim($_POST['request']) == "")	? "Request cannot be empty<br>\n"		: "";
	
	if (empty($error))
	{
		$hash = uniqid(md5($_POST['request']));
		
	$phpself=1;$scriptname=1;$serverscriptname=1;$requesturi=1;$serverrequesturi=1; 
	if (strpos($PHP_SELF,".php")===false) $phpself=0; else $temppath=$PHP_SELF; 
	if (strpos($SCRIPT_NAME,".php")===false) $scriptname=0; else if (!isset($temppath)) $temppath=$SCRIPT_NAME; 
	if (strpos($_SERVER['SCRIPT_NAME'],'.php')===false) $serverscriptname=0; else if (!isset($temppath)) $temppath=$_SERVER['SCRIPT_NAME']; 
	if (strpos($REQUEST_URI,".php")===false) $requesturi=0; else if (!isset($temppath)) $temppath=$REQUEST_URI; 
	if (strpos($_SERVER['REQUEST_URI'],'.php')===false) $serverrequesturi=0; else if (!isset($temppath)) $temppath=$_SERVER['REQUEST_URI']; 
    
	if (strpos($PHP_SELF,".php")===false) $PHP_SELF=$temppath; 
	if (strpos($_SERVER['SCRIPT_NAME'],'.php')===false) 
	if (strrpos($temppath,'?')===false) $_SERVER['SCRIPT_NAME']=$temppath; 
	else  $_SERVER['SCRIPT_NAME']=substr($temppath,0,strrpos($temppath,'?'));
			
		$path = explode('/', $_SERVER['SCRIPT_NAME']);
    	for($i=0; $i<sizeof($path)-1; $i++) $fullpath .= $path[$i]."/";
    	$fullpath = substr($fullpath,0,strlen($fullpath) - 1);
    	
   		$path = "http://".$_SERVER['SERVER_NAME'].$fullpath."/responce.php?hash=".$hash;
   		
		@mysql_query("INSERT INTO requests (date, type, login, email, body, hash, uid) VALUES (".time().", ".intval($_POST['req_type']).", '".mysql_escape_string($_POST['login'])."', '".mysql_escape_string($_POST['email'])."', '".mysql_escape_string($_POST['request'])."', '".$hash."', ".$uid.")");
	
		$subject = ($_POST['req_type'] == 1) ? "Help on service" : "Bug report";
		$res = @mysql_query("SELECT email FROM help_addresses");
		while ($row = mysql_fetch_row($res))
		{
			$req = $_POST['request']."\n".
				   "\n\n=========================================================================\n".
				   $path."\n".
				   "=========================================================================\n";
			mail($row[0], "[Form Maker Pro] ".$_POST['login']." - ".$subject, $req, "From: ".$_POST['email']);
		}
		ShowThanks();
		exit();
	}
 }

 $t = new Template("tpl");
 $t->set_file(array("page" => "index2_notips.tpl", "main"=>"help.tpl"));
 $t->set_block("main","row","rows"); 
 
 $t->set_var(array(	"uname"		=> $uname,
					"path"		=> $_LANG['msg_fasthelp'],
					"subheader_icon" => "images/help.png",
					"path_info"	=> $_LANG['msg_fasthelp']));
					
 $sel = array();
 $sel["sel".intval($_POST['req_type'])] = " selected";

 $t->set_var("error", FormatError($error));
 $t->set_var("login", isset($_POST['login']) ? $_POST['login'] : $uname);
 $t->set_var("email", isset($_POST['email']) ? $_POST['email'] : $uemail);
 $t->set_var("request", $_POST['request']);
 $t->set_var("ref", isset($_POST['ref']) ? $_POST['ref'] : $_SERVER['HTTP_REFERER']);
 $t->set_var($sel);
 
 
 $res = @mysql_query("SELECT * FROM requests WHERE uid = ".$uid." ORDER BY date;");
 while ($row=@mysql_fetch_array($res)) 
 {
	$t->set_var(	array(	"class"		=> (is_int($i/2) ? " class=\"dataodd\"" : " bgcolor=\"#FFFFFF\""),
							"date"		=> date('m-d-Y', $row['date']),
							"type"		=> ($row['type'] == 1) ? "Help on service" : "Bug report",
							"body"		=> substr($row['body'],0,120),
							"hash"		=> $row['hash'],
							"status"	=> $row['status'] == 0 ? "<font color=red>Open</font>" : "<font color=green>Closed</font>" ));	
							
	$t->parse("rows","row",true);
	$i++;
 }
 
 $t->set_var($_LANG);
 $t->parse("OUT", array("main","page"));
 $t->p("OUT");


function ShowThanks()
{
 global $_LANG;
 $t = new Template("tpl");
 $t->set_file(array("page" => "index2_notips.tpl", "main"=>"help_thanks.tpl"));
 
 $t->set_var(array(	"uname"		=> $uname,
					"path"		=> $_LANG['msg_fasthelp'],
					"subheader_icon" => "images/help.png",
					"path_info"	=> $_LANG['msg_fasthelp']));
					
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

function ShowRequest()
{
	global $_LANG;	

 $res = @mysql_query("SELECT * FROM requests WHERE hash='".mysql_escape_string($_GET['hash'])."';");
 $row = @mysql_fetch_array($res);
 
 $t = new Template("tpl");
 $t->set_file(array("page" => "index2_notips.tpl", "main"=>"responce.tpl"));
 
 $t->set_var(array(	"uname"		=> $uname,
					"path"		=> $_LANG['msg_fasthelp'],
					"subheader_icon" => "images/help.png",
					"path_info"	=> $_LANG['msg_fasthelp']));
					
 $t->set_var(array(	"type"		=> ($row['type'] == 1) ? "Help on service" : "Bug report",
 					"body"		=> nl2br(htmlspecialchars($row['body'])),
 					"response"	=> empty($row['responce']) ? "-- no responce --" : nl2br(htmlspecialchars($row['responce']))));
					
 $t->set_var($_LANG);
 $t->parse("OUT", array("main","page"));
 $t->p("OUT");
}
?>