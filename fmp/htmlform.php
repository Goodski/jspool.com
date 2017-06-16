<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/draw.php");

$page_id = intval($_GET['page']);
if ($page_id<1) exit();

$title = @mysql_fetch_row(@mysql_query("SELECT name FROM pages WHERE id = ".$page_id.";"));

	 $res = @mysql_query("SELECT * FROM flds WHERE page_id = ".$page_id." ORDER BY pos;");
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
		}
	 }
	 
?>
<HTML>
<HEAD>
<TITLE><?=$title[0]?></TITLE>
</HEAD>
<BODY>
<h1 align="center"><?=$title[0]?></h1>
<center>
<TEXTAREA rows=15 cols=60>
<table>
<?=htmlspecialchars($fields)?>
</table>
</TEXTAREA>
</center>
<br><br>
<p align="center">
<a href="#" onclick="window.close()">Close this window</a>
</p>
</BODY>
</HTML>