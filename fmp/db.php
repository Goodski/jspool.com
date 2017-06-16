<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/draw.php");
include("./db.conf.php");

	/**
	 * Form ID passing
	 */
	$form_id = intval($_GET['form']);
	if (($form_id<1)&& ($_GET['do'] != 'addstorage'))
	{
		Header("Location: forms.php");
		exit();
	}

	/**
	 * Security wall
	 */
	if ((mysql_num_rows(@mysql_query("SELECT id FROM forms WHERE id = ".$form_id." && uid = ".$uid.";")) == 0) && ($_GET['do'] != 'addstorage'))
	{
		Header("Location: forms.php");
		exit();
	}

		
	switch($_GET['do'])
	{
		case 'delete':
			DeleteLog();
			break;
		case 'add':
			AddLog();
			break;
		case 'update':
			UpdateLog();
			break;
	}

	$res	= @mysql_query("SELECT name FROM forms WHERE id = ".$form_id.";");
	$row	= @mysql_fetch_row($res);
	$fname	= $row[0];
	$dbtpl = "dbtpl.tpl";


	if (empty($_GET['do'])||($_GET['do'] == 'add'))
	{
		$do = 'add';	
	}
	else 
	{
		if ($_GET['do']=='update' && !empty($error))
		{
			$_GET['do'] = 'edit';
			$do = 'edit';	
		}
		else 
		{
			$do = 'update';	
		}	
	}
	
	$t = new Template("tpl");
	
	$t->set_file(array(	"page"		=> $index2_tpl,
						"main"		=> $dbtpl));
						
	$t->set_var(array(	"formid"	=> $form_id,
						"form_name"	=> $fname,
						"error"		=> FormatError($error),
						"name"		=> $_POST['name'],
						"do"		=> (empty($_GET['do']) || $_GET['do'] == 'add') ? 'add' : 'update'));
	$t->set_var(array(	"uname"		=> $uname,
						"path"		=> "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <a href=\"formedit.php?form=".$form_id."\"><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <span id=\"selected\">Log preferences</span>",
						"path_info"	=> "Log preferences",
						"subheader_icon" => "images/database_table.png",
						"referer"	=> $_SERVER['HTTP_REFERER']));
	
	if ($_GET['do'] == 'edit')
	{
		$db_id	= intval($_GET['db']);
	
		$res	= @mysql_query("SELECT flds, display, show_ip, show_ref, show_date, show_time FROM dbs WHERE id = ".$db_id.";");
		$row	= @mysql_fetch_row($res);
		$flds	= @explode("|", $row[0]);
		$disps	= @explode("|", $row[1]);

		$t->set_var(	array(	"use_ip"	=> ($row[2]>0 ? " checked" : ""),
								"use_ref"	=> ($row[3]>0 ? " checked" : ""),
								"use_date"	=> ($row[4]>0 ? " checked" : ""),
								"use_time"	=> ($row[5]>0 ? " checked" : "")));
								
		$t->set_var(	array(	"show_ip"	=> ($row[2]==2 ? " checked" : ""),
								"show_ref"	=> ($row[3]==2 ? " checked" : ""),
								"show_date"	=> ($row[4]==2 ? " checked" : ""),
								"show_time"	=> ($row[5]==2 ? " checked" : "")));
		
		$t->set_var(array(	"db"	=> '&db='.$db_id,
							"name"	=> isset($_POST['name']) ? $_POST['name'] : @implode("",@mysql_fetch_row(@mysql_query("SELECT name FROM dbs WHERE id = ".intval($_GET['db']).";"))),
							"error"	=> $info,
							"descr"     => $_LANG['msg_db_log_preferences_tip']));		
	}

	$t->set_block("main", "row", "rows");
	$res = @mysql_query("SELECT id, name FROM pages WHERE form_id = '".$form_id."' && thx = 0 && preview = 0 ORDER BY pos;");
	while ($row = @mysql_fetch_row($res))
	{
		$fields = '';
		$i = 0;
		$res2 = @mysql_query("SELECT * FROM flds WHERE page_id = ".$row[0]." && type <> 7 && type <> 9 ORDER BY pos;");
		while($row2 = @mysql_fetch_array($res2))
		{
			if ($row2['type'] == CAPTCHA)
				continue;
			$type = $_LANG['msg_unknown'];
			$type = ($row2['type'] == TEXT)      ? $_LANG['msg_textfield']    : $type;
			$type = ($row2['type'] == SELECT)    ? $_LANG['msg_select']       : $type;
			$type = ($row2['type'] == BROWSE)    ? $_LANG['msg_browse']       : $type;
			$type = ($row2['type'] == TEXTAREA)  ? $_LANG['msg_textarea']     : $type;
			$type = ($row2['type'] == MULTILIST) ? $_LANG['msg_multilist'] 		: $type;
			$type = ($row2['type'] == CHECKBOX)  ? $_LANG['msg_checkbox']     : $type;
			$type = ($row2['type'] == RADIO)     ? $_LANG['msg_radio']        : $type;
			$type = ($row2['type'] == CALCULATION) ? $_LANG['msg_calc']		: $type;

			$fname = FieldPrefix($row2).$row2['name'];

			
			if ($_GET['do'] == 'edit')
			{
				$checked = '';
				foreach($flds as $fld)
				{
					$checked = ($fld == $row2['id']) ? ' checked' : $checked;
				}
				
				$display_checked = "";
				foreach($disps as $disp)
				{
					$display_checked = ($disp == $row2['id']) ? ' checked' : $display_checked;
				}
			}
		
			$fields .= "<tr ".((is_int($i++/2)) ? 'class="dataodd"' : 'bgcolor="#FFFFFF"').">\n";
			$fields .= "<td>".$row2['title']."</td>\n";
			$fields .= "<td>".$type."</td>\n";
			$fields .= "<td><input type=\"checkbox\" onclick=\"setDisplay(this,'".$row2['id']."');\" name=\"fields[".$row2['id']."]\" value=\"".$row2['id']."\"".$checked."></td>\n";
			if ($_GET['do'] == 'edit')
			{
				$display_disabled = empty($checked) ? " disabled" : "";
			}
			else 
			{
				$display_checked = "";
				$display_disabled = " disabled";	
			}
			$fields .= "<td><input type=\"checkbox\" id=\"disp".$row2['id']."\" name=\"disp[".$row2['id']."]\" value=\"".$row2['id']."\"".$display_checked.$display_disabled."></td>\n";
			$fields .= "</tr>\n";
	}

	$t->set_var(array(	"pageid"   => $row[0],
						"pagename" => $row[1],
						"fields"   => $fields));
	
	$t->parse("rows", "row", true);
}

$t->set_var(array( "descr"     => $_LANG['msg_db_log_preferences_tip']));	
$t->set_var($_LANG);
$t->parse("OUT", array("main","page"));
$t->p("OUT");

function FormatError($msg)
{
	if (empty($msg))
	{
		return "";
	}
	else
	{

		$error = '<tr>
            <td class="color9"><table width="100%" border="0" cellspacing="2" cellpadding="0">
            <tr valign="top">
            <td valign="center"><img src="images/sysmsg-icon-warnings.gif" alt="warning" width="33" height="33" hspace="10" vspace="9"></td>
            <td width="100%" class="color2"><table width="100%" border="0" cellspacing="9" cellpadding="0">
            <tr>
            <td height="26"><strong>Eror mesage:</strong><br>'.
		$msg.'</td>
            </tr>
            </table></td>
            </tr>
            </table></td>
            </tr>';

		return $error;
	}
}


function AddLog()
{
	global $error, $uid, $form_id, $_LANG;
	
	$error  = "";
	$error .= (trim($_POST['name'])=="") ? "&nbsp;&nbsp;Template's name is empty or incorrect.<br>\n" : "";
	
	if (empty($error))
	{
		$res = @mysql_query("SHOW TABLE STATUS FROM `".DB_DATABASE."` LIKE 'dbs'");
		$row = @mysql_fetch_array($res);
		$table_id = $row['Auto_increment'];
		
		$dump = "CREATE TABLE user".$uid."_".$table_id." (\n".
				"id INT(32) auto_increment NOT NULL,\n";
		if (is_array($_POST['fields']))
		{
		$i = 0;
		foreach($_POST['fields'] as $field_id)
		{
			$dump .= "`f".$i."` blob, \n";
			$flds .= $field_id.'|';
			$i++;
		}
		}
		$dump .= "comments TEXT,\n";
		$dump .= "ip varchar(255),\n";
		$dump .= "referer varchar(255),\n";
		$dump .= "date varchar(255),\n";
		$dump .= "time varchar(255),\n";
		$dump .= "PRIMARY KEY(id));";
		$flds = substr($flds,0,-1);
		
		if (is_array($_POST['disp']))
		{
			foreach($_POST['disp'] as $disp_id)
				$disp .= $disp_id.'|';
			
			$disp = substr($disp,0,-1);
		}
		
		@mysql_query("INSERT INTO dbs (name,tbl,flds, display, form_id, show_ip, show_ref, show_date, show_time) VALUES ('".mysql_escape_string($_POST['name'])."','user".$uid."_".$table_id."','".mysql_escape_string($flds)."','".mysql_escape_string($disp)."',".$form_id.", ".intval($_POST['use_ip']+$_POST['show_ip']).", ".intval($_POST['use_ref']+$_POST['show_ref']).", ".intval($_POST['use_date']+$_POST['show_date']).", ".intval($_POST['use_time']+$_POST['show_time']).");");
		
				@mysql_query($dump);
		Header("Location: ".$_SERVER['HTTP_REFERER']);
		exit();
	}
	
	return false;
}

function DeleteLog()
{
	global $uid, $error, $form_id;

	$db_id = intval($_GET['db']);
	
	$res = @mysql_query("SELECT t1.tbl, t2.uid FROM dbs AS t1, forms AS t2 WHERE t1.id =".$db_id." && t2.id = t1.form_id");
	$row = @mysql_fetch_row($res);
	
	if ($uid == $row[1])
	{
		@mysql_query("DELETE FROM dbs WHERE id = ".$db_id.";");
	   	@mysql_query("DROP TABLE ".$row[0].";");
	}	
		Header("Location: ".$_SERVER['HTTP_REFERER']);
		exit();	
}

function UpdateLog()
{
	global $error, $form_id, $uid, $_LANG;

	$db_id	= intval($_GET['db']);
	
	$error  = "";
	$error .= (trim($_POST['name'])=="") ? "&nbsp;&nbsp;Template's name is empty or incorrect.<br>\n" : "";
	//$error .= !is_array($_POST['fields']) ? "&nbsp;&nbsp;Incorrect data set.<br>\n" : "";
	
	
	if (empty($error))
	{
		
			$res = @mysql_query("SELECT t1.tbl, t1.flds, t1.display FROM dbs AS t1, forms AS t2 WHERE t1.id = ".$db_id." && t1.form_id = t2.id && t2.uid = ".$uid.";");
			if ($row = mysql_fetch_row($res))
			{
				$table_name = $row[0];
				$fields		= explode("|", $row[1]);
				$display	= $row[2];
				
				if (is_array($_POST['disp']))
				{
					$display_new = implode("|", $_POST['disp']);
				}
				
				if (is_array($_POST['fields']))
				{
					/**** Deleting ****/
					
					$i = 0;
					$deleted = array();
					
					foreach ($fields as $field_id)
					{
						if (!in_array($field_id, $_POST['fields']))
						{
							$deleted[] = $i;
						}
						$i++;
					}
	
					for($b=0;$b<count($deleted);$b++)
					{
						$key = $deleted[$b];
						@mysql_query("ALTER TABLE ".$table_name." DROP f".$key.";");
						//echo "ALTER TABLE ".$table_name." DROP f".$key.";<br>\n";
						for($i=($key+1); $i<count($fields); $i++)
						{
							@mysql_query("ALTER TABLE ".$table_name." CHANGE f".$i." f".($i-1)." BLOB");
							//echo "ALTER TABLE ".$table_name." CHANGE f".$i." f".($i-1)." BLOB<br>";
						}
						
						for ($e=0; $e<count($deleted); $e++)
						{
							$deleted[$e] = $deleted[$e] > $key ? $deleted[$e]-1	: $deleted[$e];
						}
						
						unset($fields[$key]);
						
						$tmp = $fields;
						reset($tmp);
						$fields = array();
						for ($i=0;$i<count($tmp);$i++)
						{
							$fields[$i] = current($tmp);
							next($tmp);
						}
					}

				
					/**** Adding ****/
					
					$i = 0;
					$added = array();
					
					foreach ($_POST['fields'] as $field_id)
					{
						if (!in_array($field_id, $fields))
						{
							$added[$field_id] = $i;	
						}
						$i++;
					}
					
					foreach ($added as $name=>$key)
					{
						for ($i=$key; $i<count($fields); $i++)
						{
							@mysql_query("ALTER TABLE ".$table_name." CHANGE f".$i." f".($i+1)." BLOB");
						}
						
						for ($i=count($fields); $i>$key; $i--)
						{
							$fields[$i] = $fields[$i-1];
						}
						
						$fields[$key] = $name;
						
						$afterf = $key == 0 ? 'id' : 'f'.($key-1);
						@mysql_query("ALTER TABLE ".$table_name." ADD f".$key." BLOB AFTER ".$afterf.";");
					}
					
				}
				
				$fields_new .= implode("|", $fields);
				@mysql_query("UPDATE dbs SET name = '".mysql_escape_string($_POST['name'])."', flds = '".mysql_escape_string($fields_new)."', display = '".mysql_escape_string($display_new)."', form_id = ".$form_id.", show_ip =".intval($_POST['use_ip']+$_POST['show_ip']).", show_ref=".intval($_POST['use_ref']+$_POST['show_ref']).", show_date=".intval($_POST['use_date']+$_POST['show_date']).", show_time=".intval($_POST['use_time']+$_POST['show_time'])." WHERE id = ".$db_id.";");
		}
			
			Header("Location: ".$_SERVER['HTTP_REFERER']);
			exit();
	}
}

?>
