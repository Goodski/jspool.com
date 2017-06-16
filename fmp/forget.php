<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Form Maker Pro</title>
<link rel="shortcut icon" href="favicon.ico">
<link href="css/common.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" background="images/bg.gif" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<?php
include("inc/init.php");
 if ($_SERVER['QUERY_STRING']=='enter')
 {
  $res = @mysql_query("SELECT login, password FROM users WHERE email = '".mysql_escape_string($_POST['email'])."';");
  if (@mysql_num_rows($res)>0)
  {
    while ($row = @mysql_fetch_row($res))
	{
      mail($_POST['email'],"Form Maker Pro","Hello!\r\nYour login is: ".$row[0]."\r\nYour password is: ".$row[1], "From: support@web-site-scripts-com");
    }
	echo '<table border="0" width="100%"><tr height="90" valign="bottom"><td align="center">Check your mail</td></tr></table>';
  }
  else
  {
  echo '<table border="0" width="100%"><tr height="90" valign="bottom"><td align="center">Email incorrect</td></tr></table>';
  }
 }
 else
 {
  echo '<form action="forget.php?enter" method="post">
<table border="0" cellspacing="4" cellpadding="0">
 <tr height="80" valign="bottom">
  <td colspan=3 align="center">To regain access to your account, please enter your email. The password will be sent to the entered email, if it is in our database.</td>
 </tr>
<tr>
<td width="30"></td>
<td>Email: </td>
<td><input type="text" name="email" value="" size="20"></td>

</tr>
 <tr>
  <td colspan="2"></td>
  <td><input name="sub" type="image" value="Submit" src="images/b_submit1.gif" alt="Submit" border="0"></td>
 </tr>
</table>
</form>';
 }
?>


</body>
</html>