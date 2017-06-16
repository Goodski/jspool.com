<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");

if (isset($_SESSION['codersess']))
{
 @mysql_query("DELETE FROM codersess WHERE id = '".$_SESSION['codersess']."';");
 @mysql_query("DELETE FROM codertmp WHERE sid = '".$_SESSION['codersess']."';");
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
 $error .= ((trim($_POST['redirect'])=='')&&($_POST['thkupage']!=1)) ? "Redirect URL is empty.<br>\n" : "";

  
 if (empty($error))
 {
  $site_id = intval($_POST['siteid']);
  $form_id = intval($_GET['form']);
  
  $last_site = intval(@implode(NULL, @mysql_fetch_row(@mysql_query("SELECT site_id FROM forms WHERE id = ".$form_id.";"))));
  
  $form_name = $_POST['formname'];
  $stop_time = ($_POST['stopcheck'] == 1) ? intval(@mktime(0,0,0,$_POST['stop_month'], $_POST['stop_day'], $_POST['stop_year'])) : 0;
  @mysql_query("UPDATE forms SET name = '".mysql_escape_string($form_name)."', site_id = ".$site_id.", redirect = '".mysql_escape_string($_POST['redirect'])."', stoptime = ".$stop_time.", us=".intval($_POST['unique'])." WHERE id=".intval($_GET['form']).";");
  
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
   		
   if ($_POST['siteid'] > 0)
   {
   	$site_id  = intval($_POST['siteid']);
   	$site_url = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM sites WHERE id = ".$site_id.";")));
   	$site_url  = ((strtolower(substr($site_url,0,7))=='http://')||(strtolower(substr($site_url,0,8))=='https://')) ? $site_url : 'http://'.$site_url;
   	$site_url .= ((substr($site_url,-1,1)=='/') ? '' : '/').EscapeFileString($_POST['formname'], true);
   	$preview_url = $site_url."_preview.html";
   }
   else 
   {
		//$preview_url = $path_to_serv.EscapeFileString($_POST['formname'], true)."_preview.html";
		$preview_url = $path_to_serv.EscapeFileString($_POST['formname'], true)."_preview.html";
   }

		@mysql_query("INSERT INTO pages (name,url,pos,form_id, preview, subtext) VALUES ('Preview', '".$preview_url."',".$prev_pos.",".$form_id.", 1, 'Submit');");
		@mysql_query("UPDATE pages SET pos = (pos+1) WHERE form_id = ".$form_id." AND thx = 1;");
   	}
  }
  
  UpdateLabels($form_id);
  ////////////////////////////////////////////////////////////////
  
  
  if ($_POST['thkupage'] != 1)
  {
   @mysql_query("DELETE FROM pages WHERE thx=1 && form_id = ".$form_id.";");
  }
  else
  {
   if (intval(@implode("",@mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM pages WHERE form_id = ".$form_id." && thx = 1"))))==0)
   {
   	
   if ($_POST['siteid'] > 0)
   {
    $site_id  = intval($_POST['siteid']);
    $site_url = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM sites WHERE id = ".$site_id.";")));
    $site_url  = ((strtolower(substr($site_url,0,7))=='http://')||(strtolower(substr($site_url,0,8))=='https://')) ? $site_url : 'http://'.$site_url;
    $site_url .= ((substr($site_url,-1,1)=='/') ? '' : '/').EscapeFileString($_POST['formname'], true);
    $thx_url = $site_url."_thanks.html";
   }
   else 
   {
   	$thx_url = $path_to_serv.EscapeFileString($_POST['formname'], true)."_thanks.html";
   }
    
   $thx_pos = intval(@implode("",@mysql_fetch_row(@mysql_query("SELECT MAX(pos) FROM pages WHERE form_id = ".$form_id.";"))))+1;
   @mysql_query("INSERT INTO pages (name,url, pos, form_id, thx) VALUES ('Thanks', '".$thx_url."', ".$thx_pos.",".$form_id.", 1);");
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
	
	UpdateLabels($form_id);
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit();
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
  $form_name = $_POST['formname'];
  
  $stop_time = ($_POST['stopcheck'] == 1) ? intval(@mktime(0,0,0,$_POST['stop_month'], $_POST['stop_day'], $_POST['stop_year'])) : 0;
  
  @mysql_query("INSERT INTO forms (name, dir, site_id, redirect, stoptime, us, uid) VALUES ('".mysql_escape_string($form_name)."', '".$form_code."', ".intval($_POST['siteid']).", '".mysql_escape_string($_POST['redirect'])."', ".$stop_time.", ".intval($_POST['unique']).", ".$uid.");");
  $fid = @mysql_insert_id();
  
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
   	$site_url .= ((substr($site_url,-1,1)=='/') ? '' : '/').EscapeFileString($_POST['formname'], true);
   	$preview_url = $site_url."_preview.html";
   }
   else 
   {
		$preview_url = $path_to_serv.EscapeFileString($_POST['formname'], true)."_preview.html";
   }

   @mysql_query("INSERT INTO pages (name,url,pos,form_id, preview, subtext) VALUES ('Preview', '".mysql_escape_string($preview_url)."',1,".$fid.", 1, 'Submit');");
   $posit++;
  }

  if ($_POST['thkupage']==1)
  {
   if ($_POST['siteid'] > 0)
   {
    $site_id  = intval($_POST['siteid']);
    $site_url = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM sites WHERE id = ".$site_id.";")));
    $site_url  = ((strtolower(substr($site_url,0,7))=='http://')||(strtolower(substr($site_url,0,8))=='https://')) ? $site_url : 'http://'.$site_url;
    $site_url .= ((substr($site_url,-1,1)=='/') ? '' : '/').EscapeFileString($_POST['formname'], true);
    $thx_url = $site_url."_thanks.html";
   }
   else 
   {
   	$thx_url = $path_to_serv.EscapeFileString($_POST['formname'], true)."_thanks.html";
   }

   @mysql_query("INSERT INTO pages (name,url,pos,form_id, thx) VALUES ('Thanks', '".$thx_url."',".$posit.",".$fid.", 1);");
   $paid = @mysql_insert_id();
   @mysql_query("INSERT INTO flds (id, title,name,type,size,pos,vals,req,valid,page_id) VALUES ('".(substr(uniqid(md5(microtime().rand(0,99999)),TRUE),0,8))."', '','',7,0,1,'<h1 align=\"center\">Thank you for your submission</h1>',0,0,".$paid.");");
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
  	 $t->set_file(array("page" => $index_tpl, "main"=>"forms.tpl"));		 
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
	 $res = @mysql_query("SELECT id, name, style FROM forms WHERE site_id = 0 && uid = ".$uid.";");
	 while ($row = @mysql_fetch_row($res))
	 {
		$arr				= @mysql_fetch_row(@mysql_query("SELECT url FROM pages WHERE pos=1 AND form_id=".$row[0].";"));
	 	$record				= array();
	 	$record['id']		= $row[0];
	 	$record['name']		= $row[1];
		$record['url']		= $arr[0];
	 	$record['style']	= empty($row[2]) ? "&nbsp;" : "<img src=\"images/style.png\" alt=\"".$_LANG['msg_styled']."\">";
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
		$t->set_var("url",			$record['url']);
	 	$t->set_var("style_img",	$record['style']);
	 	$t->set_var("pages_num",	$record['pages']);
	 	$t->set_var("is_preview",	($record['is_prev'] == 1	? "Yes" : "No"));
	 	$t->set_var("is_thx",		($record['is_thx'] == 1		? "Yes" : "No"));
	 	$t->set_var("emails_num",	$record['emails']);
	 	$t->set_var("dbs_num",		$record['dbs']);
	 	$t->set_var("cell",			((is_int($l++/2)) ? 'class="dataodd"' : ' bgcolor="#FFFFFF"'));
	 	
	 	$t->parse("serv_rows", "serv_row", true);
	 }
	 
	 $res = @mysql_query("SELECT id, name FROM sites WHERE uid = ".$uid."  ORDER BY name;");
	 while ($row = @mysql_fetch_row($res))
	 {
		$table = array();
		
	    $res2 = mysql_query("SELECT id, name, style FROM forms WHERE site_id = ".$row[0]."  && uid = ".$uid." ORDER BY name;");
		while ($row2 = mysql_fetch_row($res2))
		{
			$arr				= @mysql_fetch_row(@mysql_query("SELECT url FROM pages WHERE pos=1 AND form_id=".$row2[0].";"));
	         $record			= array();
	         $record['id']		= $row2[0];
	         $record['name']	= $row2[1];
			$record['url']		= $arr[0];
	         $record['style']	= empty($row2[2]) ? "&nbsp;" : "<img src=\"images/style.png\">";
	         $record['pages']	= intval(@implode(NULL, @mysql_fetch_row( @mysql_query("SELECT COUNT(*) FROM pages WHERE thx=0 && preview = 0 && form_id = ".$row2[0].";") )));
       	 	 $record['is_prev']	= intval(@implode(NULL, @mysql_fetch_row( @mysql_query("SELECT COUNT(*) FROM pages WHERE thx=0 && preview = 1 && form_id = ".$row2[0].";") )));
		 	 $record['is_thx']	= intval(@implode(NULL, @mysql_fetch_row( @mysql_query("SELECT COUNT(*) FROM pages WHERE thx=1 && preview = 0 && form_id = ".$row2[0].";") )));
	         $record['emails']	= intval(@implode(NULL, @mysql_fetch_row( @mysql_query("SELECT COUNT(*) FROM emails WHERE form_id = ".$row2[0].";") )));
	         $record['dbs']		= intval(@implode(NULL, @mysql_fetch_row( @mysql_query("SELECT COUNT(*) FROM dbs WHERE form_id = ".$row2[0].";") )));
	         
	         $table[] = $record;
		}
		
		$table = TableSorter($table, $order_by, $desc);
		
		$forms = '';
		$i = 0;
		
		foreach ($table as $record)
		{
			$forms .= "<tr ".((is_int($i/2)) ? 'class="dataodd"' : ' bgcolor="#FFFFFF"').">\n";
			$forms .= "<td class=\"f\"><input type=\"checkbox\" name=\"chk[]\" value=\"".$record['id']."\"></td>\n";
			$forms .= "<td>".$record['style']."</td>\n";
			$forms .= "<td><strong><a href=\"formedit.php?form=".$record['id']."\" title=\"".$_LANG['msg_edit']."\">".$record['name']."</a></strong></td>\n";
			
			$forms .= "<td>".$record['pages']."</td>";
			$forms .= "<td>".($record['is_prev'] == 1	? "Yes" : "No")."</td>";
			$forms .= "<td>".($record['is_thx'] == 1	? "Yes" : "No")."</td>";
			$forms .= "<td>".$record['emails']."</td>";
			$forms .= "<td>".$record['dbs']."</td>";
			
			$forms .= "<td align=center nowrap><a href=\"formedit.php?form=".$record['id']."\" class=\"slink\" title=\"".$_LANG['msg_edit']."\"><img src=\"images/page_edit.png\" alt=\"".$_LANG['msg_edit']."\" width=\"16\" height=\"16\" hspace=\"1\" border=\"0\" align=\"top\">".$_LANG['msg_edit']."&nbsp;</a><a href='".$record['url']."' target='blank' class='slink' title='".$record['url']."'><img src='images/magnifier.png' alt='".$_LANG['msg_go_to_1st_page']."' align='top' border='0' height='16' hspace='1' width='16'>".$_LANG['msg_go_to_1st_page']."&nbsp;</a><a href='forms.php?do=edit&form=".$record['id']."' title='".$_LANG['msg_preferences']."' class=\"slink\"><img src=\"images/cog.png\" alt=\"".$_LANG['msg_preferences']."\" width=\"16\" height=\"16\" hspace=\"1\" border=\"0\" align=\"top\">".$_LANG['msg_preferences']."&nbsp;</a> <a href=# onclick=\"javascript: conf('forms.php?do=delete&form=".$record['id']."');\" class=\"slink\" title=\"".$_LANG['msg_Delete']."\"><img src=\"images/delete.png\" alt=\"".$_LANG['msg_Delete']."\" width=\"16\" height=\"16\" hspace=\"1\" border=\"0\" align=\"top\">".$_LANG['msg_Delete']."&nbsp;</a></td></tr>\n";
	        $i++;  
		}
		
		$t->set_var(array("siteid"   => $row[0],
		                  "sitename" => $row[1],
						  "forms"    => $forms));
		
			$t->set_var("linef1", '<br>');
			$t->set_var("linef2", '<br><img src="images/1x1.gif" width="1" height="3"><br>');

		
		$t->parse("rows","row",true);
	 }
	 
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
 
 for ($i=1;$i<13;$i++)
 {
 	$checked = $_POST['stop_month'] == $i ? " selected" : "";
 	$stop_month .= "<option value=".$i.$checked.">".$_LANG['MONTH'][$i]."</option>\n";
 }

 for ($i=1;$i<32;$i++)
 {
 	$checked = $_POST['stop_day'] == $i ? " selected" : "";
 	$stop_day .= "<option value=".$i.$checked.">".$i."</option>\n";
 }
 
 for ($i=2007;$i<2014;$i++)
 {
 	$checked = $_POST['stop_year'] == $i ? " selected" : "";
 	$stop_year .= "<option value=".$i.$checked.">".$i."</option>\n";
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
				   "uname"   => $uname,
					"descr"	 => $_LANG['msg_form_add_tip']));
 
$t->set_var(array(	"redirect"		=> htmlspecialchars($_POST['redirect']),
					"stop_check"	=> ($_POST['stopcheck'] == 1 ? "checked" : ""),
					"stop_month"	=> $stop_month,
 					"stop_day"		=> $stop_day,
 					"stop_year"		=> $stop_year,
 					"unique"		=> ($_POST['unique'] == 1 ? " checked" : "")));
 $t->set_var("referer", $_SERVER['HTTP_REFERER']); 					
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
 
 $res = @mysql_query("SELECT name, site_id, redirect, stoptime, us FROM forms WHERE id = ".$fid.";");
 $row = @mysql_fetch_array($res);
 
 $formname = (isset($_POST['formname'])) ? $_POST['formname'] : $row[0];
 $site_id  = $row[1];
 
 
 $res2 = @mysql_query("SELECT id, name FROM sites WHERE uid = ".$uid." ORDER BY name;");
 while ($row2 = mysql_fetch_row($res2))
 {
  $selected  = ($site_id == $row2[0]) ? ' selected' : '';
  $sitelist .= "<option value='".$row2[0]."'".$selected.">".$row2[1]."</option>\n";
 }
 
 $thx_check = (intval(@implode("",@mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM pages WHERE form_id = ".$fid." && thx = 1"))))==1) ? ' checked' : '';
 $preview_check = (intval(@implode("",@mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM pages WHERE form_id = ".$fid." && preview = 1"))))==1) ? ' checked' : ''; 
 
 for ($i=1;$i<13;$i++)
 {
 	$checked = ((date("n", $row['stoptime']) == $i)&&($row['stoptime'] > 0)) ? " selected" : "";
 	$stop_month .= "<option value=".$i.$checked.">".$_LANG['MONTH'][$i]."</option>\n";
 }

 for ($i=1;$i<32;$i++)
 {
 	$checked = ((date("j", $row['stoptime']) == $i)&&($row['stoptime'] > 0)) ? " selected" : "";
 	$stop_day .= "<option value=".$i.$checked.">".$i."</option>\n";
 }
 
 for ($i=2007;$i<2014;$i++)
 {
 	$checked = ((date("Y", $row['stoptime']) == $i)&&($row['stoptime'] > 0)) ? " selected" : "";
 	$stop_year .= "<option value=".$i.$checked.">".$i."</option>\n";
 }
 
 if (empty($row['redirect']))
 {
 	$rres = @mysql_query("SELECT url FROM pages WHERE form_id = ".$fid." ORDER BY pos LIMIT 1;");	
 	$rrow = @mysql_fetch_row($rres);
 	$redir = $rrow[0];
 }
 else 
 {
 	$redir = $row['redirect'];
 }
 
 $t = new Template("tpl");
 $t->set_file(array("page" => $index2_tpl, "main"=>"editform.tpl")); 
 $t->set_var(array("do"       => 'update&form='.$fid,
 				   "formname" => $formname, 
				   "sitelist" => $sitelist,
				   "thx_check" => $thx_check,
				   "preview_check" => $preview_check,
				   "redirect"	=> $redir,
				   "error"    => FormatError($error)));
 $t->set_var(array(	"stop_month"	=> $stop_month,
 					"stop_day"		=> $stop_day,
 					"stop_year"		=> $stop_year,
 					"stopcheck"		=> ($row['stoptime']>0) ? " checked" : "",
 					"unique"		=> ($row['us'] == 1 ? " checked" : "")));				   
				   
 $t->set_var(array("path"    => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <span id=\"selected\"> Form ".$_LANG['msg_preferences']."</span>",
				   "path_info" => $_LANG['msg_form_preferences_page'],
				   "subheader_icon" => "images/application_form.png",
				   "uname"   => $uname,
					"descr"	 => $_LANG['msg_form_preferences_tip']));
 
 $t->set_var("referer", $_SERVER['HTTP_REFERER']); 	
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
  
  
  $stop_time = ($_POST['stopcheck'] == 1) ? intval(@mktime(0,0,0,$_POST['stop_month'], $_POST['stop_day'], $_POST['stop_year'])) : 0;
  @mysql_query("INSERT INTO forms (name, dir, site_id, redirect, stoptime, us, uid) VALUES ('".mysql_escape_string($form_name)."','".mysql_escape_string($dir)."',".$site_id.", '".mysql_escape_string($_POST['redirect'])."', ".$stop_time.", ".intval($_POST['unique']).", ".$uid.");");
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
  	
  	@mysql_query("INSERT INTO pages (name, url, pos, form_id, thx, preview, subtext) VALUES ('".$row[1]."', '".mysql_escape_string($page_url)."', ".$row[2].", ".$form_id.", ".$row[3].", ".$row[4].", '".($row[4]==1 ? 'Submit' : 'Send')."');");
  	$page_id = @mysql_insert_id();
  	
  	// Add fields
  	$preset_page_id = $row[0];
  	$res2 = @mysql_query("SELECT id, title, name, type, size, pos, vals, req, valid FROM preset_flds WHERE page_id = ".$preset_page_id.";");
  	
  	while ($row2 = @mysql_fetch_row($res2))
  	{
  		$tokenid = substr(uniqid(md5(microtime().$row2[1]),TRUE),0,8);
  		@mysql_query("INSERT INTO flds (id, title, name, type, size, pos, vals, req, valid, page_id) VALUES ('".$tokenid."', '".mysql_escape_string($row2[1])."', '".mysql_escape_string($row2[2])."', ".$row2[3].", ".$row2[4].", ".$row2[5].", '".mysql_escape_string($row2[6])."', ".$row2[7].", ".$row2[8].", ".$page_id.");");	
  		$fields[$row2[0]] = $tokenid;
  	}
  	
  	  	$res3 = @mysql_query("SELECT id, vals FROM flds WHERE type = 8 && page_id = ".$page_id.";");
  		while ($row3 = @mysql_fetch_row($res3))
	  	{
  			foreach ($fields as $key=>$val)  	
  			{
				$row3[1] = str_replace("||".$key."||", "||".$val."||", $row3[1]);
  			}
	  		@mysql_query("UPDATE flds SET vals = '".$row3[1]."' WHERE id = '".$row3[0]."';");
	  	}

  }
  
  // Updating calculations

  
  UpdateLabels($form_id);
  
  // Add email templates
  
  $res = @mysql_query("SELECT name, komu, cc, bcc, ot, subject, attach, format, body, preset FROM preset_emails WHERE form_id = ".$preset.";");
  while ($row = @mysql_fetch_row($res))
  {
	@mysql_query("INSERT INTO emails (name, komu, cc, bcc, ot, subject, attach, format, body, form_id, preset) VALUES ('".$row[0]."', '".$row[1]."', '".$row[2]."', '".$row[3]."', '".$row[4]."', '".$row[5]."', '".$row[6]."', ".intval($row[7]).", '".$row[8]."', ".$form_id.", ".$row[9].");");
  }
  
  // Add db templates
  
  $res = mysql_query("SELECT name, flds, display, show_ip, show_ref, show_date, show_time FROM preset_dbs WHERE form_id = ".$preset.";");

  while ($row = mysql_fetch_row($res))
  {
  			$db_flds = explode("|",$row[1]);
  			$db_display = explode("|", $row[2]);
  			
		$res2 = mysql_query("SHOW TABLE STATUS FROM `".DB_DATABASE."` LIKE 'dbs'");
		$row2 = mysql_fetch_array($res2);
		$tbl_id = $row2['Auto_increment'];

			$i=0;
			$dump = "CREATE TABLE user".$uid."_".$tbl_id." (\n".
					"id INT(32) auto_increment NOT NULL,\n";
			foreach($db_flds as $field_id)
			{
				$dump .= "`f".$i."` blob, \n";
				$flds .= $fields[$field_id].'|';
				$i++;
			}
			
			$dump .= "comments TEXT,\n";
			$dump .= "ip varchar(255),\n";
			$dump .= "referer varchar(255),\n";
			$dump .= "date varchar(255),\n";
			$dump .= "time varchar(255),\n";
			$dump .= "PRIMARY KEY(id));";
			$flds = substr($flds,0,-1);

			foreach ($db_display as $fi_id)
			{
				$display .= $fields[$fi_id].'|';	
			}
			$display = substr($display,0,-1);
			
			@mysql_query("INSERT INTO dbs (name,tbl,flds, display, show_ip, show_ref, show_date, show_time, form_id) VALUES ('".mysql_escape_string($row[0])."','user".$uid."_".$tbl_id."','".mysql_escape_string($flds)."', '".mysql_escape_string($display)."', ".intval($row[3]).", ".intval($row[4]).", ".intval($row[5]).", ".intval($row[6]).", ".$form_id.");");

			mysql_query($dump);
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

 // Bug fixed 21.10.05 by Rosty Kerei <rosty.kerei@gmail.com>
 $res = @mysql_query("SELECT dir FROM forms WHERE id = ".$fid.";");
 if (@mysql_num_rows($res) == 1)
 {
 	$row = @mysql_fetch_row($res);
 	deldir('forms/'.$row[0]);
 }
 
 @mysql_query("DELETE FROM forms WHERE id = ".$fid.";");
 
 }
?>
