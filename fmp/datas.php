<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/generate.inc.php");

if ($_GET['do'] == 'delgroup')
{

	if(is_array($_POST['chk']))
	{
		foreach ($_POST['chk'] as $db_id)
		{
			DeleteLog(intval($db_id));
		}
	}
}

if ($_REQUEST['act'] == 'del') DelRecords();

if ($_GET['act'] == 'group')
{
	if (is_array($_POST['chk']))
	{
		foreach ($_POST['chk'] as $id)
		{	
			$r = explode(":", $id)	;
			$log = $r[0];
			$id = $r[1];

			$res	= @mysql_query("SELECT tbl FROM dbs WHERE id = ".intval($log).";");
			$row	= @mysql_fetch_row($res);
			$tbl	= $row[0];
		
			@mysql_query("UPDATE ".$tbl." SET comments = '".mysql_escape_string($_GET['comment'])."' WHERE id=".intval($id).";");
		}

		echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$_GET['ref']."\">";
		exit();
	}
}

if (($_REQUEST['do']	== 'search')&&(!empty($_REQUEST['search'])))
{
	Search();
	exit();
}

	$table = array();

	  /* create an instance of Template with desired parameters */
	 $t = new Template("tpl");
  	 $t->set_file(array("page" => $index_tpl, "main"=>"datas.tpl", "search" => "datasearch.tpl"));		 
   	 $t->set_block("main","row","rows"); 
   	 $t->set_block("main", "frow", "frows");
	 $t->set_var(array("path"    => $_LANG['msg_data_storage'],
					   "path_info" => $_LANG['msg_data_storage'],
					   "subheader_icon" => "images/database_table.png",
					   "uname"   => $uname,
					   "descr"	 => $_LANG['msg_data_storage_tip']));

	$res = @mysql_query("SELECT id, name, site_id FROM forms WHERE uid = ".$uid.";");
	while($row = @mysql_fetch_row($res))
	{
		$log_form_id	= $row[0];
		$log_form_name	= $row[1];
		if ($row[2] == 0)
		{
			$log_site_name	= "Form Maker Pro server";
		}
		else 
		{
			$res2 = @mysql_query("SELECT name FROM sites WHERE id = ".$row[2].";");
			$row2 = @mysql_fetch_row($res2);
			$log_site_name	= $row2[0];
		}
		
		$res2 = @mysql_query("SELECT id, name, tbl FROM dbs WHERE form_id = ".$log_form_id.";");
		while($row2 = @mysql_fetch_row($res2))
		{
			$res3 = @mysql_query("SELECT COUNT(*) FROM ".$row2[2].";");
			$row3 = @mysql_fetch_row($res3);
			
			$record					= array();	
			$record['log_id']		= $row2[0];
			$record['log_name']		= $row2[1];
			$record['form_id']		= $log_form_id;
			$record['form_name']	= $log_form_name;
			$record['site_name']	= $log_site_name;
			$record['recs']			= $row3[0];
			
			$table[]				= $record;
		}
		
		$t->set_var("opt_form_id",		$row[0]);
		$t->set_var("opt_form_name",	$row[1]);
		$t->parse("frows", "frow", true);		
	}
	
/////// SORTING /////////////////////////////////////

	 $desc = ($_GET['direct'] == 'desc');
	 
	 switch ($_GET['order_by'])
	 {
	 	case 'form':
	 		$table = TableSorter($table, "form_name", $desc);
	 		$t->set_var("sel1", $desc ? ' id="selected2"' : ' id="selected"');
	 		$t->set_var("direct1", $desc ? 'asc' : 'desc');
	 		$t->set_var("direct0", 'asc');
	 		$t->set_var("direct2", 'asc');
	 		$t->set_var("direct3", 'asc');
	 		break;
	 	case 'log':
	 		$table = TableSorter($table, "log_name", $desc);
	 		$t->set_var("sel0", $desc ? ' id="selected2"' : ' id="selected"');
	 		$t->set_var("direct0", $desc ? 'asc' : 'desc');
	 		$t->set_var("direct1", 'asc');
	 		$t->set_var("direct2", 'asc');
	 		$t->set_var("direct3", 'asc');
	 		break;
	 		
	 	case 'recs':
	 		$table = TableSorter($table, "recs", $desc);
	 		$t->set_var("sel3", $desc ? ' id="selected2"' : ' id="selected"');
	 		$t->set_var("direct3", $desc ? 'asc' : 'desc');
	 		$t->set_var("direct1", 'asc');
	 		$t->set_var("direct2", 'asc');
	 		$t->set_var("direct0", 'asc');
	 		break;
	 	default:
	 		$table = TableSorter($table, "site_name", $desc);
	 		$t->set_var("sel2", $desc ? ' id="selected2"' : ' id="selected"');
	 		$t->set_var("direct2", $desc ? 'asc' : 'desc');
	 		$t->set_var("direct0", 'asc');
	 		$t->set_var("direct1", 'asc');
	 		$t->set_var("direct3", 'asc');
	 		break;
	 }
//////////////////////////////////////////////////////
					   
	$i = 0;
	foreach ($table as $row)
	{
		$t->set_var(array(	"log_id"	=> $row['log_id'],
							"log_name"	=> $row['log_name'],
							"form_name"	=> $row['form_name'],
							"site_name"	=> $row['site_name'],
							"form_id"	=> $row['form_id'],
							"recs"		=> $row['recs'],
							"class"		=> (is_int($i/2) ? " class=\"dataodd\"" : " bgcolor=\"#FFFFFF\"")));
		
		$t->parse("rows", "row", true);
		$i++;		
	}
	
	 $t->set_var($_LANG);
	 $t->parse("BUTTONSBLOCK", "search");
	 $t->parse("OUT", array("main","page"));
     $t->p("OUT");

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

function Search()
{
	global $_LANG, $uid, $index_tpl, $uname;
	
	 $s_query = $_REQUEST['search'];
	 
	 $t = new Template("tpl");
  	 $t->set_file(array("page" => $index_tpl, "main"=>"wholesearch.tpl", "search" => "datasearch.tpl"));		 
   	 $t->set_block("main","row","rows"); 
   	 $t->set_block("main", "frow", "frows");
	 $t->set_var(array("path"    => $_LANG['msg_data_storage'],
					   "path_info" => $_LANG['msg_data_storage'],
					   "subheader_icon" => "images/database_table.png",
					   "uname"   => $uname,
					   "descr"	 => $_LANG['msg_data_storage_tip'],
					   "search_query" => $_REQUEST['search'],
					   "s_query" => urldecode($_REQUEST['search'])));	
					   
	$res = @mysql_query("SELECT forms.id as 'form_id',
			 					forms.name as 'form_name',
			 					forms.site_id as 'site_id',
			 					dbs.id as 'log_id',
			 					dbs.name as 'log_name',
			 					dbs.tbl as 'tbl',
								dbs.flds as 'flds'
						 FROM forms, dbs WHERE dbs.form_id = forms.id && forms.uid = ".$uid);
	
	$table = array();
	
	while($row = @mysql_fetch_array($res))
	{
		$result = SearchInTable($row['tbl'], $s_query);
		if (@mysql_num_rows($result) > 0)
		{
			if ($row['site_id'] == 0)	
			{
				$site_name = "Form Maker server";
			}
			else 
			{
				$site_res = @mysql_query("SELECT name FROM sites WHERE id = ".$row['site_id'].";");	
			}
			
			$flds = explode("|", $row['flds']);
			
			$dataset = array();
			
			foreach ($flds as $fld)
			{
				$res2 = @mysql_query("SELECT title FROM flds WHERE id = '".$fld."';");
				$row2 = @mysql_fetch_row($res2);
				$dataset[] = $row2[0];	
			}
			
			while($record = @mysql_fetch_array($result))
			{
				$table_row = array();
				
				$table_row['log_id']	= $row['log_id'];
				$table_row['id']		= $record['id'];
				$table_row['data']		= $site_name." / ".$row['form_name']." / ".$row['log_name']." : ".$record['id'];
				$table_row['comments']	= empty($record['comments']) ? "" : "<img width=\"16\" height=\"16\" src=\"images/comment.png\" border=0 onMouseOver=\"complex('<b>Comments:</b><br>".addslashes(htmlspecialchars(nl2br($record['comments'])))."');\" onMouseOut=\"nd();\">";
				$table_row['popup']		= MakePopup($record, $dataset);
				$table_row['fcomments']	= addslashes(htmlspecialchars($record['comments']));
				
				$table[] = $table_row;
			}
		}
	}

	$table = TableSorter($table, 'data');

	foreach ($table as $record)
	{
		$t->set_var($record);
		$t->parse("rows","row",true);
	}
				   
	 $t->set_var($_LANG);
	 $t->parse("BUTTONSBLOCK", "search");
	 $t->parse("OUT", array("main","page"));
     $t->p("OUT");
}

function SearchInTable($table, $query)
{
	$sql = "SELECT * FROM ".$table." WHERE ";
	
	$res = @mysql_query("SHOW FIELDS FROM ".$table.";");
	while($row = @mysql_fetch_row($res))
	{
		$sql .= $row[0].' LIKE "%'.mysql_escape_string($query).'%" OR ';
	}
	
	$out = @mysql_query(substr($sql,0, -3));
	
	return $out;
}

function MakePopup($data, $flds)
{
	$i = 0;
	
	foreach ($flds as $fld)	
	{
		$out .= $fld.": <b>".addslashes(htmlspecialchars(nl2br($data['f'.$i])))."</b><br>";
		$i++;
	}
	
	return $out;
}

function DelRecords()
{
	if (is_array($_POST['chk']))
	{
		foreach ($_POST['chk'] as $rec)	
		{
			$rec = explode(":", $rec);
			
			$res = @mysql_query("SELECT tbl FROM dbs WHERE id = ".intval($rec[0]).";");
			$row = @mysql_fetch_row($res);
			@mysql_query("DELETE FROM ".$row[0]." WHERE id = ".intval($rec[1]).";");
		}
	}
}
?>