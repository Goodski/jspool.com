<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/draw.php");

$page_id = intval($_GET['page']);
if ($page_id<1) exit();

$res = @mysql_query("SELECT name, form_id, preview FROM pages WHERE id = ".$page_id.";");
$row = @mysql_fetch_row($res);

$title = $row[0];

if ($row[2] == 1)
{
	include("inc/preview.gen.php")	;
	echo PreviewGen($row[1], false);
	exit();
}

if (isset($_SESSION['codersess']))
{
	 $res = @mysql_query("SELECT * FROM codertmp WHERE page_id = ".$page_id." && sid = '".$_SESSION['codersess']."' ORDER BY pos;");
}
else
{
	$res = @mysql_query("SELECT * FROM flds WHERE page_id = ".$page_id." ORDER BY pos;");	
}
	  while ($row = @mysql_fetch_array($res))
	  {
	    switch ($row['type'])
		{
		  case CAPTCHA:
			$fields .= DrawCaptchafield($row, true);
			break;
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
	
	$style .= "<style type=\"text/css\">\r\n";	
	$style .= "body,a,p,table,td,th,form,input,textarea,select,option {\r\n	font-family: \"Helvetica Neue\", Helvetica, Arial, Verdana, sans-serif;\r\n	font-size: 14px;\r\n	font-weight: 400;\r\n	}\r\n";		
	$style .= ".formField {\r\n	float: left;\r\n	vertical-align: top;\r\n	padding: 10px;\r\n	}\r\n";
	$style .= ".formSubmit {\r\n	clear: both;\r\n	padding: 25px 5px;\r\n	}\r\n";
	$style .= "input {padding: 3px;}\r\n";
	$style .= ".formLabel {\r\n	float: left;\r\n	vertical-align: top;\r\n	width: 100px;\r\n	font-weight: 600px;\r\n	padding: 10px 5px;\r\n	}\r\n";
	$style .= ".formLabel2 {\r\n	font-weight: 600px;\r\n	padding: 10px 5px;\r\n	}\r\n";
	$style .= "BODY {background-color: #FFFFFF;}\r\n";
	$style .= "TD.bg_color {background-color: #EEEEEE;}\r\n";
	$style .= "H1 {\r\n	Color: #000000;\r\n	Font-Size: 16px;\r\n	Font-Weight: Bold;\r\n	padding-bottom: 2px;\r\n	margin-bottom: 2px;\r\n	}\r\n";
	$style .= "TABLE.border {\r\n	border-right: 2px solid;\r\n	border-top: 2px solid;\r\n	border-left: 2px solid;\r\n	border-bottom: 2px solid;\r\n	Border-Color: #AAAAAA;\r\n	}\r\n";
	$style .= ".margins {margin: 25px;}\r\n";
	$style .= ".arrow {Color: #FF0000;}\r\n";
	$style .= "INPUT.format {width: 250;}\r\n";
	$style .= "TEXTAREA {width: 250;}\r\n";
	$style .= "</style>\r\n";	

	 
?>
<HTML>
<HEAD>
<TITLE><?php echo $title; ?></TITLE>
<?=$style?>
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
