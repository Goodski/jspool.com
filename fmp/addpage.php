<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");

$form_id = intval($_GET['form']);
if ($form_id<1) Header("Location: forms.php");

if ($_GET['do'] == 'add')
{
 $site_id = intval(@implode("",@mysql_fetch_row(@mysql_query("SELECT site_id FROM forms WHERE id = ".$form_id.";"))));


 $error  = '';
 $error .= (trim($_POST['pagename'])== '')  ? $_LANG['msg_error_page_name'].".<br>\n" : "";
 $error .= ((trim($_POST['pageurl']) == '')&&($site_id != 0))  ? $_LANG['msg_error_page_url']."<br>\n."  : "";

 $res = @mysql_query("SELECT id FROM pages WHERE name='".mysql_escape_string($_POST['pagename'])."' AND form_id =".$form_id.";");
 if (mysql_num_rows($res)>0)
 {
  $error .= $_LANG['msg_error_page_ext'].".";
 }

 if ($site_id > 0)
 {
  $res = @mysql_query("SELECT t1.* FROM pages as t1, forms as t2 WHERE t2.site_id = ".$site_id." AND t1.url='".$_POST['pageurl']."';");
  if (mysql_num_rows($res)>0)
  {
   $_POST['pageurl'] = NewUrl($_POST['pageurl'],$site_id);
   $error .= $_LANG['msg_error_url_ext'].".<br> I changed URL to <a href=# class=nlink>".$_POST['pageurl']."</a>";
  }
 }

 
 if ($site_id == 0)
 {
 	$page_url = GetServUrl($form_id);	
 }
 else 
 {
 	$page_url = validateURL($_POST['pageurl']);
 	
 	if (!$page_url)
 	{
 		$error .= "Provided URL is not correct. <br>\n";	
 	}
 }
 
 if (empty($error))
 {
  $page_name = $_POST['pagename'];
  @mysql_query("UPDATE pages SET pos=(pos+1) WHERE pos >= ".intval($_POST['pos'])." AND form_id = ".$form_id.";");
  @mysql_query("INSERT INTO pages (name,url, pos,form_id) VALUES ('".mysql_escape_string($page_name)."','".mysql_escape_string(str_replace(" ", "%20", trim($page_url)))."',".intval($_POST['pos']).",".$form_id.");");   //fix 01.04.08
  $r_id = mysql_insert_id();
  UpdateLabels($form_id);
  Header("Location: coder.php?page=".$r_id);
  exit();
 }
}


if ($_GET['do'] == 'update')
{
 $site_id = intval(@implode("",@mysql_fetch_row(@mysql_query("SELECT site_id FROM forms WHERE id = ".$form_id.";"))));	
 $error  = '';
 $error .= (trim($_POST['pagename'])== '')  ? $_LANG['msg_error_page_name'].".<br>\n" : "";
 $error .= ((trim($_POST['pageurl']) == '')&&($site_id > 0))  ? $_LANG['msg_error_page_url']."."  : "";
 $page_name = EscapeFileString($_POST['pagename']);
 $sql = ($site_id == 0) ? "UPDATE pages SET name = '".mysql_escape_string($page_name)."' WHERE id = ".intval($_GET['page']).";" : "UPDATE pages SET name = '".mysql_escape_string($page_name)."',url = '".mysql_escape_string($_POST['pageurl'])."' WHERE id = ".intval($_GET['page']).";";
 
 if ($site_id == 0)
 {
 	$sql = "UPDATE pages SET name = '".mysql_escape_string($page_name)."' WHERE id = ".intval($_GET['page']).";";
 }
 else 
 {
 	$page_url = validateURL($_POST['pageurl']);
 	
 	if (!$page_url)
 	{
 		$error .= "Provided URL is not correct. <br>\n";	
 	}
 	$sql =  "UPDATE pages SET name = '".mysql_escape_string($page_name)."',url = '".mysql_escape_string(str_replace(" ", "%20", trim($_POST['pageurl'])))."' WHERE id = ".intval($_GET['page']).";";   //fix 01.04.08
 }
 
 if (empty($error))
 {
  @mysql_query($sql);
  UpdateLabels($form_id);
  Header("Location: formedit.php?form=".$form_id);
  exit();
 }
}

$fnamer = mysql_fetch_row(mysql_query("SELECT name, site_id FROM forms WHERE id = ".$form_id.";"));
$fname = $fnamer[0];

   $site_id  = intval($fnamer[1]);
   $site_url = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM sites WHERE id = ".$site_id.";")));
   $site_url  = ((strtolower(substr($site_url,0,7))=='http://')||(strtolower(substr($site_url,0,8))=='https://')) ? $site_url : 'http://'.$site_url;
   $site_url .= ((substr($site_url,-1,1)=='/') ? '' : '/').urlencode(str_replace(" ", "-", $fname)).'_';

	 $t = new Template("tpl");
  	 $t->set_file(array("page" => $index2_tpl, "main"=>($_GET['do']=='edit')?"editpage.tpl":"addpage.tpl"));		 
	       $t->set_var(array("form_name" => $fname,
							 "site_url"  => ($site_id  > 0) ? $site_url : "",
							 "disabled"  => ($site_id == 0) ? " disabled" : "",
							 "onblur"	 => ($site_id  > 0) ? " onBlur=\"SetURL();\"" : ""));

		   $t->set_var(array("path"      => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <a href='formedit.php?form=".$form_id."'><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <span id=\"selected\">".$_LANG['msg_page_new']."</span>",
				             "path_info" => $_LANG['msg_page_new'],
							 "subheader_icon" => "images/application_form.png",
				             "uname"     => $uname,
							"descr"	 => $_LANG['msg_page_preferences_tip']));
				   


if ($_GET['do'] == 'edit')
{
$pid = intval($_GET['page']);
$res = @mysql_query("SELECT name, url, pos FROM pages WHERE id = ".$pid.";");
$row = @mysql_fetch_row($res);

$t->set_var(array("path" => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <a href='formedit.php?form=".$form_id."'><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <b>".$_LANG['msg_PAGE'].":</b> ".$row[0]." / <span id=\"selected\">".$_LANG['msg_preferences']."</span>",
					"subheader_icon" => "images/application_form.png",
				  "path_info" => $_LANG['msg_page_edit']));
							 
	 $t->set_var(array("formid"   => $form_id,
	 				   "pagename" => $row[0],
					   "pageurl"  => ($site_id  > 0) ? $row[1] : "Page is located on Form Maker Pro server",
					   "disabled" => ($site_id == 0) ? " disabled" : "",
					   "onblur"	  => ($site_id  > 0) ? " onBlur=\"SetURL();\"" : "",
					   "do"       => 'update&page='.$pid));	 
}
else
{
	 $pos = '';
     $res = @mysql_query("SELECT name, pos FROM pages WHERE form_id = ".$form_id." AND thx = 0 AND preview = 0 ORDER BY pos;");
     
	 while ($row = @mysql_fetch_row($res))
	 {
 	  $selected = mysql_num_rows($res);
	  $pos .= ($row[2]==0) ? "<option value=".($row[1]+1)." selected>".$_LANG['msg_after']." ".$row[0]."</option>\n" : ""; 
	 }
	 
	 $t->set_var(array("formid"   => $form_id,
	 				   "pagename" => $_POST['pagename'],
					   "pageurl"  => ($site_id > 0) ? $_POST['pageurl'] : "Page is located on Form Maker Pro server",
	                   "pos"      => $pos,
					   "do"		  => 'add',
					   "error"    => FormatError($error),
						"descr"	 => $_LANG['msg_page_add_tip']));	 

}	 

	 $t->set_var($_LANG);					   
	 $t->parse("OUT", array("main", "page"));
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

function NewUrl($url, $site_id, $num = 1)
{
 
 $dot = strlen($url);
 
 for ($i=strlen($url);$i>0;$i--)
 {
  if ($url[$i]=='.')
  {
   $dot = $i;
   break;
  }
 }
 
 $new = substr($url,0,$dot).$num.".".substr($url,$dot+1);
 
 $res = @mysql_query("SELECT t1.* FROM pages as t1, forms as t2 WHERE t2.site_id = ".$site_id." AND t1.url='".$new."';");
 if (mysql_num_rows($res)>0)
 {
  $new = NewUrl($url,$site_id,($num+1));
 }
 
 return $new;
}

function GetServUrl($form_id)
{
	$res = @mysql_query("SELECT COUNT(*) FROM pages WHERE preview = 0 && thx = 0 && form_id = ".$form_id.";");
	$row = @mysql_fetch_row($res);
	
	if ($row[0] == 0)
	{
		$page_name = "index.html";	
	}
	else 
	{
		$page_name = "page".$row[0].".html";
	}

	$res = @mysql_query("SELECT dir FROM forms WHERE id = ".$form_id.";");
	$row = @mysql_fetch_row($res);

	
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
   
    return"http://".$_SERVER['SERVER_NAME'].$fullpath."/forms/".$row[0]."/".$page_name;
}
?>