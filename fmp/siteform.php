<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");

$site_id = intval($_GET['siteid']);

if (isset($_SESSION['codersess']))
{
 @mysql_query("DELETE FROM codersess WHERE id = '".$_SESSION['codersess']."';");
 @mysql_query("DROP TABLE coder".$_SESSION['codersess'].";");
 unset($_SESSION['codersess']);
}

if ($_GET['do'] == 'addform')
{
 ShowAdd();
 exit();
}

if ($_GET['do']=='edit')
{
	ShowEdit();
	exit();
}

if ($_GET['do']=='update')
{
 $error  = "";
 $error .= (trim($_POST['formname'])=='') ? $_LANG['msg_form_name_empty'].".<br>\n" : "";

 if (empty($error))
 {
  $site_id = intval($_POST['siteid']);
  $form_id = intval($_GET['form']);
  
  $last_site = intval(@implode(NULL, @mysql_fetch_row(@mysql_query("SELECT site_id FROM forms WHERE id = ".$form_id.";"))));
  
  
  @mysql_query("UPDATE forms SET name = '".$_POST['formname']."', site_id = ".$site_id." WHERE id=".intval($_GET['form']).";");
  
  ////////////////////////////////////////////////////////////////
  if ($_POST['previewpage'] != 1)
  {
  	@mysql_query("DELETE FROM pages WHERE preview=1 && form_id = ".$form_id.";");
  }
  else 
  {
  	if (intval(@implode("",@mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM pages WHERE form_id = ".$form_id." && preview = 1"))))==0)
   	{
   		$prev_pos = (intval(@implode("",@mysql_fetch_row(@mysql_query("SELECT MAX(pos) FROM pages WHERE form_id = ".$form_id." && thx = 0;")))));
   		$prev_pos++;
   		
		$site_id   = intval($_POST['siteid']);
		$site_url  = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM sites WHERE id = ".$site_id.";")));
		$site_url  = ((strtolower(substr($site_url,0,7))=='http://')||(strtolower(substr($site_url,0,8))=='https://')) ? $site_url : 'http://'.$site_url;
		$site_url .= ((substr($site_url,-1,1)=='/') ? '' : '/').urlencode(str_replace(" ", "-", $_POST['formname']));

		@mysql_query("INSERT INTO pages (name,url,pos,form_id, preview) VALUES ('Preview', '".$site_url."_preview.html',".$prev_pos.",".$form_id.", 1);");
		@mysql_query("UPDATE pages SET pos = (pos+1) WHERE form_id = ".$form_id." AND thx = 1;");
   	}
  }
  ////////////////////////////////////////////////////////////////
  
  
  if ($_POST['thkupage'] != 1)
  {
   @mysql_query("DELETE FROM pages WHERE thx=1 && form_id = ".$form_id.";");
  }
  else
  {
   if (intval(@implode("",@mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM pages WHERE form_id = ".$form_id." && thx = 1"))))==0)
   {
   $site_id  = intval($_POST['siteid']);
   $site_url = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM sites WHERE id = ".$site_id.";")));
   $site_url  = ((strtolower(substr($site_url,0,7))=='http://')||(strtolower(substr($site_url,0,8))=='https://')) ? $site_url : 'http://'.$site_url;
   $site_url .= ((substr($site_url,-1,1)=='/') ? '' : '/').urlencode(str_replace(" ", "-", $_POST['formname']));
   
   $thx_pos = intval(@implode("",@mysql_fetch_row(@mysql_query("SELECT MAX(pos) FROM pages WHERE form_id = ".$form_id.";"))))+1;
   @mysql_query("INSERT INTO pages (name,url, pos, form_id, thx) VALUES ('Thanks', '".$site_url."_thanks.html', ".$thx_pos.",".$form_id.", 1);");
   $paid = @mysql_insert_id();
   $rnd = time();//fix 24.03.08
   @mysql_query("INSERT INTO flds (`id`,title,name,type,size,pos,vals,req,valid,page_id) VALUES (".$rnd.",'','',7,0,1,'<h1 align=\"center\">Thank you for your submission</h1>',0,0,".$paid.");");//fix 24.03.08
   }
  }
  
	if ($site_id != $last_site)
	{
		  if ($site_id == 0)
  			{
  				
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
   			
    			$res2 = @mysql_query("SELECT dir FROM forms WHERE id = ".$form_id.";");
				$row2 = @mysql_fetch_row($res2);
			
    			$path_to_serv = "http://".$_SERVER['SERVER_NAME'].$fullpath."/forms/".$row2[0]."/";

  				$res = @mysql_query("SELECT id, url FROM pages WHERE form_id = ".$form_id.";");
  				while ($row = @mysql_fetch_row($res))
  				{
  					$url = $row[1];
  					$url = $path_to_serv.basename($url);
  		
  					@mysql_query("UPDATE pages SET url = '".mysql_escape_string($url)."' WHERE id = ".$row[0].";");
  				}
  	
  			}
  		  else
  		    {
  		  		$site_url = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM sites WHERE id = ".$site_id.";")));
				$site_url  = ((strtolower(substr($site_url,0,7))=='http://')||(strtolower(substr($site_url,0,8))=='https://')) ? $site_url : 'http://'.$site_url;
   				$site_url .= ((substr($site_url,-1,1)=='/') ? '' : '/');
						
   				$res = @mysql_query("SELECT id, url FROM pages WHERE form_id = ".$form_id.";");
  				while ($row = @mysql_fetch_row($res))
  				{
  					$url = $row[1];
  					$url = $site_url.basename($url);
  		
  					@mysql_query("UPDATE pages SET url = '".mysql_escape_string($url)."' WHERE id = ".$row[0].";");
  				}
  		    }
	}
 }
 else
 {
  ShowEdit($error);
  exit();
 }
}

if ($_GET['do'] == 'add')
{
 $error  = "";
 $error .= (trim($_POST['formname'])=='') ? $_LANG['msg_form_name_empty'].".<br>\n" : "";
 
 if (empty($error))
 {
   if (intval($_POST['form_preset']))
   {
 	AddPresetForm();	
   }
   else 
   {
  // Creating new form
  srand(time());
  $form_code = uniqid(md5(time()+rand(0,999999)));
  
  @mysql_query("INSERT INTO forms (name, dir, site_id, uid) VALUES ('".mysql_escape_string($_POST['formname'])."', '".$form_code."', ".intval($_POST['siteid']).", ".$uid.");");
  $fid = @mysql_insert_id();
  
  // Creating error template
  $error_tpl = join("",file('./tpl/error.tpl'));
  @mysql_query("INSERT INTO errors (data, form_id) VALUES ('".mysql_escape_string($error_tpl)."',".$fid.");");

  $posit = 1;
  
  
  if ($_POST['siteid'] == 0)
  {
			$res = @mysql_query("SELECT COUNT(*) FROM pages WHERE form_id = ".$form_id.";");
			$row = @mysql_fetch_row($res);
			
			if ($row[0] == 0)
			{
				$page_name = "index.html";	
			}
			else 
			{
				$page_name = "page".$row[0].".html";
			}

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
   
    		$path_to_serv = "http://".$_SERVER['SERVER_NAME'].$fullpath."/forms/".$form_code."/";
  }
  
  if ($_POST['preview_page'] == 1)
  {
   if ($_POST['siteid'] > 0)
   {
   	$site_id  = intval($_POST['siteid']);
   	$site_url = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM sites WHERE id = ".$site_id.";")));
   	$site_url  = ((strtolower(substr($site_url,0,7))=='http://')||(strtolower(substr($site_url,0,8))=='https://')) ? $site_url : 'http://'.$site_url;
   	$site_url .= ((substr($site_url,-1,1)=='/') ? '' : '/').urlencode(str_replace(" ", "-", $_POST['formname']));
   	$preview_url = $site_url."_preview.html";
   }
   else 
   {
		$preview_url = $path_to_serv.urlencode(str_replace(" ", "-", $_POST['formname']))."_preview.html";
   }

   @mysql_query("INSERT INTO pages (name,url,pos,form_id, preview) VALUES ('Preview', '".mysql_escape_string($preview_url)."',1,".$fid.", 1);");
   $posit++;
  }

  if ($_POST['thkupage']==1)
  {
   if ($_POST['siteid'] > 0)
   {
    $site_id  = intval($_POST['siteid']);
    $site_url = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM sites WHERE id = ".$site_id.";")));
    $site_url  = ((strtolower(substr($site_url,0,7))=='http://')||(strtolower(substr($site_url,0,8))=='https://')) ? $site_url : 'http://'.$site_url;
    $site_url .= ((substr($site_url,-1,1)=='/') ? '' : '/').urlencode(str_replace(" ", "-", $_POST['formname']));
    $thx_url = $site_url."_thanks.html";
   }
   else 
   {
   	$thx_url = $path_to_serv.urlencode(str_replace(" ", "-", $_POST['formname']))."_thanks.html";
   }

   @mysql_query("INSERT INTO pages (name,url,pos,form_id, thx) VALUES ('Thanks', '".$thx_url."',".$posit.",".$fid.", 1);");
   $paid = @mysql_insert_id();
   @mysql_query("INSERT INTO flds (title,name,type,size,pos,vals,req,valid,page_id) VALUES ('','',7,0,1,'<h1 align=\"center\">Thank you for your submission</h1>',0,0,".$paid.");");
  }
  
  	Header("Location: formedit.php?form=".$fid);
  	exit();
   }
 }
 else
 {
  ShowAdd($error);
  exit();
 }
}

if ($_GET['do'] == 'delete')
{
 $fid = intval($_GET['form']);
 DelForm($fid);
}

if ($_GET['do'] == 'groupdel')
{
 if (is_array($_POST['chk']))
 {
   foreach($_POST['chk'] as $fid)
   {
     $fid = intval($fid);
	 DelForm($fid);
   }
 }
}
	 $t = new Template("tpl");
  	 $t->set_file(array("page" => $index_tpl, "main"=>"siteform.tpl"));		 
   	 $t->set_block("main","row","rows"); 
   	 $t->set_block("main", "serv_row", "serv_rows");
   	 
     $t->set_var("formsn","images/title-form.gif"); 

     $t->set_var(array("uname"		=> $uname,
					   "path"		=> $_LANG['msg_forms'],
					   "path_info"	=> $_LANG['msg_forms'],
					   "subheader_icon" => "images/application_form.png",
					   "descr"		=> $_LANG['msg_forms_tip']));

/////// SORTING /////////////////////////////////////
	 
	 switch ($_GET['direct'])
	 {
	 	case 'desc':
	 		$desc = true;
	 		$direct = "desc";
	 		break;
	 	default:
	 	    $desc = false;
	 		$direct = "asc";
	 		break;	
	 }
	 
	 switch ($_GET['order_by'])
	 {
	 	case 'pages':
	 		$order_by = 'pages';
	 		$t->set_var("sel1", $desc ? ' id="selected2"' : ' id="selected"');
	 		$t->set_var("direct1", $desc ? 'asc' : 'desc');
	 		$t->set_var("direct0", 'asc');
	 		$t->set_var("direct2", 'asc');
	 		$t->set_var("direct3", 'asc');
	 		$t->set_var("direct4", 'asc');
	 		$t->set_var("direct5", 'asc');
	 		break;
	 	case 'emails':
	 		$order_by = 'emails';
	 		$t->set_var("sel2", $desc ? ' id="selected2"' : ' id="selected"');
	 		$t->set_var("direct2", $desc ? 'asc' : 'desc');
	 		$t->set_var("direct0", 'asc');
	 		$t->set_var("direct1", 'asc');
	 		$t->set_var("direct3", 'asc');
	 		$t->set_var("direct4", 'asc');
	 		$t->set_var("direct5", 'asc');
	 		break;
	 	case 'dbs':
	 		$order_by = 'dbs';
	 		$t->set_var("sel3", $desc ? ' id="selected2"' : ' id="selected"');
	 		$t->set_var("direct3", $desc ? 'asc' : 'desc');
	 		$t->set_var("direct0", 'asc');
	 		$t->set_var("direct1", 'asc');
	 		$t->set_var("direct2", 'asc');
	 		$t->set_var("direct4", 'asc');
	 		$t->set_var("direct5", 'asc');
	 		break;
	 	case 'preview':
	 		$order_by = "is_prev";
	 		$t->set_var("sel4", $desc ? ' id="selected2"' : ' id="selected"');
	 		$t->set_var("direct4", $desc ? 'asc' : 'desc');
	 		
			$t->set_var("direct0", 'asc');
			$t->set_var("direct1", 'asc');
			$t->set_var("direct2", 'asc');
			$t->set_var("direct3", 'asc');
			$t->set_var("direct5", 'asc');
			break;
	 	case 'thx':
	 		$order_by = "is_thx";
	 		$t->set_var("sel5", $desc ? ' id="selected2"' : ' id="selected"');
	 		$t->set_var("direct5", $desc ? 'asc' : 'desc');
	 		
	 		$t->set_var("direct0", 'asc');
	 		$t->set_var("direct1", 'asc');
	 		$t->set_var("direct2", 'asc');
	 		$t->set_var("direct3", 'asc');
	 		$t->set_var("direct4", 'asc');
	 		break;
	 	default:
	 		$order_by = 'name';
	 		$t->set_var("sel0", $desc ? ' id="selected2"' : ' id="selected"');
	 		$t->set_var("direct0", $desc ? 'asc' : 'desc');
	 		$t->set_var("direct1", 'asc');
	 		$t->set_var("direct2", 'asc');
	 		$t->set_var("direct3", 'asc');
	 		$t->set_var("direct4", 'asc');
	 		$t->set_var("direct5", 'asc');
	 		break;
	 }
 
//////////////////////////////////////////////////////
	
	 $table = array();
	 $res = @mysql_query("SELECT id, name, style FROM forms WHERE site_id = ".$site_id." && uid = ".$uid.";");
	 while ($row = @mysql_fetch_row($res))
	 {
	 	$record				= array();
	 	$record['id']		= $row[0];
	 	$record['name']		= $row[1];
	 	$record['style']	= empty($row[2]) ? "&nbsp;" : "<img src=\"images/style.png\">";
	 	$record['pages']	= intval(@implode(NULL, @mysql_fetch_row( @mysql_query("SELECT COUNT(*) FROM pages WHERE thx=0 && preview = 0 && form_id = ".$row[0].";") )));
	 	$record['is_prev']	= intval(@implode(NULL, @mysql_fetch_row( @mysql_query("SELECT COUNT(*) FROM pages WHERE thx=0 && preview = 1 && form_id = ".$row[0].";") )));
	 	$record['is_thx']	= intval(@implode(NULL, @mysql_fetch_row( @mysql_query("SELECT COUNT(*) FROM pages WHERE thx=1 && preview = 0 && form_id = ".$row[0].";") )));
	 	$record['pages']	= intval(@implode(NULL, @mysql_fetch_row( @mysql_query("SELECT COUNT(*) FROM pages WHERE thx=0 && preview = 0 && form_id = ".$row[0].";") )));
	 	$record['emails']	= intval(@implode(NULL, @mysql_fetch_row( @mysql_query("SELECT COUNT(*) FROM emails WHERE form_id = ".$row[0].";") ))); 
	 	$record['dbs']		= intval(@implode(NULL, @mysql_fetch_row( @mysql_query("SELECT COUNT(*) FROM dbs WHERE form_id = ".$row[0].";") )));

	 	$table[] = $record;
	 }
	 
	 $table = TableSorter($table, $order_by, $desc);
	 $l = 0;
	 foreach ($table as $record)
	 {
	 	$t->set_var("form_id",		$record['id']);
	 	$t->set_var("form_name",	$record['name']);
	 	$t->set_var("style_img",	$record['style']);
	 	$t->set_var("pages_num",	$record['pages']);
	 	$t->set_var("is_preview",	($record['is_prev'] == 1	? "Yes" : "No"));
	 	$t->set_var("is_thx",		($record['is_thx'] == 1		? "Yes" : "No"));
	 	$t->set_var("emails_num",	$record['emails']);
	 	$t->set_var("dbs_num",		$record['dbs']);
	 	$t->set_var("cell",			((is_int($l++/2)) ? 'class="dataodd"' : ' bgcolor="#FFFFFF"'));
	 	
	 	$t->parse("serv_rows", "serv_row", true);
	 }
	 
	 $t->set_var("siteid", $site_id);
		$res = @mysql_query("SELECT id, name FROM sites WHERE id = ".$site_id." ORDER BY name;");
		while ($row = mysql_fetch_row($res))
		{
			$t->set_var("sitename", $row[1]);
		}
		if ($site_id==0) {$t->set_var("sitename", "Form Maker Pro server");}
	 $t->set_var($_LANG);
	 $t->parse("OUT", array("main","page"));
     $t->p("OUT");


function ShowAdd($error = "")
{
global $uid, $_LANG, $index2_tpl;

 $_POST['siteid'] = (empty($_POST['siteid'])) ? $_GET['site'] : $_POST['siteid'];

 $res = @mysql_query("SELECT id, name FROM sites WHERE uid = ".$uid." ORDER BY name;");
 while ($row = mysql_fetch_row($res))
 {
  $selected  = ($_POST['siteid'] == $row[0]) ? ' selected' : '';
  $sitelist .= "<option value='".$row[0]."'".$selected.">".$row[1]."</option>\n";
 }
 
 $res = @mysql_query("SELECT id, name FROM preset_forms ORDER BY name;");
 while ($row = @mysql_fetch_row($res))
 {
  $selected  = ($_POST['form_preset'] == $row[0]) ? ' selected' : '';
  $form_presets .= "<option value='".$row[0]."'".$selected.">".$row[1]."</option>\n";
 }
 
 $t = new Template("tpl");
 $t->set_file(array("page" => $index2_tpl, "main"=>"addform.tpl")); 
 $t->set_var(array("do"       => 'add',
				   "id"       => 1,
 				   "formname" => $_POST['formname'], 
				   "sitelist" => $sitelist,
				   "form_presets" => $form_presets,
				   "error"    => FormatError($error)));

 $t->set_var(array("path"    => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <span id=\"selected\">".$_LANG['msg_new']."</span>",
				   "path_info" => $_LANG['msg_form_new'],
				   "subheader_icon" => "images/application_form.png",
				   "uname"   => $uname));

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
            <td height="26"><strong>'.$_LANG['msg_error_message'].' :</strong><br>'.
            $msg.'</td>
            </tr>
            </table></td>
            </tr>
            </table></td>
            </tr>';
			
			return $error;
 }
}

function ShowEdit($error = "")
{
global $uid, $_LANG, $index2_tpl;
 
 $fid = intval($_GET['form']);
 
 $res = @mysql_query("SELECT name, site_id FROM forms WHERE id = ".$fid.";");
 $row = @mysql_fetch_row($res);
 
 $formname = (isset($_POST['formname'])) ? $_POST['formname'] : $row[0];
 $site_id  = $row[1];
 
 
 $res = @mysql_query("SELECT id, name FROM sites WHERE uid = ".$uid." ORDER BY name;");
 while ($row = mysql_fetch_row($res))
 {
  $selected  = ($site_id == $row[0]) ? ' selected' : '';
  $sitelist .= "<option value='".$row[0]."'".$selected.">".$row[1]."</option>\n";
 }
 
 $thx_check = (intval(@implode("",@mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM pages WHERE form_id = ".$fid." && thx = 1"))))==1) ? ' checked' : '';
 $preview_check = (intval(@implode("",@mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM pages WHERE form_id = ".$fid." && preview = 1"))))==1) ? ' checked' : ''; 
 
 $t = new Template("tpl");
 $t->set_file(array("page" => $index2_tpl, "main"=>"editform.tpl")); 
 $t->set_var(array("do"       => 'update&form='.$fid,
 				   "formname" => $formname, 
				   "sitelist" => $sitelist,
				   "thx_check" => $thx_check,
				   "preview_check" => $preview_check,
				   "error"    => FormatError($error)));

 $t->set_var(array("path"    => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <span id=\"selected\">".$_LANG['msg_preferences']."</span>",
				   "path_info" => $_LANG['msg_form_edit'],
				   "subheader_icon" => "images/application_form.png",
				   "uname"   => $uname));
 
 $t->set_var($_LANG);
 $t->parse("OUT", array("main","page"));
 $t->p("OUT");
}

function AddPresetForm()
{
  global $uid;
	
  $form_name	= $_POST['formname'];
  $site_id		= intval($_POST['siteid']);
  $preset		= intval($_POST['form_preset']);
  $is_preview	= ($_POST['preview_page'] == 1) ? 1 : 0;
  $is_thanku	= ($_POST['thkupage'] == 1) ? 1 : 0;
  
  // Add form
  
  srand(time());
  $dir = uniqid(md5(time()+rand(0,999999)));
  
  @mysql_query("INSERT INTO forms (name, dir, site_id, uid) VALUES ('".mysql_escape_string($form_name)."','".mysql_escape_string($dir)."',".$site_id.", ".$uid.");");
  $form_id = mysql_insert_id();
  
  // Add pages

  if ($site_id == 0)
  {
  			$res = @mysql_query("SELECT COUNT(*) FROM pages WHERE form_id = ".$form_id.";");
			$row = @mysql_fetch_row($res);
			
			if ($row[0] == 0)
			{
				$page_name = "index.html";	
			}
			else 
			{
				$page_name = "page".$row[0].".html";
			}

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
   
    		$path_to_serv = "http://".$_SERVER['SERVER_NAME'].$fullpath."/forms/".$dir."/";
    		$site_url = $path_to_serv.urlencode(str_replace(" ", "-", $form_name));
  }
  else 
  {
  	$site_url  = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM sites WHERE id = ".$site_id.";")));
  	$site_url  = ((strtolower(substr($site_url,0,7))=='http://')||(strtolower(substr($site_url,0,8))=='https://')) ? $site_url : 'http://'.$site_url;
  	$site_url .= ((substr($site_url,-1,1)=='/') ? '' : '/').urlencode(str_replace(" ", "-", $form_name));
  }

  $pt_pages_sql = "";
  
  if (($is_thanku == 1)&&($is_preview == 0))
  {
  	$pt_pages_sql = "&& preview = 0";
  }
  
  if (($is_thanku == 0)&&($is_preview == 1))
  {
  	$pt_pages_sql = "&& thx = 0";
  }

  if (($is_thanku == 0)&&($is_preview == 0))
  {
  	$pt_pages_sql = "&& preview = 0 && thx = 0";
  }
  
  $res = @mysql_query("SELECT id, name, pos, thx, preview FROM preset_pages WHERE form_id = ".$preset." ".$pt_pages_sql." ORDER BY pos;");
  while ($row = @mysql_fetch_row($res))
  {
	$page_url = $site_url."_".urlencode(str_replace(" ", "-", $row[1])).".html";
  	
  	@mysql_query("INSERT INTO pages (name, url, pos, form_id, thx, preview) VALUES ('".$row[1]."', '".mysql_escape_string($page_url)."', ".$row[2].", ".$form_id.", ".$row[3].", ".$row[4].");");
  	$page_id = @mysql_insert_id();
  	
  	// Add fields
  	$preset_page_id = $row[0];
  	$res2 = @mysql_query("SELECT id, title, name, type, size, pos, vals, req, valid FROM preset_flds WHERE page_id = ".$preset_page_id.";");
  	while ($row2 = @mysql_fetch_row($res2))
  	{
  		@mysql_query("INSERT INTO flds (title, name, type, size, pos, vals, req, valid, page_id) VALUES ('".mysql_escape_string($row2[1])."', '".mysql_escape_string($row2[2])."', ".$row2[3].", ".$row2[4].", ".$row2[5].", '".mysql_escape_string($row2[6])."', ".$row2[7].", ".$row2[8].", ".$page_id.");");	
  		$fields[$row2[0]] = @mysql_insert_id();
  	}
  }
  
  // Add error template
  
  $res = @mysql_query("SELECT data FROM preset_errors WHERE form_id = ".$preset.";");
  $row = @mysql_fetch_row($res);
  
  @mysql_query("INSERT INTO errors (data, form_id) VALUES ('".mysql_escape_string($row[0])."', ".$form_id.")");
  
  // Add email templates
  
  $res = @mysql_query("SELECT name, komu, cc, bcc, ot, subject, attach, format, body FROM preset_emails WHERE form_id = ".$preset.";");
  while ($row = @mysql_fetch_row($res))
  {
	@mysql_query("INSERT INTO emails (name, komu, cc, bcc, ot, subject, attach, format, body, form_id) VALUES ('".$row[0]."', '".$row[1]."', '".$row[2]."', '".$row[3]."', '".$row[4]."', '".$row[5]."', '".$row[6]."', '".$row[7]."', '".$row[8]."', ".$form_id.");");
  }
  
  // Add db templates
  
  $res = @mysql_query("SELECT name, flds FROM preset_dbs WHERE form_id = ".$preset.";");
  while ($row = @mysql_fetch_row($res))
  {
  			$db_flds = explode("|",$row[1]);
  			
			$tbl_id = intval(@implode(null,@mysql_fetch_row(@mysql_query("SELECT id FROM dbs ORDER BY id DESC LIMIT 1;"))));
			$tbl_id++;

			$dump = "CREATE TABLE user".$uid."_".$tbl_id." (\n".
			"id INT(32) auto_increment NOT NULL,\n";
			foreach($db_flds as $field_id)
			{
				$dump .= "`f".$fields[$field_id]."` blob, \n";
				$flds .= $fields[$field_id].'|';
			}

			$dump .= "PRIMARY KEY(id));";
			$flds = substr($flds,0,-1);

			@mysql_query("INSERT INTO dbs (name,tbl,flds, form_id) VALUES ('".mysql_escape_string($row[0])."','user".$uid."_".$tbl_id."','".mysql_escape_string($flds)."',".$form_id.");");

			@mysql_query($dump);
  }
  
   	Header("Location: formedit.php?form=".$form_id);
  	exit();
}

function DelForm($fid = 0)
{
 @mysql_query("DELETE FROM errors WHERE form_id= ".$fid.";");
 @mysql_query("DELETE FROM emails WHERE form_id = ".$fid.";");
  
 $res = @mysql_query("SELECT tbl FROM dbs WHERE form_id = ".$fid.";");

 if (@mysql_num_rows($res) > 0)
 {
  
 	while ($row = @mysql_fetch_row($res))
 	{
 		@mysql_query("DROP TABLE `".$row[0]."`;");
	}
}
 
 @mysql_query("DELETE FROM dbs WHERE form_id = ".$fid.";");
 
 $res = @mysql_query("SELECT id FROM pages WHERE form_id = ".$fid.";");
 while ($row = @mysql_fetch_row($res))
 {
	@mysql_query("DELETE FROM flds WHERE page_id = ".$row[0].";");
 }

 @mysql_query("DELETE FROM pages WHERE form_id = ".$fid.";");
 
 $res = @mysql_query("SELECT dir FROM forms WHERE id = ".$fid.";");
 if (@mysql_num_rows($res) == 1)
 {
	$row = mysql_fetch_row($res);
	deldir('forms/'.$row[0]); 
 }
 
 @mysql_query("DELETE FROM forms WHERE id = ".$fid.";");
}

?>
