<?php
if (filesize("./db.conf.php") == 0)
{
	header("Location: install.php");
	exit();
}

require_once("./db.conf.php");
error_reporting  (0);
session_set_cookie_params(0);

if (isset($_GET['check'])) 
{
	   @mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	   @mysql_select_db(DB_DATABASE);
	   
$res = mysql_query("SELECT id FROM users WHERE login = '".mysql_escape_string($_POST['login'])."' && password = '".mysql_escape_string($_POST['pass'])."';");
$row = mysql_fetch_row($res);

   if (mysql_num_rows($res) == 1)
   {
	  if ($_POST['remember']==1)
	  {
	   setcookie('fbp_login',$_POST['login'],time()+31536000);
	   setcookie('fbp_password',$_POST['pass'],time()+31536000);
	   setcookie('fbp_remember',1,time()+31536000);
	  }
	  else
	  {
	   setcookie('fbp_login',"",0);
	   setcookie('fbp_password',"",0);
	   setcookie('fbp_remember',0);
	  }


	 session_start();

$_SESSION['auth'] = $row[0];
header("Location: splash.php");
exit();
   }
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Form Maker Pro</title>
<meta http-equiv="Pragma" content="cache">
<meta name="keywords" content="">
<meta name="keyphrase" content="">
<meta name="description" content="">
<meta name="title" content="">
<meta name="robots" content="All">
<meta name="rating" content="General">
<meta name="generator" content="Web-Site-Scripts.com">
<meta name="copyright" content="©2004-2008 Web-Site-Scripts.com® / www.web-site-scripts.com">
<link rel="shortcut icon" href="favicon.ico">
<link href="css/common.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF" background="images/bg.gif" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"><a name="top"></a>


<!-- ~~~ [content >>>] ~~~ -->
<table width="386" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td class="color1"><table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td colspan="2" class="color2"><table width="100%" border="0" cellspacing="5" cellpadding="0">
<tr>
<td><table border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="center">
<!-- ~~~ [logotype here >>>] ~~~ -->
<a href="#" title="homepage link"><img src="images/logo2.gif" alt="Form Maker Pro" hspace="20" border="0"></a>
<!-- ~~~ [<<< logotype here] ~~~ -->
</td>
<td width="1" height="30" class="color1"><img src="images/1x1.gif"></td>
</tr>
</table></td>
<td align="right">
<!-- ~~~ [info & topnav block >>>] ~~~ -->
<span class="smalltxt">Select language</span>
<select name="select" style="vertical-align:middle;">
<option selected>english</option>
</select>
<!-- ~~~ [<<< info & topnav block] ~~~ -->
</td>
</tr>
</table></td>
</tr>
<!-- ~~~ [copyright block >>>] ~~~ -->
<tr>
<td width="170" rowspan="2" align="center" class="color2"><img src="images/formmaker.gif" hspace="11" vspace="11"></td>
<td align="center" class="color4">
<table border="0" cellspacing="4" cellpadding="0">
<form action="index.php?check=1" method="post" name="loginme">

<tr>
<td>Username</td>
<td><input name="login" type="text" size="20" value="<?php echo $_COOKIE['fbp_login']; ?>"></td>
</tr>
<tr>
<td>Password</td>
<td><input name="pass" type="password" size="20" value="<?php echo $_COOKIE['fbp_password']; ?>"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input name="sub" type="image" value="Submit" src="images/button-login.gif" alt="Log In" width="43" height="18" border="0"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input name="remember" type="checkbox" value="1"<?php echo (($_COOKIE['fbp_remember']==1) ? ' checked' : ''); ?>> Remember me</td>
</tr>
</form>
</table>
</td>
</tr>
<tr>
<td height="29" class="color2">&nbsp;&nbsp;&nbsp;<img src="images/icon-patharrow.gif" alt="&gt;" width="5" height="7" hspace="2"> <a href="#" class="nlink" title="Forgotten Password?" onclick="javascript:  window.open('forget.php','_blank','height=200,width=300,toolbar=no,status=no,scrollbars=no,resizable=no,menubar=no,location=no,direction=no')">Forgotten Password?</a></td>
</tr>
<!-- ~~~ [<<< copyright block] ~~~ -->
</table></td>
</tr>
</table>
<!-- ~~~ [<<< content] ~~~ -->

</body>
</html>