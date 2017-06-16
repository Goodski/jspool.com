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


header('Content-Type: application/comma-separated-values');
header('Content-Disposition: inline; filename="'.$tblname.'.csv"');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');

$s_query = (trim($_POST['search']=='')) ? trim($_GET['search']) : trim($_POST['search']);
$whole_s = empty($_POST['wholeword']) ? $_GET['wholeword'] : $_POST['wholeword'];
$s_key = (trim($_POST['s_key']=='')) ? trim($_GET['s_key']) : trim($_POST['s_key']);

$head['id'] = '"ID"';
$i = 0;
foreach ($flds AS $fld)
{
	$res = @mysql_query("SELECT title FROM flds WHERE id = '".$fld."'");
	$row = @mysql_fetch_row($res);

	$fset['f'.$i] = '"'.htmlspecialchars($row[0]).'"';
	if (in_array($fld, $display))
	{
		$head['f'.$i] = $fset['f'.$i];
	}
	$i++;
}

if ($tblres[4] > 0) $head['ip'] 		= '"IP Adrress"';
if ($tblres[5] > 0) $head['referer']	= '"HTTP Referer"';
if ($tblres[6] > 0) $head['date']		= '"Date"';
if ($tblres[7] > 0) $head['time']		= '"Time"';

if (isset($_GET['order_by']))
{
	$order_by = $_GET['order_by'];
}
else 
{
	$order_by = 'id';	
}

$desc     = ($_GET['desc'] == 1) ? ' DESC' : '';


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
			$search_sql .= " LOWER(`".$row[0]."`) LIKE \"".$percent."".strtolower($s_query)."".$percent."\" or";
		}
	}
	else 
	{
		$search_sql = " WHERE LOWER(f".intval($s_key).") LIKE \"".$percent."".strtolower($s_query)."".$percent."\"   ";
	}

	$search_sql = substr($search_sql,0,-2);
}
/*** END OF SEARCH ***/


// Creating table header
$res = @mysql_query("SHOW FIELDS FROM ".$dbtbl);
$sto_css = (empty($desc)) ? '' : '2';
$sto_get = (empty($desc)) ? '&desc=1' : '';

foreach ($head as $h_id => $h_name)
{
	$h_name = empty($h_name) ? "Unknown" : $h_name;
	$thead .= $h_name.";";
}

echo substr($thead,0,-1)."\r\n";

// Creating table rows
$i=0;
$sql = "SELECT * FROM ".$dbtbl.$search_sql." ORDER BY ".$order_by.$desc.";";
$res = @mysql_query($sql);
while($row = @mysql_fetch_array($res))
{
	$trows = "";
	foreach ($head as $h_id => $h_name)
	{
		//$row[$h_id] = str_replace($sear, $repl, $row[$h_id]) 
		$trows .= '"'.html_entity_decode($row[$h_id]).'",';//fix 14.03.08
	}
	echo substr($trows,0,-1)."r\n";
}



?>
