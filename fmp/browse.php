<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/generate.inc.php");
require_once("./db.conf.php");

$form_id = intval($_GET['form']);
$id      = intval($_GET['id']);

if (($form_id<1)||($id<1))
{
	Header("Location: forms.php");
	exit();
}

	/**
	 * Security wall
	 */
	if (mysql_num_rows(@mysql_query("SELECT t1.id FROM dbs AS t1, forms AS t2 WHERE t2.id = ".$form_id." && t2.uid = ".$uid." && t1.id = ".$id.";")) == 0)
	{
		Header("Location: forms.php");
		exit();
	}
	
define("REC_PER_PAGE", 20);

$fname  = @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM forms WHERE id = ".$form_id.";")));
$tblres = @mysql_fetch_row(@mysql_query("SELECT name, tbl, flds, display, show_ip, show_ref, show_date, show_time FROM dbs WHERE id = ".$id.";"));

$tblname = $tblres[0];
$dbtbl   = $tblres[1];
$flds = empty($tblres[2]) ? array() : explode("|",$tblres[2]);
$display = empty($tblres[3]) ? array() : explode("|",$tblres[3]);


$show_popup = ($tblres[2] != $tblres[3])||(($tblres[4]==1)||($tblres[5]==1)||($tblres[6]==1)||($tblres[7]==1));

$s_query = (trim($_POST['search']=='')) ? trim($_GET['search']) : trim($_POST['search']);
$whole_s = empty($_POST['wholeword']) ? $_GET['wholeword'] : $_POST['wholeword'];
$s_key = (trim($_POST['s_key']=='')) ? trim($_GET['s_key']) : trim($_POST['s_key']);

$t = new Template("tpl");
$t->set_file(array("page" => $index_tpl, "main"=>"dbbrowse.tpl", "search" => "search.tpl"));
$t->set_block("main","row","rows");

$t->set_var(array(	"form_name" => $fname,
					"formid"	=> $form_id,
					"tblname"   => $tblname,
					"id"		=> $id,
					"descr"     => $_LANG['msg_browse_tip']));

$t->set_var(array(	"uname"		=> $uname,
					"path"      => ((empty($s_query)) ?  "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <a href=\"formedit.php?form=".$form_id."\"><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <a href=\"db.php?do=edit&form=".$form_id."&db=".$id."\"><b>".$_LANG['msg_LOG'].":</b> ".$tblname."</a> / <span id=\"selected\">Browse ".$tblname."</span>" : "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <a href=\"formedit.php?form=".$form_id."\"><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <a href=\"db.php?do=edit&form=".$form_id."&db=".$id."\"><b>".$_LANG['msg_LOG'].":</b> ".$tblname."</a> / <a href='browse.php?form=".$form_id."&id=".$id."'>Browse ".$tblname."</a> / <span id=\"selected\">".$_LANG['msg_search_res']."</span>"),
					"subheader_icon" => "images/database_table.png",
					"path_info" => ((empty($s_query)) ? "Browse ".$tblname : $_LANG['msg_search_results_for'].": ".htmlspecialchars($s_query))));
$head['id'] = 'ID';
$i = 0;
$fset = array();
foreach ($flds AS $fld)
{
	$res = @mysql_query("SELECT title FROM flds WHERE id = '".$fld."'");
	$row = @mysql_fetch_row($res);

	$fset['f'.$i] = htmlspecialchars($row[0]);
	if (in_array($fld, $display))
	{
		$head['f'.$i] = $fset['f'.$i];
	}
	
	$selected = (($s_key!="") && ($s_key == $i)) ? " selected" : "";
	$s_options .= '<option value="'.$i.'"'.$selected.'>'.$fset['f'.$i]."</option>";
	$i++;
}


if ($tblres[4] == 2) $head['ip'] 		= "IP Adrress";
if ($tblres[5] == 2) $head['referer']	= "HTTP Referer";
if ($tblres[6] == 2) $head['date']		= "Date";
if ($tblres[7] == 2) $head['time']		= "Time";

$t->set_var("s_options", $s_options);
$t->set_var("whole_check", ($whole_s == 1) ? " checked" : "");

if (isset($_GET['order_by']))
{
	$order_by = $_GET['order_by'];
}
else 
{
	$order_by = 'id';	
}

$desc     = ($_GET['desc'] == 1) ? ' DESC' : '';
$sto_get  = (empty($desc)) ? '&desc=1' : '';
$sto_get_inv = (empty($desc)) ? '' : '&desc=1';

if ($_GET['do']=='del')
{
	if (is_array($_POST['chk']))
	{
		foreach ($_POST['chk'] as $del_id)
		{
			@mysql_query("DELETE FROM ".$dbtbl." WHERE id = ".$del_id.";");
		}
	}
}

/*** SEARCH ***/

$search_sql = '';
$s_get = '';
if (!empty($s_query))
{
	$percent = ($whole_s == 1) ? "" : "%";
	if (empty($s_key))
	{
		$search_sql = ' WHERE ';
		$res = @mysql_query("SHOW FIELDS FROM ".$dbtbl."");
		while ($row = @mysql_fetch_row($res))
		{
			$search_sql .= " LOWER(`".$row[0]."`) LIKE \"".$percent."".$s_query."".$percent."\" or";
		}
	}
	else 
	{
		$search_sql = " WHERE LOWER(f".intval($s_key).") LIKE \"".$percent."".$s_query."".$percent."\"   ";
	}

	$search_sql = substr($search_sql,0,-2);
	$s_get = "&search=".urlencode($s_query)."&s_key=".$s_key."&wholeword=".$whole_s;
}
/*** END OF SEARCH ***/

$curpage = intval($_GET['page']);
$res = @mysql_query("SELECT COUNT(*) FROM ".$dbtbl.$search_sql);

$row = @mysql_fetch_row($res);

$total = $row[0];
$pages = ($total>0) ? ceil($total/REC_PER_PAGE) : 1;
$curpage = (($curpage<1) || ($curpage>$pages)) ? 1 : $curpage;

$start_page = 1;
$end_page   = 5;

if ($pages<5) $end_page = $pages;
if (($pages>5)&&($curpage>3))
{
	$start_page = $curpage - 2;
	$end_page = $curpage + 2;

	if (($curpage+3)>$pages)
	{
		$start_page = $pages-4;
	}
}

if ($end_page>$pages) $end_page = $pages;

for($i=$start_page;$i<=$end_page;$i++)
{
	$plabel .= ($i==$curpage) ? "[<span id=\"current\">".$i."</span>] " : "<a href=\"browse.php?form=".$form_id."&id=".$id."&page=".$i."&order_by=".$order_by.$sto_get_inv.$s_get."\">".$i."</a> ";
}

$prev_path = ($curpage>1) ? "browse.php?form=".$form_id."&id=".$id."&page=".($curpage-1)."&order_by=".$order_by.$sto_get_inv.$s_get : "#";
$next_path = ($curpage<$pages) ? "browse.php?form=".$form_id."&id=".$id."&page=".($curpage+1)."&order_by=".$order_by.$sto_get_inv.$s_get : "#";

$prev5 = (($curpage-4)>1) ? "<a href=\"browse.php?form=".$form_id."&id=".$id."&page=".($curpage-5)."&order_by=".$order_by.$sto_get_inv.$s_get."\">&lt;&lt;</a>" : "";
$next5 = (($curpage+4)<$pages) ? "<a href=\"browse.php?form=".$form_id."&id=".$id."&page=".($curpage+5)."&order_by=".$order_by.$sto_get_inv.$s_get."\">&gt;&gt;</a>" : "";

$t->set_var(array(	"pages"		=> "<a href=\"browse.php?form=".$form_id."&id=".$id."&page=".$pages."&order_by=".$order_by.$sto_get_inv.$s_get."\">".$pages."</a> ",
					"plabel"	=> $plabel,
					"prev_path" => $prev_path,
					"next_path" => $next_path,
					"prev5"		=> $prev5,
					"next5"		=> $next5,
					"s_result"	=> $s_result));

// Creating table header
$res = @mysql_query("SHOW FIELDS FROM ".$dbtbl);
$first = ' class="f" id="firsth"';
$sto_css = (empty($desc)) ? '' : '2';
$sto_get = (empty($desc)) ? '&desc=1' : '';

$thead = '<th class="f" id="firsth" width="2%"><input type="checkbox" onclick="CheckAll(document.delfrm, this.checked);"></th><th width="2%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>';

foreach ($head as $h_id => $h_name)
{
	$h_name = empty($h_name) ? "Unknown" : $h_name;
	if ($h_id==$order_by)
	{
		$thead .= "<th><a href=\"browse.php?form=".$form_id."&id=".$id."&page=".$curpage."&order_by=".$h_id.$sto_get.$s_get."\" id=\"selected".$sto_css."\">".$h_name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>\n";
	}
	else
	{
		$thead .= "<th><a href=\"browse.php?form=".$form_id."&id=".$id."&page=".$curpage."&order_by=".$h_id.$s_get."\">".$h_name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>\n";
	}	
}

$thead .="<th width=5%>&nbsp</th>";
$t->set_var("thead",$thead);


// Creating table rows
$i=0;
$sql = "SELECT * FROM ".$dbtbl.$search_sql." ORDER BY ".$order_by.$desc." LIMIT ".($curpage-1)*REC_PER_PAGE.",".REC_PER_PAGE.";";
$res = @mysql_query($sql);
while($row = @mysql_fetch_array($res))
{

	$popup = "ID: <b>".$row['id']."</b><br>";
	foreach ($fset as $key => $val)
	{
		$popup .= $val.": <b>".addslashes(nl2br(htmlspecialchars($row[$key])))."</b><br>";	
	}
		$popup .= ($tblres[4]>0) ? "IP Address: <b>".addslashes(nl2br(htmlspecialchars($row['ip'])))."</b><br>" : "";
		$popup .= ($tblres[5]>0) ? "HTTP Referer: <b>".addslashes(nl2br(htmlspecialchars($row['referer'])))."</b><br>" : "";
		$popup .= ($tblres[6]>0) ? "Date: <b>".addslashes(nl2br(htmlspecialchars($row['date'])))."</b><br>" : "";
		$popup .= ($tblres[7]>0) ? "Time: <b>".addslashes(nl2br(htmlspecialchars($row['time'])))."</b><br>" : "";
		
		$trows .= "<tr ".((is_int($i++/2)) ? 'class="dataodd"' : 'bgcolor="#FFFFFF"').">\n";

	if (empty($row['comments']))
	{
		$comment_ico	= "";
		$comment_popup	= "";
	}
	else 
	{
		$comment_ico 	= '<img width="16" height="16" src="images/comment.png" border=0>';
		$comment_popup	= " onMouseOver=\"complex('<b>Comments:</b><br>".addslashes(nl2br(htmlspecialchars($row['comments'])))."');\" onMouseOut=\"nd();\" ";	
	}
	
	$trows .= '<td class="f"><input type="checkbox" name="chk[]" value="'.$row[0].'"></td><td'.$comment_popup.'>'.$comment_ico."</td>";

	foreach ($head as $h_id => $h_name)
	{
		$output = str_replace("\$", "&#36;", $row[$h_id]);
		
		if ($h_id == 'f0')
		{
			$ppp = ($show_popup) ? " onMouseOver=\"complex('".$popup."');\" onMouseOut=\"nd();\"" : "";
			$trows .= "<td height=\"17\"><b><a href=\"logedit.php?id=".$row['id']."&log=".$id."\"".$ppp.">".$output."</a></b></td>\n";//fix 14.03.08
		}
		else 
		{
			$trows .= "<td height=\"17\">".$output."</td>\n"; //fix 14.03.08
		}
	}
	$trows .= "<td align=center nowrap><a href=\"logedit.php?id=".$row['id']."&log=".$id."\" class=\"slink\" title=\"<#msg_edit#>\"><img border=\"0\" src=\"images/page_edit.png\" alt=\"".$_LANG['msg_edit']."\"  align=\"top\">".$_LANG['msg_edit']."&nbsp;</a>
			   <a href=# onclick=\"AddComment(".$row['id'].",".$id.", '".addslashes(nl2br(str_replace("\"","&quot;",$row['comments'])))."');\" class=\"slink\"><img border=\"0\" src=\"images/comment_add.png\" alt=\"".$_LANG['msg_addcomment']."\" align=\"top\" title=\"<#msg_addcomment#>\">".$_LANG['msg_addcomment']."&nbsp;</a></tr>\n";
}

$t->set_var("trows",$trows);

$t->set_var("delaction", "browse.php?do=del&form=".$form_id."&id=".$id."&page=".$curpage."&order_by=".$order_by.$sto_get_inv);
$t->set_var("saction", "browse.php?form=".$form_id."&id=".$id."&page=".$curpage."&order_by=".$order_by.$sto_get_inv);
$t->set_var("s_query", $s_query);
$t->set_var("order_by", $order_by);
$t->set_var("desc", $desc);
$t->set_var($_LANG);

$t->set_var(	array(	"E_FORM"		=> $form_id,
						"E_ID"			=> $id,
						"E_ORDER"		=> $order_by,
						"E_DESC"		=> $_GET['desc'],
						"E_SEARCH"		=> $s_query,
						"E_SKEY"		=> $s_key,
						"E_WHOLE"		=> $whole_s));
						
$t->parse("BUTTONSBLOCK", "search");
$t->parse("OUT", array("main","page"));
$t->p("OUT");
?>