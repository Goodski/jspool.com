<?php
require_once("./db.conf.php");
session_set_cookie_params(0);
error_reporting  (0);
// Disabling magic quotes at runtime

if (get_magic_quotes_gpc())
{
   function stripslashes_deep($value)
   {
       $value = is_array($value) ?
                   array_map('stripslashes_deep', $value) :
                   stripslashes($value);

       return $value;
   }

   $_POST = array_map('stripslashes_deep', $_POST);
   $_GET = array_map('stripslashes_deep', $_GET);
   $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
}

$_SERVER['HTTP_REFERER'] = isset($_REQUEST['referer']) ? substr($_REQUEST['referer']."#",0,0-strlen(strstr($_REQUEST['referer']."#", "#"))) : substr($_SERVER['HTTP_REFERER']."#",0,0-strlen(strstr($_SERVER['HTTP_REFERER']."#", "#")));

// Connect to MySQL
@mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
@mysql_select_db(DB_DATABASE);

 /*********** CONSTANTS ***************/
 define("TEXT",			0);
 define("SELECT",		1);
 define("BROWSE",		2);
 define("TEXTAREA",		3);
 define("MULTILIST",	4);
 define("CHECKBOX",		5);
 define("RADIO",		6);
 define("LABEL",		7);
 define("CALCULATION",	8);
 define("CALC_OUT",		9);
 define("CAPTCHA",		10);

 
 define("NONE",			0);
 define("EMAIL",		1);
 define("DIGITS",		2);
 define("CURRENCY",		3);
 define("WORD",			4);
 define("SPACES",		5);
 define("LINE",			6);
 define("MULTIPLE",		7);
 
 define("ADMIN",		1);
 define("CUSTOM",		2);
 define("USER",			3);
 
 /*************************************/

function deldir($dir)
{
	$current_dir = opendir($dir);
	while($entryname = readdir($current_dir))
	{
		if(is_dir("$dir/$entryname") && ($entryname != "." and $entryname!=".."))
		{
			deldir("${dir}/${entryname}");
		}
		elseif($entryname != "." and $entryname!="..")
		{
			@unlink("${dir}/${entryname}");
		}
	}
	closedir($current_dir);
	@rmdir(${dir});
}

function TableSorter($array, $field, $desc = false)
{
     $temp = array();
     $out = array();

     $i = 0;
      foreach($array as $row)  {
        $temp[$i] = $row[$field];
        $i++;
       }
     
     $sort_func = $desc ? "arsort" : "asort";
     
     $sort_func($temp);
     $i=0;
      foreach($temp AS $key=>$val) {
         $out[$i] = $array[$key];
         $i++;
       }
     return $out;
}

function EscapeFileString($name, $rem_space = false)
{
	$name = str_replace("/", "_", $name);
	$name = str_replace("\\", "_", $name);
	$name = str_replace("*", "_", $name);
	$name = str_replace("!", "_", $name);
	$name = str_replace("+", "_", $name);
	$name = str_replace("#", "_", $name);
	$name = str_replace("$", "_", $name);
	$name = str_replace("@", "_", $name);
	$name = str_replace("%", "_", $name);
	$name = str_replace("^", "_", $name);
	$name = str_replace("&", "_", $name);
	$name = str_replace("|", "_", $name);
	$name = $rem_space ? str_replace(" ", "_", $name) : $name;
	$name = str_replace("?", "_", $name);
	$name = str_replace(".", "_", $name);
	$name = str_replace(",", "_", $name);
	$name = str_replace(":", "_", $name);
	$name = str_replace(";", "_", $name);
	$name = str_replace("'", "_", $name);
	$name = str_replace("\"", "_", $name);
	$name = str_replace("~", "_", $name);
	$name = str_replace("`", "_", $name);
	$name = str_replace("[", "_", $name);
	$name = str_replace("]", "_", $name);
	$name = str_replace("{", "_", $name);
	$name = str_replace("}", "_", $name);
	
	return $name;
}

function validateURL ($url) 
{
	$path = pathinfo($url);
	$path = urldecode($path["basename"]);
	
	$return = $url;
	
	if (preg_match("/\*/", $path)) return false;
	if (preg_match("/\?/", $path)) return false;
	if (preg_match("/\&/", $path)) return false; 
	if (preg_match("/\\\$/", $path)) return false;
	if (preg_match("/\#/", $path)) return false;
	if (preg_match("/\@/", $path)) return false;
	
	return $return;
}

function UpdateLabels($form_id)
{
 $res = @mysql_query("SELECT * FROM pages WHERE preview = 1 && form_id = ".$form_id.";");
 if (@mysql_num_rows($res) == 0)
 {
	$res = @mysql_query("SELECT MAX(pos) FROM pages WHERE thx = 0 && form_id = ".$form_id.";");
 	$row = @mysql_fetch_row($res);
 
 	@mysql_query("UPDATE pages SET subtext = 'Next' WHERE (subtext = 'Send' || subtext = 'Submit' || subtext='Preview') && pos < ".$row[0]." && form_id = ".$form_id.";"); 
 	@mysql_query("UPDATE pages SET subtext = 'Submit' WHERE (subtext = 'Send' || subtext = 'Next' || subtext='Preview') && pos = ".$row[0]." && form_id = ".$form_id.";");
 }
 else 
 {
	$res = @mysql_query("SELECT MAX(pos) FROM pages WHERE thx = 0 && form_id = ".$form_id.";");
 	$row = @mysql_fetch_row($res);
 
 	@mysql_query("UPDATE pages SET subtext = 'Next' WHERE (subtext = 'Send' || subtext = 'Submit' || subtext='Preview') && pos < ".($row[0]-1)." && form_id = ".$form_id.";"); 
 	@mysql_query("UPDATE pages SET subtext = 'Preview' WHERE (subtext = 'Send' || subtext = 'Submit' || subtext='Preview') && pos = ".($row[0]-1)." && form_id = ".$form_id.";"); 
 	@mysql_query("UPDATE pages SET subtext = 'Submit' WHERE (subtext = 'Send' || subtext = 'Next' || subtext='Preview') && pos = ".$row[0]." && form_id = ".$form_id.";");

 }
}
?>
