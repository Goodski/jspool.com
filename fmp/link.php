<?php 
include("inc/init.php");
include("inc/control.php");

$form_id = intval($_GET['id']);

$res = @mysql_query("SELECT name FROM forms WHERE id = ".$form_id.";");
$row = @mysql_fetch_row($res);

$form_name = $row[0];

$res = @mysql_query("SELECT url FROM pages WHERE form_id = ".$form_id." AND pos=1;"); //fix 4.04.08
$row = @mysql_fetch_row($res);
$url = $row[0];

?>
<HTML>
<head>
<title>Form Maker Pro</title>
<link rel="shortcut icon" href="favicon.ico">
<link href="css/common2.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
<FORM name="gl">
HTML link for "Contact form" form:<br><br>
<CENTER>
<TEXTAREA id="glink" name="glink" rows="3" cols="124" readonly><A href="<?php echo $url; ?>"><?php echo $form_name; ?></A></TEXTAREA>
</CENTER>

<INPUT type="button" value="Close window" class="buttons" onclick="window.close();">
</FORM>
</BODY>
</HTML>