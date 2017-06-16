<?php
include("inc/init.php");
 include("inc/control.php");
 include("inc/template.lib.php");

  /* create an instance of Template with desired parameters */
 $t = new Template("tpl");
 $t->set_var(array(	   "uname"  => $uname,
					   "path"    => $_LANG['msg_options'],
					   "subheader_icon" => "images/key.png",
					   "path_info" => $_LANG['msg_options']));

 $t->set_file(array("page" => $index2_tpl, "main"=>"pref.tpl"));

 if ($_GET['do'] == 'update')
 {
  if ($_POST['pass']!=$_POST['pass2'])
  {
    $error = '<tr>
            <td class="color9"><table width="100%" border="0" cellspacing="2" cellpadding="0">
            <tr valign="top">
            <td valign="center"><img src="images/sysmsg-icon-warnings.gif" alt="warning" width="33" height="33" hspace="10" vspace="9"></td>
            <td width="100%" class="color2"><table width="100%" border="0" cellspacing="9" cellpadding="0">
            <tr>
            <td height="26"><strong>'.$_LANG['msg_error_message'].':</strong><br>'.
            $_LANG['msg_pass_err'].'</td>
            </tr>
            </table></td>
            </tr>
            </table></td>
            </tr>';
  }
  else
  {
  
   @mysql_query("UPDATE users SET password = '".mysql_escape_string($_POST['pass'])."', email = '".mysql_escape_string($_POST['email'])."', tips = ".intval($_POST['tipz']).", date_format = '".$_POST['date_format']."', time_format='".$_POST['time_format']."' WHERE id = ".$uid.";"); 
  }
 }
 
 $res = @mysql_query("SELECT * FROM users WHERE id = ".$uid.";");
 $row = @mysql_fetch_array($res);

 $t->set_var(array("log"    => $row['login'],
 				   "pass"   => $row['password'],
				   "email"  => $row['email'],
				   "tipz"	=> ($row['tips'] == 1) ? " checked" : "",
				   "df1"	=> ($row['date_format'] == "d.m.Y") ? " selected" : "",
				   "df2"	=> ($row['date_format'] == "m.d.Y") ? " selected" : "",
				   "tf1"	=> ($row['time_format'] == "H:i:s") ? " selected" : "",
				   "tf2"	=> ($row['time_format'] == "g:i:sa") ? " selected" : "",
				   "error"	=> $error,
				   "expdate" => date("F jS, Y",$row['expdate']),
					"descr"	 => $_LANG['msg_my_info_tip'])); 
 
 $t->set_var($_LANG);
 $t->parse("OUT", array("main","page"));
 $t->p("OUT");
?>