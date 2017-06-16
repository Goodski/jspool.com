<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/generate.inc.php");

if (isset($_SESSION['codersess']))
{
 @mysql_query("DELETE FROM codersess WHERE id = '".$_SESSION['codersess']."';");
 @mysql_query("DELETE FROM codertmp WHERE sid = '".$_SESSION['codersess']."';");
 unset($_SESSION['codersess']);
}

if (!empty($_GET['delete']))
{
 	@mysql_query("DELETE FROM sites WHERE id = ".intval($_GET['delete'])." && uid = ".$uid.";");
 	@mysql_query("DELETE FROM forms WHERE site_id = ".intval($_GET['delete'])." && uid = ".$uid.";");
}

if ($_GET['do']=='delgroup')
{
 if (is_array($_POST['chk']))
 {
 	foreach($_POST['chk'] AS $sid)
	{
	 @mysql_query("DELETE FROM sites WHERE id = ".intval($sid)." && uid = ".$uid.";");
	 @mysql_query("DELETE FROM forms WHERE site_id = ".intval($sid)." && uid = ".$uid.";");
	}
 }
}

if (!empty($_GET['update']))
{
	   $error  = '';
	   $error .= (trim($_POST['sitename'])=='') ? "&nbsp;&nbsp;".$_LANG['msg_site_name_empty'].". <br>\n" : "";
	   $error .= (trim($_POST['siterefs'])=='') ? "&nbsp;&nbsp;".$_LANG['msg_site_reffs_empty'].". <br>\n" : "";
	   
	   $refs = explode(',',$_POST['siterefs']);
	   $refs = array_map("trim", $refs);
	   
	   foreach($refs as $ref)
	   {
   	    $fp = @fsockopen($ref,80,$eee,$eee,5);
	    if (!$fp)
		{
		  $error .= "&nbsp;&nbsp;".$ref.": ".$_LANG['msg_site_reff_invalid'].". <br>\n";
		}
	   }
	   
	   if (empty($error))
	   {
	    $site_id = intval($_GET['update']);
		
	    $site_name = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM sites WHERE id = ".$site_id.";")));
		
		$res = @mysql_query("select t1.id, t1.url from pages as t1, forms as t2 where t1.form_id = t2.id and t2.site_id = ".$site_id.";");
		while($row = @mysql_fetch_row($res))
		{
 			$new_url = str_replace($site_name,$_POST['sitename'],$row[1]);
			$r2 = @mysql_query("UPDATE pages SET url = '".mysql_escape_string($new_url)."' WHERE id=".$row[0].";");
		}
		
		$site_name = $_POST['sitename'];
		@mysql_query("UPDATE sites SET name = '".mysql_escape_string($site_name)."', refs = '".mysql_escape_string($_POST['siterefs'])."' WHERE id = ".intval($_GET['update']).";");
		
		$res = @mysql_query("SELECT id FROM forms WHERE site_id = ".intval($_GET['update']).";");
		while($row = @mysql_fetch_row($res))
		{
			$pgens = Generate($row[0]);
  			foreach($pgens AS $fl)
  			{
    		@unlink($fl);
  			}
		}
	   }
	   else
	   {
	    ShowEdit($error);
		exit();
	   }
}
 

if ($_GET['addnew']==1)
{
 ShowAdd();
}
else
{

if (!empty($_GET['edit']))
{
 ShowEdit();
}
else
{ 
     if ($_GET['add'] == 1)
	 {
	   $error  = '';
	   $error .= (trim($_POST['sitename'])=='') ? "&nbsp;&nbsp;".$_LANG['msg_site_name_empty'].". <br>\n" : "";
	   $error .= (trim($_POST['siterefs'])=='') ? "&nbsp;&nbsp;".$_LANG['msg_site_reffs_empty'].". <br>\n" : "";
	   
	   $refs = explode(',',$_POST['siterefs']);
	   $refs = array_map("trim", $refs);
	   
	   foreach($refs as $ref)
	   {
   	    $fp = @fsockopen($ref,80,$eee,$eee,5);
	    if (!$fp)
		{
		  $error .= "&nbsp;&nbsp;".$ref.": ".$_LANG['msg_site_reff_invalid'].". <br>\n";
		}
	   }

//	   $error = (mysql_num_rows(@mysql_query("SELECT * FROM sites;"))>=1) ? "Limit of site number exceeded. You can upgrade Form Maker Pro license at your <a href=\"http://web-site-scripts.com/member-area/login\" target=\"_blank\" title=\"Member Area\">Member Area</a> to increase number of supported websites" : $error;
	   if (empty($error))
	   {
	   	$site_name = $_POST['sitename'];
		@mysql_query("INSERT INTO sites (name,refs,uid) VALUES ('".mysql_escape_string($site_name)."','".mysql_escape_string($_POST['siterefs'])."',".$uid.");");
	   }
	   else
	   {
	    ShowAdd($error);
		exit();
	   }
	 }
	 
	  /* create an instance of Template with desired parameters */
	 $t = new Template("tpl");
  	 $t->set_file(array("page" => $index_tpl, "main"=>"sites.tpl"));		 
   	 $t->set_block("main","row","rows"); 
	 $t->set_var(array("path"    => $_LANG['msg_sites'],
					   "path_info" => $_LANG['msg_sites'],
					   "subheader_icon" => "images/server.png",
					   "uname"   => $uname,
					   "descr"	 => $_LANG['msg_sites_tip']));

	 $table = array();
	 $res = mysql_query("SELECT id, name FROM sites WHERE uid = ".$uid.";");
	 while($row = mysql_fetch_row($res))
	 {
	   $record = array();
	   
	   $record['id']	= $row[0];
	   $record['name']	= $row[1];
	   $record['forms']	= intval(@implode(NULL, @mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM forms WHERE site_id = ".$row[0].";"))));
	   
	   $table[] = $record;
	 }

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
	 	case 'forms':
	 		$order_by = 'forms';
	 		$t->set_var("sel1", $desc ? ' id="selected2"' : ' id="selected"');
	 		$t->set_var("direct1", $desc ? 'asc' : 'desc');
	 		$t->set_var("direct0", 'asc');
	 		break;
	 	default:
	 		$order_by = 'name';
	 		$t->set_var("sel0", $desc ? ' id="selected2"' : ' id="selected"');
	 		$t->set_var("direct0", $desc ? 'asc' : 'desc');
	 		$t->set_var("direct1", 'asc');
	 		break;
	 }
 
//////////////////////////////////////////////////////
	 
	$table = TableSorter($table, $order_by, $desc);
	
	$i = 0;
	foreach ($table AS $row)
	{
	
		$t->set_var(array("sitenum"  => $row['id'],
		   			      "sitename" => $row['name'], 
		  			      "form_num" => $row['forms'],
                          "class"	 => (is_int($i/2) ? " class=\"dataodd\"" : " bgcolor=\"#FFFFFF\"")));
						            
		$t->parse("rows", "row", true);
		$i++;
	}

	
	 $t->set_var("serv_form_num", intval(@implode(NULL, @mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM forms WHERE site_id = 0 && uid = ".$uid.";")))));
	 $t->set_var($_LANG);
	 $t->parse("OUT", array("main","page"));
     $t->p("OUT");
	 

}
}

function ShowAdd($error = '')
{
global $uname, $_LANG, $index2_tpl;
 $t = new Template("tpl");
 $t->set_file(array("page" => $index2_tpl, "main"=>"addsite.tpl")); 
 $t->set_var(array("do"       => 'add',
				   "id"       => 1,
 				   "sitename" => $_POST['sitename'], 
				   "sitesmtp" => $_POST['sitesmtp'],
				   "siterefs" => $_POST['siterefs'],
				   "error"    => FormatError($error),
				   "descr"	 => $_LANG['msg_add_new_site_tip']));
				   

	 $t->set_var(array("path"      => "<a href=\"sites.php\">".$_LANG['msg_sites']."</a> / <span id=\"selected\">".$_LANG['msg_new']."</span>",
					   "path_info" => $_LANG['msg_site_new'],
					   "subheader_icon" => "images/server.png",
					   "uname"     => $uname));
 
 $t->set_var($_LANG);				   
 $t->parse("OUT", array("main","page"));
 $t->p("OUT");
}

function ShowEdit($error = "")
{
global $uname, $_LANG, $index2_tpl;

 $_GET['edit'] = empty($_GET['edit']) ? $_GET['update'] : $_GET['edit'];
 
 $res = @mysql_query("SELECT name, refs FROM sites WHERE id = ".intval($_GET['edit']).";");
 $row = @mysql_fetch_row($res);
 
 $name = empty($error) ? $row[0] : $_POST['sitename'];
 $refs = empty($error) ? $row[1] : $_POST['siterefs'];
 
 $t = new Template("tpl");
 $t->set_file(array("page" => $index2_tpl, "main"=>"addsite.tpl")); 
 $t->set_var(array("do"        => 'update',
				   "id"        => intval($_GET['edit']),
 				   "sitename"  => $name, 
				   "sitesmtp"  => $smtp,
				   "siterefs"  => $refs,
				   "error"     => FormatError($error),
				   "descr"	 => $_LANG['msg_site_preferences_tip']));

	 $t->set_var(array("path"    => "<a href=\"sites.php\">".$_LANG['msg_sites']."</a> / <b>".$_LANG['msg_SITE'].":</b> ".$name." / <span id=\"selected\">".$_LANG['msg_preferences']."</span>",
					   "path_info" => $_LANG['msg_site_edit'],
					   "subheader_icon" => "images/server.png",
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
?>