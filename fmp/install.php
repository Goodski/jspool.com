<?php 
include("inc/template.lib.php");

if ($_SERVER['QUERY_STRING'] != 'install')
{
	$t = new Template("tpl");
	$t->set_file("page","install.tpl");

	$t->parse("OUT", "page");
	$t->p("OUT");
}
else
{
	$login			= $_POST['login'];
	$email			= $_POST['email'];
	$password1		= $_POST['password1'];
	$password2		= $_POST['password2'];
	$mysql_host		= $_POST['mysql_host'];
	$mysql_login	= $_POST['mysql_login'];
	$mysql_password	= $_POST['mysql_password'];
	$mysql_db		= $_POST['mysql_db'];

	$err = '';
	$err	.= empty($login) ? "<li>Login name is empty" : "";
	$err	.= empty($email) ? "<li>Email address is empty" : "";
	$err	.= ($password1 != $password2) ? "<li>Passwords are not equal" : "";

	if (@mysql_connect($mysql_host, $mysql_login, $mysql_password))
	{
		if (@mysql_select_db($mysql_db))
		{
			if (is_writable("./db.conf.php"))
			{
				@chmod('forms/', 0777);
				
				$fp = @fopen('forms/test.test', 'w+');
				if (@fwrite($fp, 'test') === FALSE)
				{
					$err .= "<li>Directory <b>forms/</b> is not writable. Please, change permissions to it";
   				}
   				else 
   				{
   					@fclose($fp);
   					@unlink('forms/test.test');
   					
   					$res = @mysql_query('SHOW TABLES FROM `'.$mysql_db.'`');
   					
   					if (@mysql_num_rows($res) == 0)
   					{
						DoInstall();
						header("Location: ./");
						exit();
   					}
   					else 
   					{
   						$err .= "<li>Database <b>".$mysql_db."</b> is not empty. Please, remove all tables inside it or use another database";
   					}
   				}
			}
			else
			{
				$err .= "<li>File <b>db.conf.php</b> is not writable";
			}
		}
		else
		{
			$err .= "<li>Could not select MySQL database";
		}
	}
	else
	{
		$err .= "<li>Could not connect to MySQL server";
	}
	
	$t = new Template("tpl");
	$t->set_file("page","install.tpl");

	$t->set_var($_POST);
	$t->set_var("err", $err);
	$t->parse("OUT", "page");
	$t->p("OUT");
}

function DoInstall()
{
	$sql   = array();
$sql[] = "CREATE TABLE `codersess` (
  `id` varchar(255) NOT NULL default '',
  `page_id` int(16) default NULL,
  `tm` int(16) default NULL,
  `user_id` int(16) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `codertmp` (
  `sid` varchar(255) default NULL,
  `id` varchar(8) NOT NULL default '',
  `title` varchar(255) default NULL,
  `name` varchar(255) default NULL,
  `type` int(2) default NULL,
  `size` int(3) default NULL,
  `pos` int(8) default NULL,
  `vals` text,
  `req` int(1) default NULL,
  `valid` int(1) default NULL,
  `page_id` int(16) default NULL
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `dbs` (
  `id` int(16) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `tbl` varchar(255) default NULL,
  `flds` blob,
  `display` blob,
  `form_id` int(16) default NULL,
  `show_ip` tinyint(1) default '0',
  `show_ref` tinyint(1) default '0',
  `show_date` tinyint(1) default '0',
  `show_time` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `emails` (
  `id` int(16) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `komu` varchar(255) default NULL,
  `cc` varchar(255) default NULL,
  `bcc` varchar(255) default NULL,
  `ot` varchar(255) default NULL,
  `subject` varchar(255) default NULL,
  `attach` varchar(255) default NULL,
  `format` int(1) default NULL,
  `body` text,
  `form_id` int(16) default NULL,
  `preset` int(2) default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `flds` (
  `id` varchar(8) NOT NULL default '',
  `title` varchar(255) default NULL,
  `name` text default NULL,
  `type` int(2) default NULL,
  `size` int(3) default NULL,
  `pos` int(8) default NULL,
  `vals` text,
  `req` int(1) default NULL,
  `valid` int(1) default NULL,
  `page_id` int(16) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `forms` (
  `id` int(16) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `dir` varchar(255) default NULL,
  `site_id` int(16) default NULL,
  `redirect` varchar(255) default NULL,
  `stoptime` int(16) default '0',
  `us` tinyint(1) unsigned default '0',
  `style` blob,
  `uid` int(16) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `help_addresses` (
  `id` int(8) NOT NULL auto_increment,
  `email` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";


$sql[] = "INSERT INTO `help_addresses` VALUES (1, 'support@web-site-scripts.com');";

$sql[] = "CREATE TABLE `pages` (
  `id` int(16) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `url` text,
  `pos` int(8) default NULL,
  `form_id` int(16) default NULL,
  `thx` int(1) default '0',
  `preview` tinyint(1) unsigned default '0',
  `subtext` varchar(255) default 'Send',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `preset_dbs` (
  `id` int(16) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `flds` blob,
  `display` blob,
  `form_id` int(16) default NULL,
  `show_ip` tinyint(1) unsigned default '0',
  `show_ref` tinyint(1) unsigned default '0',
  `show_date` tinyint(1) unsigned default '0',
  `show_time` tinyint(1) unsigned default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$sql[] = "INSERT INTO `preset_dbs` VALUES (1, 'Log', 0x357c367c397c31347c3136, 0x357c367c397c31347c3136, 2, 1, 0, 1, 1);";

$sql[] = "CREATE TABLE `preset_emails` (
  `id` int(16) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `komu` varchar(255) default NULL,
  `cc` varchar(255) default NULL,
  `bcc` varchar(255) default NULL,
  `ot` varchar(255) default NULL,
  `subject` varchar(255) default NULL,
  `attach` varchar(255) default NULL,
  `format` int(1) default NULL,
  `body` text,
  `form_id` int(16) default NULL,
  `preset` int(2) unsigned default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$sql[] = "INSERT INTO `preset_emails` VALUES (1, 'Autoresponder', '[re_Email]', NULL, NULL, NULL, 'Thank you', NULL, 0, 'You filled in next information:\r\n<!-- BEGIN AUTOGENERATING DATA -->\r\nName [r_Name]\r\nEmail [re_Email]\r\nComment [r_Comment]\r\n<!-- END AUTOGENERATING DATA -->\r\nThank you!', 1, 2);";
$sql[] = "INSERT INTO `preset_emails` VALUES (2, 'Notification', 'info@form-maker-pro.com', NULL, NULL, NULL, '\"FeedbackForm\" was submitted on [%DATE_GMT]', NULL, NULL, '<!-- BEGIN AUTOGENERATING DATA -->\r\nName [r_Name]\r\nEmail [re_Email]\r\nComment [r_Comment]\r\n<!-- END AUTOGENERATING DATA -->', 1, 1);";
$sql[] = "INSERT INTO `preset_emails` VALUES (3, 'Autoresponder', '[re_Contact_Email]', '', '', 'info@web-site-scripts.com', 'Thank you', '', 0, 'You filled in next information:\r\n<!-- BEGIN AUTOGENERATING DATA -->\nFirst Name: [r_First_Name]\r\nLast Name: [Last_Name]\r\nContact Email: [re_Contact_Email]\r\nSubject: [r_Subject]\r\nComment: [r_Com]\r\n<!-- END AUTOGENERATING DATA -->\r\nThank you!', 4, 2);";
$sql[] = "INSERT INTO `preset_emails` VALUES (4, 'Autoresponder', '[re_Contact_Email]', '', '', 'info@web-site-scripts.com', 'Thank you', '', 0, 'You filled in next information:\r\n<!-- BEGIN AUTOGENERATING DATA -->\nFirst Name: [r_First_Name]\r\nLast Name: [Last_Name]\r\nContact Email: [re_Contact_Email]\r\nSubject: [r_Subject]\r\nComment: [r_Com]\r\n<!-- END AUTOGENERATING DATA -->\r\nThank you!', 5, 2);";
$sql[] = "INSERT INTO `preset_emails` VALUES (5, 'Autoresponder', '[re_Email]', '', '', '', 'Thank you', '', 0, 'You filled in next information:\r\n<!-- BEGIN AUTOGENERATING DATA -->\nName: [r_Name]\r\nEmail: [re_Email]\r\nComment: [r_Comment]\r\n<!-- END AUTOGENERATING DATA -->\r\nThank you!', 6, 2);";
$sql[] = "INSERT INTO `preset_emails` VALUES (6, 'Notification', 'info@form-maker-pro.com', '', '', '', '\"FeedbackForm\" was submitted on [%DATE_GMT]', '', 0, '<!-- BEGIN AUTOGENERATING DATA -->\nName: [r_Name]\r\nEmail: [re_Email]\r\nComment: [r_Comment]\r\n<!-- END AUTOGENERATING DATA -->', 6, 1);";


$sql[] = "CREATE TABLE `preset_flds` (
  `id` int(16) NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `name` varchar(255) default NULL,
  `type` int(2) default NULL,
  `size` int(3) default NULL,
  `pos` int(8) default NULL,
  `vals` text,
  `req` int(1) default NULL,
  `valid` int(1) default NULL,
  `page_id` int(16) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=27 ;";

$sql[] = "INSERT INTO `preset_flds` VALUES (1, 'Name', 'Name', 0, 25, 1, NULL, 1, 0, 1);";
$sql[] = "INSERT INTO `preset_flds` VALUES (2, 'Email', 'Email', 0, 25, 2, NULL, 1, 1, 1);";
$sql[] = "INSERT INTO `preset_flds` VALUES (3, 'Comment', 'Comment', 3, 25, 3, NULL, 1, 0, 1);";
$sql[] = "INSERT INTO `preset_flds` VALUES (4, '', '', 7, 0, 1, '<h1 align=\"center\">Thank you for your submission</h1>', 0, 0, 3);";
$sql[] = "INSERT INTO `preset_flds` VALUES (5, 'Card Number', 'Card_Number', 0, 25, 1, NULL, 1, 0, 4);";
$sql[] = "INSERT INTO `preset_flds` VALUES (6, 'Card Expiration Month', 'Card_Expiration_Month', 1, 1, 2, 'January::January\r\nFebruary::February\r\nMarch::March\r\nApril::April\r\nMay::May\r\nJune::June\r\nJuly::July\r\nAugust::August\r\nSeptember::September\r\nOctober::October\r\nNovember::November\r\nDecember::December', 1, 0, 4);";
$sql[] = "INSERT INTO `preset_flds` VALUES (7, 'Card Expiration Year', 'Card_Expiration_Year', 1, 1, 3, '2004::2004\r\n2005::2005\r\n2006::2006\r\n2007::2007\r\n2008::2008\r\n2009::2009\r\n2010::2010', 1, 0, 4);";
$sql[] = "INSERT INTO `preset_flds` VALUES (8, '3 or 4 Digit Code After Card # on Back of Card', '3_or_4_Digit_Code_After_Card # on Back of Card', 0, 25, 4, NULL, 1, 0, 4);";
$sql[] = "INSERT INTO `preset_flds` VALUES (9, 'Name Exactly  as it Appers on Card', 'Name_Exactly_as_it_Appers_on_Card', 0, 25, 5, NULL, 1, 0, 4);";
$sql[] = "INSERT INTO `preset_flds` VALUES (10, 'Card Holder Address', 'Card_Holder_Address', 0, 25, 6, NULL, 1, 0, 4);";
$sql[] = "INSERT INTO `preset_flds` VALUES (11, 'City', 'City', 0, 25, 7, NULL, 1, 0, 4);";
$sql[] = "INSERT INTO `preset_flds` VALUES (12, 'State or Province', 'State_or_Province', 0, 25, 8, NULL, 1, 0, 4);";
$sql[] = "INSERT INTO `preset_flds` VALUES (13, 'Postal Code', 'Postal_Code', 0, 25, 9, NULL, 1, 0, 4);";
$sql[] = "INSERT INTO `preset_flds` VALUES (14, 'Country', 'Country', 0, 25, 10, NULL, 1, 0, 4);";
$sql[] = "INSERT INTO `preset_flds` VALUES (15, 'Phone', 'Phone', 0, 25, 11, NULL, 1, 0, 4);";
$sql[] = "INSERT INTO `preset_flds` VALUES (16, 'Email Address (Avoid Free Email Accounts)', 'Email', 0, 25, 12, NULL, 1, 1, 4);";
$sql[] = "INSERT INTO `preset_flds` VALUES (17, NULL, NULL, 7, 0, 1, '<h1 align=\"center\">Thank you for your submission</h1>', 0, 0, 6);";
$sql[] = "INSERT INTO `preset_flds` VALUES (18, NULL, NULL, 7, 0, 1, '<b>Item name</b><br><i>Studded Patent Ankle Boot</i> by Versace Black, 35,5', 0, 0, 7);";
$sql[] = "INSERT INTO `preset_flds` VALUES (19, 'Quantity', 'Quantity', 0, 25, 2, NULL, 0, 2, 7);";
$sql[] = "INSERT INTO `preset_flds` VALUES (20, 'Price', 'Price', 0, 25, 3, NULL, 0, 2, 7);";
$sql[] = "INSERT INTO `preset_flds` VALUES (21, NULL, NULL, 7, 0, 4, '<b>Item name</b><br><i>Veg Tan Soft Satchel</i> by Marc Jacobs collection Dark Olive', 0, 2, 7);";
$sql[] = "INSERT INTO `preset_flds` VALUES (25, 'Total', '[d_Quantity]*[d_Price]+[d_Quantity1]*[d_Price1]', 8, 0, 0, '||19||*||20||+||22||*||23||', 0, 0, 7);";
$sql[] = "INSERT INTO `preset_flds` VALUES (22, 'Quantity', 'Quantity1', 0, 25, 5, NULL, 0, 2, 7);";
$sql[] = "INSERT INTO `preset_flds` VALUES (23, 'Price', 'Price1', 0, 25, 6, NULL, 0, 2, 7);";
$sql[] = "INSERT INTO `preset_flds` VALUES (26, NULL, NULL, 7, 0, 1, '<h1 align=\"center\">Thank you for your submission</h1>', 0, 0, 9);";
$sql[] = "INSERT INTO `preset_flds` VALUES (27, '', '', 7, 0, 1, '<h1 align=\"center\">Thank you for your submission</h1>', 0, 0, 11);";
$sql[] = "INSERT INTO `preset_flds` VALUES (28, 'First Name', 'First_Name', 0, 25, 1, '', 1, 0, 12);";
$sql[] = "INSERT INTO `preset_flds` VALUES (29, 'Last Name', 'Last_Name', 0, 25, 2, '', 0, 0, 12);";
$sql[] = "INSERT INTO `preset_flds` VALUES (30, 'Contact Email', 'Contact_Email', 0, 25, 3, '', 1, 1, 12);";
$sql[] = "INSERT INTO `preset_flds` VALUES (31, 'Subject', 'Subject', 0, 25, 4, '', 1, 0, 12);";
$sql[] = "INSERT INTO `preset_flds` VALUES (32, 'Comment', 'Com', 3, 25, 5, '', 1, 0, 12);";
$sql[] = "INSERT INTO `preset_flds` VALUES (33, '', 'captcha', 10, 0, 6, '0', 1, 0, 12);";
$sql[] = "INSERT INTO `preset_flds` VALUES (34, 'First Name', 'First_Name', 0, 25, 1, '', 1, 0, 13);";
$sql[] = "INSERT INTO `preset_flds` VALUES (35, 'Last Name', 'Last_Name', 0, 25, 2, '', 0, 0, 13);";
$sql[] = "INSERT INTO `preset_flds` VALUES (36, 'Contact Email', 'Contact_Email', 0, 25, 3, '', 1, 1, 13);";
$sql[] = "INSERT INTO `preset_flds` VALUES (37, 'Subject', 'Subject', 0, 25, 4, '', 1, 0, 13);";
$sql[] = "INSERT INTO `preset_flds` VALUES (38, 'Comment', 'Com', 3, 25, 5, '', 1, 0, 13);";
$sql[] = "INSERT INTO `preset_flds` VALUES (39, '', 'captcha', 10, 0, 6, '0', 1, 0, 13);";
$sql[] = "INSERT INTO `preset_flds` VALUES (40, '', '', 7, 0, 1, '<h1 align=\"center\">Thank you for your submission</h1>', 0, 0, 15);";
$sql[] = "INSERT INTO `preset_flds` VALUES (41, 'Name', 'Name', 0, 25, 1, '', 1, 0, 16);";
$sql[] = "INSERT INTO `preset_flds` VALUES (42, 'Email', 'Email', 0, 25, 2, '', 1, 1, 16);";
$sql[] = "INSERT INTO `preset_flds` VALUES (43, 'Comment', 'Comment', 3, 25, 3, '', 1, 0, 16);";


$sql[] = "CREATE TABLE `preset_forms` (
  `id` int(16) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;";

$sql[] = "INSERT INTO `preset_forms` VALUES (1, 'FeedbackForm');";
$sql[] = "INSERT INTO `preset_forms` VALUES (2, 'OrderForm');";
$sql[] = "INSERT INTO `preset_forms` VALUES (3, 'Shopping Cart');";
$sql[] = "INSERT INTO `preset_forms` VALUES (4, 'Contact Form with CAPTCHA');";
$sql[] = "INSERT INTO `preset_forms` VALUES (5, 'Unique submissions form');";
$sql[] = "INSERT INTO `preset_forms` VALUES (6, 'Form with redirect');";


$sql[] = "CREATE TABLE `preset_pages` (
  `id` int(16) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `pos` int(8) default NULL,
  `form_id` int(16) default NULL,
  `thx` int(1) default '0',
  `preview` tinyint(1) unsigned default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=10 ;";

$sql[] = "INSERT INTO `preset_pages` VALUES (1, 'FeedbackFormPage', 1, 1, 0, 0);";
$sql[] = "INSERT INTO `preset_pages` VALUES (2, 'Preview', 2, 1, 0, 1);";
$sql[] = "INSERT INTO `preset_pages` VALUES (3, 'Thanks', 3, 1, 1, 0);";
$sql[] = "INSERT INTO `preset_pages` VALUES (4, 'OrderPage', 1, 2, 0, 0);";
$sql[] = "INSERT INTO `preset_pages` VALUES (5, 'Preview', 2, 2, 0, 1);";
$sql[] = "INSERT INTO `preset_pages` VALUES (6, 'Thanks', 3, 2, 1, 0);";
$sql[] = "INSERT INTO `preset_pages` VALUES (7, 'CalculationForm', 1, 3, 0, 0);";
$sql[] = "INSERT INTO `preset_pages` VALUES (8, 'Preview', 2, 3, 0, 1);";
$sql[] = "INSERT INTO `preset_pages` VALUES (9, 'Thanks', 3, 3, 1, 0);";
$sql[] = "INSERT INTO `preset_pages` VALUES (10, 'Preview', 2, 4, 0, 1);";
$sql[] = "INSERT INTO `preset_pages` VALUES (11, 'Thanks', 3, 4, 1, 0);";
$sql[] = "INSERT INTO `preset_pages` VALUES (12, 'CAPTCHAFormPage', 1, 4, 0, 0);";
$sql[] = "INSERT INTO `preset_pages` VALUES (13, 'UniqueSubmissionsFormPage', 1, 5, 0, 0);";
$sql[] = "INSERT INTO `preset_pages` VALUES (14, 'Preview', 2, 5, 0, 1);";
$sql[] = "INSERT INTO `preset_pages` VALUES (15, 'Thanks', 3, 5, 1, 0);";
$sql[] = "INSERT INTO `preset_pages` VALUES (16, 'RedirectFormPage', 1, 6, 0, 0);";


$sql[] = "CREATE TABLE `requests` (
  `id` int(16) NOT NULL auto_increment,
  `date` int(16) default NULL,
  `login` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `type` int(2) NOT NULL default '0',
  `body` text,
  `hash` varchar(255) NOT NULL default '',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `uid` int(16) default NULL,
  `responce` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM";

$sql[] = "CREATE TABLE `sites` (
  `id` int(16) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `smtp` varchar(255) default NULL,
  `refs` text,
  `uid` int(16) default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `submittions` (
  `form_id` int(16) default NULL,
  `ip` varchar(255) default NULL,
  `host` varchar(255) default NULL,
  `x_forward` varchar(255) default NULL
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `users` (
  `id` int(8) NOT NULL auto_increment,
  `login` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `tips` tinyint(1) unsigned default '1',
  `date_format` varchar(255) default 'd.m.Y',
  `time_format` varchar(255) default 'H:i:s',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM ;";

$sql[] = "INSERT INTO users (login, password, email) VALUES ('".$_POST['login']."', '".$_POST['password1']."', '".$_POST['email']."')";

	foreach ($sql as $query)
	{
		@mysql_query($query);
	}


	$fp = @fopen("./db.conf.php", "w+");

	$file = "<?php \r\n define('DB_HOST','".$_POST['mysql_host']."'); \r\n define('DB_USER','".$_POST['mysql_login']."'); \r\n define('DB_PASSWORD','".$_POST['mysql_password']."'); \r\n define('DB_DATABASE',	'".$_POST['mysql_db']."'); \r\n ?>";
	fwrite($fp, $file);
	fclose($fp);
}
?>
