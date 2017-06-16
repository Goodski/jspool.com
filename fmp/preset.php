<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/draw.php");

$form_id = intval($_GET['id']);

switch ($_GET['do'])
{
	case 'add':
		AddPreset();
		break;
	case 'delete':
		DelPreset();
		break;	
}

function DelPreset()
{
	$pid = intval($_GET['pid']);
	
	$res = @mysql_query('SELECT id FROM preset_pages WHERE form_id = '.$pid.';');
	while ($row = @mysql_fetch_row($res)) 
	{
		@mysql_query('DELETE FROM preset_flds WHERE page_id = '.$row[0]);
	}
	
	@mysql_query('DELETE FROM preset_pages WHERE form_id = '.$pid);
	@mysql_query('DELETE FROM preset_emails WHERE form_id = '.$pid);
	@mysql_query('DELETE FROM preset_dbs WHERE form_id = '.$pid);
	@mysql_query('DELETE FROM preset_forms WHERE id = '.$pid);
	
	header('Location: forms.php?do=addform&site='.intval($_GET['site']));
	exit();
}

function AddPreset()
{
	global $form_id;
	
	$res = @mysql_query('SELECT name FROM forms WHERE id = '.$form_id.';');
	$row = @mysql_fetch_row($res);
	
	// Adding preset form
	
	@mysql_query('INSERT INTO preset_forms (name) VALUES ("'.mysql_escape_string($row[0]).'");');
	$preset_id = @mysql_insert_id();
	
	// Adding pages
	
	$res = @mysql_query('SELECT id, name, pos, thx, preview FROM pages WHERE form_id = '.$form_id);
	while ($row = @mysql_fetch_row($res))
	{
		@mysql_query('INSERT INTO preset_pages (name, pos, form_id, thx, preview) VALUES ("'.mysql_escape_string($row[1]).'", '.intval($row[2]).', '.$preset_id.', '.intval($row[3]).', '.intval($row[4]).')');
		$preset_page_id = @mysql_insert_id();
		
		$res2 = @mysql_query('SELECT id, title, name, type, size, pos, vals, req, valid FROM flds WHERE page_id = '.$row[0].';');
		while ($row2 = @mysql_fetch_row($res2))
		{
			@mysql_query('INSERT INTO preset_flds VALUES (null, "'.mysql_escape_string($row2[1]).'", "'.mysql_escape_string($row2[2]).'", '.intval($row2[3]).', '.intval($row2[4]).', '.intval($row2[5]).', "'.mysql_escape_string($row2[6]).'", '.intval($row2[7]).', '.intval($row2[8]).', '.$preset_page_id.');');
			$flds[$row2[0]] = @mysql_insert_id();
		}
	}
	
	// Adding emails 
	
	$res = @mysql_query('SELECT name, komu, cc, bcc, ot, subject, attach, format, body, preset FROM emails WHERE form_id = '.$form_id);
	while ($row = @mysql_fetch_row($res))
	{
		@mysql_query("INSERT INTO preset_emails VALUES (null, '".mysql_escape_string($row[0])."', '".mysql_escape_string($row[1])."', '".mysql_escape_string($row[2])."', '".mysql_escape_string($row[3])."', '".mysql_escape_string($row[4])."', '".mysql_escape_string($row[5])."', '".mysql_escape_string($row[6])."', ".intval($row[7]).", '".mysql_escape_string($row[8])."', ".$preset_id.", ".intval($row[9]).");");
	}
	
	// Adding dbs
	
	$res = @mysql_query('SELECT name, flds, display, show_ip, show_ref, show_date, show_time FROM dbs WHERE form_id = '.$form_id.';');
	while ($row = @mysql_fetch_row($res))
	{
		foreach ($flds as $key => $value)
		{
			$row[1] = str_replace($key, $value, $row[1]);
			$row[2] = str_replace($key, $value, $row[2]);
		}
		
		@mysql_query('INSERT INTO preset_dbs VALUES (null, "'.mysql_escape_string($row[0]).'", "'.mysql_escape_string($row[1]).'", "'.mysql_escape_string($row[2]).'", '.intval($preset_id).', '.intval($row[3]).', '.intval($row[4]).', '.intval($row[5]).', '.intval($row[6]).');');
	}
	
	echo '<html><body><script language="JavaScript">alert("Preset successfully added."); document.location="formedit.php?form='.$form_id.'";</script></body></html>';
	//header('Location: formedit.php?form='.);
	exit();
}

$res = @mysql_query("SELECT name FROM preset_forms WHERE id = ".$form_id.";");
$row = @mysql_fetch_row($res);
$title = $row[0];

$res = @mysql_query("SELECT id, name FROM preset_pages WHERE pos = 1 && form_id = ".$form_id.";");
$row = @mysql_fetch_row($res);

$page_id = $row[0];

	 $res = @mysql_query("SELECT * FROM preset_flds WHERE page_id = ".$page_id." ORDER BY pos;");

	 while ($row = @mysql_fetch_array($res))
	  {
	    switch ($row['type'])
		{
		  case TEXT:
		  	$fields .= DrawTextfield($row);
			break;
		  case SELECT:
		    $fields .= DrawSelectField($row);
			break;
		  case BROWSE:
		    $fields .= DrawBrowseField($row);
			break;
		  case TEXTAREA:
		    $fields .= DrawTextarea($row);
			break;
		  case MULTILIST:
		    $fields .= DrawMultilist($row);
			break;
		  case CHECKBOX:
		    $fields .= DrawCheckbox($row);
			break;
		  case RADIO:
		    $fields .= DrawRadiobox($row);
			break;
		  case LABEL:
		    $fields .= DrawLabel($row);
			break;
		  case CALC_OUT:
		    $fields .= DrawCalculation($row);
			break;
		}
	 }

	$csshtml .= "<style type=\"text/css\">\r\n";	
	$csshtml .= "body,a,p,table,td,th,form,input,textarea,select,option {\r\n	font-family: \"Helvetica Neue\", Helvetica, Arial, Verdana, sans-serif;\r\n	font-size: 14px;\r\n	font-weight: 400;\r\n	}\r\n";		
	$csshtml .= ".formField {\r\n	float: left;\r\n	vertical-align: top;\r\n	padding: 10px;\r\n	}\r\n";
	$csshtml .= ".formSubmit {\r\n	clear: both;\r\n	padding: 25px 5px;\r\n	}\r\n";
	$csshtml .= "input {padding: 3px;}\r\n";
	$csshtml .= ".formLabel {\r\n	float: left;\r\n	vertical-align: top;\r\n	width: 100px;\r\n	font-weight: 600px;\r\n	padding: 10px 5px;\r\n	}\r\n";
	$csshtml .= ".formLabel2 {\r\n	font-weight: 600px;\r\n	padding: 10px 5px;\r\n	}\r\n";
	$csshtml .= "BODY {background-color: #FFFFFF;}\r\n";
	$csshtml .= "TD.bg_color {background-color: #EEEEEE;}\r\n";
	$csshtml .= "H1 {\r\n	Color: #000000;\r\n	Font-Size: 16px;\r\n	Font-Weight: Bold;\r\n	padding-bottom: 2px;\r\n	margin-bottom: 2px;\r\n	}\r\n";
	$csshtml .= "TABLE.border {\r\n	border-right: 2px solid;\r\n	border-top: 2px solid;\r\n	border-left: 2px solid;\r\n	border-bottom: 2px solid;\r\n	Border-Color: #AAAAAA;\r\n	}\r\n";
	$csshtml .= ".margins {margin: 25px;}\r\n";
	$csshtml .= ".arrow {Color: #FF0000;}\r\n";
	$csshtml .= "INPUT.format {width: 250;}\r\n";
	$csshtml .= "TEXTAREA {width: 250;}\r\n";
	$csshtml .= "</style>\r\n";	
	 
?>
<HTML>
<HEAD>
<link href="css/common2.css" rel="stylesheet" type="text/css">
<?=$csshtml?>
<TITLE><?php echo $title; ?></TITLE>

</HEAD>

<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
<tbody><tr align="center" valign="middle"><td><!-- header -->
<h1 class="formHeading"><?php echo $title; ?></h1>

<table class="border" border="0" cellpadding="0" cellspacing="0">
<tbody><tr><td class="bg_color">

<div class="margins">
<table cellpadding="0" cellspacing="0">
<tr><td>
<?=$fields?>
</tr></td>
</table>
</div>
<br><br>
</td></tr>
</tbody></table>

<p align="center">
<a href="#" class="nlink" onclick="window.close()">Close this window</a>
</p>

</td></tr>
</tbody></table>



</BODY>
</HTML>