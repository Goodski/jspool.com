<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/generate.inc.php");

$form_id = intval($_GET['form']);
if ($form_id<1) { Header("Location: forms.php"); exit(); }

	/**
	 * Security wall
	 */
	if (mysql_num_rows(@mysql_query("SELECT id FROM forms WHERE id = ".$form_id." && uid = ".$uid.";")) == 0)
	{
		Header("Location: forms.php");
		exit();
	}
	
if (!empty($_GET['move']))
{
MovePages();
}

if (!empty($_GET['delete']))
{
DeletePage();
}

if ($_GET['do'] == 'grouphtmldel')
{
 DeleteHTMLgroup();
}

if ($_GET['do'] == 'grouptpldel')
{
 DeleteTPLgroup();
}

if ($_GET['do'] == 'rediredit')
{
	@mysql_query("UPDATE forms SET redirect = '".mysql_escape_string($_GET['url'])."' WHERE id = ".$form_id.";");
}

$pgens = Generate($form_id);
  foreach($pgens AS $fl)
  {
    @unlink($fl);
  }

$pages = mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM pages WHERE form_id = ".$form_id.";"));

$res = mysql_query("SELECT name, site_id, redirect FROM forms WHERE id = ".$form_id.";");
$row = mysql_fetch_row($res);

$fname = $row[0];
$site_id = $row[1];
$redir_url = $row[2];

	$tpage = "forminside.tpl";
	if ($site_id == 0)
	{
		$hnum = "3";	
	}
	else 
	{
		$hnum = "2";
	}

if ($_GET['orderby']=='type')
{
 $order_field = 'tpltype';
 $tpl_o_id1 = '';
 $tpl_o_id2 = ' id="selected"';
}
else
{
 $order_field = 'n2';
 $tpl_o_id1 = ' id="selected"';
 $tpl_o_id2 = '';
}

	 $t = new Template("tpl");
  	 $t->set_file(array("page" => $index_tpl, "main"=>$tpage, "buttons" => "formedit.buttons".$hnum.".tpl"));		 
     $t->set_block("main", "row_htmlf", "rows_htmlf");
     $t->set_block("buttons", "row_msg", "row_msgs");
     $t->set_var("formsn","images/title-form.gif"); 
     
     $t->set_var(array("form_name"  => $fname,
					   "path"       => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <span id=\"selected\"><b>".$_LANG['msg_FORM'].":</b> ".$fname."</span>",
					   "path_info"  => $fname,
					   "subheader_icon" => "images/application_form.png",
					   "descr"      => $_LANG['msg_pages_tip'],
						"uname"     => $uname,
						"tpl_o_id1" => $tpl_o_id1,
						"tpl_o_id2" => $tpl_o_id2));

	 $is_thx = intval(@implode("",@mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM pages WHERE (thx = 1 || preview = 1) && form_id = ".$form_id.";"))));
	 
	 $l = 0; 
	 $thx_page = 0;
	 $first_url = "";
	 $res = @mysql_query("SELECT id, name, url, thx, preview FROM pages WHERE form_id = ".$form_id." ORDER BY pos;");
	 $num = @mysql_num_rows($res)-($is_thx+1);
	 while($row = @mysql_fetch_row($res))
	 {
	   $up   = (($l==0)||($row[3]==1)||($row[4]==1))    ? '' : '<a href="formedit.php?form='.$form_id.'&page='.$row[0].'&move=up"><img src="images/icon-arrow-up.gif" alt="'.$_LANG['msg_up'].'" width="13" height="13" hspace="1" border="0"></a>';
	   $down = (($l==$num)||($row[3]==1)||($row[4]==1)) ? '' : '<a href="formedit.php?form='.$form_id.'&page='.$row[0].'&move=down"><img src="images/icon-arrow-down.gif" alt="'.$_LANG['msg_down'].'" width="13" height="13" hspace="1" border="0"></a>';
	   $first_url = empty($first_url) ? $row[2] : $first_url;
	   
	   $udal = (empty($up)) ? "right" : "left";
	   	   
	   $rowclass = (is_int($l++/2) ? " class=\"dataodd\"" : " bgcolor=\"#FFFFFF\"");

	   if (($row[3]==1)||($row[4]==1))
	   {
	   	$rowclass = " class=\"iselected\"";
		$l++;
	   }
	   
	   if ($row[4] == 1)
	   {
	   		$open_button = '<img src="images/1x1.gif" width="16" height="16" hspace="1" border="0">';
	   		$page_name = '<a href="#" onclick="javascript: window.open('."'wideform.php?page=".$row[0]."','_blank','height=400,width=600,toolbar=no,status=no,scrollbars=yes,resizable=yes,menubar=no,location=no,direction=no'".')">'.$row[1]."</a>";
	   }
	   else 
	   {
	   		$open_button = '<a href="coder.php?page='.$row[0].'" class="slink" title="'.$_LANG['msg_edit'].'"><img src="images/application_form_edit.png" alt="'.$_LANG['msg_edit'].'" width="16" height="16" hspace="1" border="0" align="top">'.$_LANG['msg_edit'].'&nbsp;</a>';
	   		$page_name = '<a href="coder.php?page='.$row[0].'">'.$row[1]."</a>";
	   }
	   
	   $t->set_var(array("pageid"    => $row[0],
	   					 "page_name" => $page_name,
						 "pageurl"   => ($site_id == 0) ? "Page is located on Form Maker Pro server" : urldecode($row[2]),
						 "pageurl2"  => $row[2],
	   					 "class"	 => $rowclass,
	   					 "open"		 => $open_button,
						 "up"		 => $up,
						 "down"		 => $down,
						 "udal"		 => $udal,
						 "prew_ico"	 => "<a href=\"#\" class=\"slink\" onclick=\"javascript:  window.open('wideform.php?page=".$row[0]."','_blank','height=400,width=600,toolbar=no,status=no,scrollbars=yes,resizable=yes,menubar=no,location=no,direction=no')\"><img src=\"images/magnifier.png\" alt=\"".$_LANG['msg_preview']."\" width=\"16\" height=\"16\" hspace=\"1\" border=\"0\" align=\"top\">".$_LANG['msg_preview']."&nbsp;</a>",
						 "edit_ico"	 => "<a href=\"addpage.php?do=edit&page=".$row[0]."&form=".$form_id."\" class=\"slink\" title=\"".$_LANG['msg_preferences']."\"><img src=\"images/cog.png\" alt=\"".$_LANG['msg_preferences']."\" width=\"16\" height=\"16\" hspace=\"1\" border=\"0\" align=\"top\">".$_LANG['msg_preferences']."&nbsp;</a>",
						 "del_ico"	 => "<a href=\"javascript: conf('formedit.php?form=".$form_id."&delete=".$row[0]."');\" title=\"".$_LANG['msg_Delete']."\" class=\"slink\"><img src=\"images/delete.png\" alt=\"".$_LANG['msg_Delete']."\" width=\"16\" height=\"16\" hspace=\"1\" border=\"0\" align=\"top\">".$_LANG['msg_Delete']."&nbsp;</a>"));
						 
	   $t->parse("rows_htmlf", "row_htmlf", true);
	   
	   $t->set_var(array("msg_name" => $row[1],
	   					 "msg_url"  => urldecode($row[2])));

	   $t->parse("row_msgs", "row_msg", true);
	   $thx_page = $row[3]==1 ? $thx_page+1 : $thx_page;
	 }
	 $l = 0;
	 $t->set_block("main", "row", "rows");
	 
	 
	 if ($thx_page == 0)
	 {
	 	$sres = @mysql_query("SELECT name FROM sites WHERE id = ".$site_id.";");
	 	$srow = @mysql_fetch_row($sres);
	 	$site_name = $srow[0];
	 	
	 	$first_url = empty($redir_url) ? ($site_id == 0 ? $first_url : $site_name) : $redir_url;
  		$first_url = ((substr(strtolower($first_url), 0, 7) != 'http://') && (substr(strtolower($first_url), 0, 8) != 'https://')) ? "http://".$first_url : $first_url;
  
		$t->set_var(array(	"pageid"     => 0,
							"page_name"  => "Redirect",
						 	"pageurl"    => ($site_id == 0 && empty($redir_url)) ? "First form's page" : $first_url,
						 	"pageurl2"   => $first_url,
	   					 	"class"	 	 => " class=\"iselected\"",
	   					 	"open"		 => "",
						 	"up"		 => "",
						 	"down"		 => "",
						 	"udal"		 => "right",
						 	"prew_ico"	 => "",
							"edit_ico"	 => "<a href=\"#\" onclick=\"redir_edit();\" class=\"slink\" title=\"".$_LANG['msg_preferences']."\"><img src=\"images/cog.png\" alt=\"".$_LANG['msg_preferences']."\" width=\"16\" height=\"16\" hspace=\"1\" border=\"0\">".$_LANG['msg_preferences']."&nbsp;</a>",
							"del_ico"	 => ""));
						 
		$t->parse("rows_htmlf", "row_htmlf", true);

		$t->set_var("redir_url", $first_url);	
	 }
	 
	 
	 $tpl_arr = array();
	 
	 $res = @mysql_query("SELECT id, name FROM emails WHERE form_id = ".$form_id." ORDER BY name;");
	 while($row = @mysql_fetch_row($res))
	 {
	  $tpl_arr[] = array("tplname" => $row[1],
	                    "tpltype" => $_LANG['msg_email'],
						"script"  => 'mail',
						"tplid"   => $row[0],
						"element" => 'email',
						"n2"      => $row[1]);
	 }

	 $res = @mysql_query("SELECT id, name FROM dbs WHERE form_id = ".$form_id." ORDER BY name;");
	 while($row = @mysql_fetch_row($res))
	 {
	  $tpl_arr[] = array("tplname" => $row[1].'</a></strong> <a class="nlink" href="browse.php?form='.$form_id.'&id='.$row[0].'">[browse]<strong>',
	                    "tpltype" => $_LANG['msg_log'],
						"script"  => 'db',
						"tplid"   => $row[0],
						"element" => 'db',
						"n2"      => $row[1]);
	 }
	 
	 $tpl_arr = SortTable($tpl_arr,$order_field);
	 foreach($tpl_arr as $tpl_row)
	 {
	  $t->set_var($tpl_row);
	  $t->set_var("class",(is_int($l++/2) ? " class=\"dataodd\"" : " bgcolor=\"#FFFFFF\""));
	  $t->parse("rows","row",true);
	 }
	 	 	 
	 $t->set_var(array("formid"=>$form_id));	

	 $t->set_var($_LANG);
	 $t->parse("BUTTONSBLOCK", "buttons"); 
	 $t->parse("OUT", array("main", "page"));
     $t->p("OUT");
	 
function MovePages()
{
 $page = intval($_GET['page']);
 $form = intval($_GET['form']);
 
 $pos = @mysql_fetch_row(@mysql_query("SELECT pos FROM pages WHERE id = ".$page.";"));
 $pos = $pos[0];
 
 $max = @mysql_fetch_row(@mysql_query("SELECT MAX(pos) FROM pages WHERE form_id = ".$form.";"));
 $max = $max[0];

 if ($_GET['move']=='up')
 {
  if ($pos>1)
  {
  $res = @mysql_query("SELECT id FROM pages WHERE pos = ".($pos-1)." AND form_id = ".$form.";");
  $row = @mysql_fetch_row($res);
  @mysql_query("UPDATE pages SET pos = (pos-1) WHERE id = ".$page.";");
  @mysql_query("UPDATE pages SET pos = (pos+1) WHERE id = ".$row[0].";");
  }
 }
 else
 {
  if ($pos<$max)
  {
  $res = @mysql_query("SELECT id FROM pages WHERE pos = ".($pos+1)." AND form_id = ".$form.";");
  $row = @mysql_fetch_row($res);
  @mysql_query("UPDATE pages SET pos = (pos+1) WHERE id = ".$page.";");
  @mysql_query("UPDATE pages SET pos = (pos-1) WHERE id = ".$row[0].";");
  }
 }
 
 UpdateLabels($form);
}

function DeletePage()
{
 $page = intval($_GET['delete']);
 $res = @mysql_query("SELECT pos, form_id FROM pages WHERE id = ".$page.";");
 $row = @mysql_fetch_row($res);
 @mysql_query("DELETE FROM pages WHERE id = ".$page.";");
 #<fix 2008 03 11 (delete thank you page when deleting it)
 #@mysql_query("DELETE FROM flds WHERE page_id = ".$page." AND type = 7;");
 #>fix 2008 03 11
 @mysql_query("UPDATE pages SET pos = (pos-1) WHERE pos>".$row[0]." AND form_id = ".$row[1].";");
 UpdateLabels($row[1]);
}

function DeleteHTMLgroup()
{
 if (is_array($_POST['chk']))
 {
   foreach($_POST['chk'] as $pid)
   {
	 $page = intval($pid);
	 $res = @mysql_query("SELECT pos, form_id FROM pages WHERE id = ".$page.";");
	 $row = @mysql_fetch_row($res);
	 @mysql_query("DELETE FROM pages WHERE id = ".$page.";");
	 @mysql_query("UPDATE pages SET pos = (pos-1) WHERE pos>".$row[0]." AND form_id = ".$row[1].";");
	 UpdateLabels($row[1]);
   }
 }
}

function DeleteTPLgroup()
{
 if (is_array($_POST['chk']))
 {
   foreach($_POST['chk'] as $pid)
   {
	 $tpl = explode(":",$pid);
	 
	 switch($tpl[0])
	 {
		case 'email':
			@mysql_query("DELETE FROM emails WHERE id = ".intval($tpl[1]).";");
			break;
		case 'db';
			DeleteLog(intval($tpl[1]));
			break;	 
	 }
   }
 }
}

function DeleteLog($db_id)
{
	global $uid;
	
	$res = @mysql_query("SELECT t1.tbl, t2.uid FROM dbs AS t1, forms AS t2 WHERE t1.id =".$db_id." && t2.id = t1.form_id");
	$row = @mysql_fetch_row($res);
	
	if ($uid == $row[1])
	{
		@mysql_query("DELETE FROM dbs WHERE id = ".$db_id.";");
	   	@mysql_query("DROP TABLE ".$row[0].";");
	}	
}

    function SortTable($array, $field)
    {
     $temp = array();
     $out = array();

     $i = 0;
      foreach($array as $row)  {
        $temp[$i] = $row[$field];
        $i++;
       }
     asort($temp);
     $i=0;
      foreach($temp AS $key=>$val) {
         $out[$i] = $array[$key];
         $i++;
       }
     return $out;
    }
?>