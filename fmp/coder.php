<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/draw.php");

$page_id = intval($_GET['page']);
if (($page_id<1)&&($_GET['do'] != 'update'))
{
 Header("Location: forms.php");
 exit();
}

if (isset($_SESSION['codersess']))
{
 $res = @mysql_query("SELECT page_id FROM codersess WHERE id = '".$_SESSION['codersess']."';");
 $row = @mysql_fetch_row($res);
 if ($row[0] != $page_id)
 {
 	unset($_SESSION['codersess']);
 	MakeSession();	
 }
}
else 
{
	MakeSession();
}

if ($_GET['do']=='add')
{
 AddField();
}

if ($_GET['do']=='update')
{
 UpdateField();
}

if (!empty($_GET['move']))
{
MoveFields();
}

if ($_GET['do']=='delete')
{
DeleteFields();
}

if ($_GET['do'] == 'delcalc')
{
 @mysql_query("DELETE FROM codertmp WHERE id = '".mysql_escape_string($_GET['id'])."' && sid = '".$_SESSION['codersess']."';");	
}

$res = @mysql_query("SELECT name, form_id, thx FROM pages WHERE id = ".$page_id.";");
$row = @mysql_fetch_row($res);
$form_id = $row[1];
$page_name = $row[0];

if ($row[2] == 1)
{
	
	if ($_GET['do'] == 'update')
	{
		Commit();	
	}
	
	$res = @mysql_query("SELECT id FROM flds WHERE page_id = ".$page_id." ORDER BY pos LIMIT 1;");
	$row = @mysql_fetch_row($res);
	
	header("Location: draw.php?do=edit&id=".$row[0]."&field=7&page=".$page_id);
    exit();		
}

if ($_GET['do']=='commit')
{
Commit();
}

if ($_GET['do']=='discard')
{
Discard();
}

$fname = mysql_fetch_row(mysql_query("SELECT name FROM forms WHERE id = ".$form_id.";"));
$fname = $fname[0];

	 $t = new Template("tpl");
  	 $t->set_file(array("page" => $index2_tpl, "main"=> "genformain.tpl"));		 
     $t->set_block("main", "calc_row", "calc_rows");
			$t->set_var(array("uname"     => $uname,
							  "page_name" => $page_name,
	    					  "path"      => "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <a href=\"formedit.php?form=".$form_id."\"><b>".$_LANG['msg_FORM'].":</b> ".$fname."</a> / <span id=\"selected\"><b>".$_LANG['msg_PAGE'].":</b> ".$page_name."</span>",
							  "subheader_icon" => "images/application_form.png",
					   		  "path_info" => $page_name));



	 $res = @mysql_query("SELECT * FROM codertmp WHERE page_id = ".$page_id." && type <> 8 && sid = '".$_SESSION['codersess']."' ORDER BY pos;");
	 if (@mysql_num_rows($res)==0)
	 {
	  $fields = "<tr><td>".$_LANG['msg_empty_page']."</td></tr>";
	  $gracc = "";
	 }
	 else
	 {
	  $c   = 1;
	  $num = @mysql_num_rows($res);
      $gracc = '<tr><td width="2%"><input type="checkbox" name="checkbox" value="checkbox" onclick="CheckAll(document.form1, this.checked);"></td>
	  <td align="left"  colspan="2">
	  <span class="slink">'.$_LANG['msg_sel_action'].': <span><a href="#" class="slink" title="'.$_LANG['msg_delete'].'" onclick="if (confirm('."'".$_LANG['msg_flds_del_confirm']."'".')) {document.form1.submit();}"><img src="images/delete.png" alt="'.$_LANG['msg_delete'].'" width="16" height="16" align="top" border="0"> '.$_LANG['msg_delete'].'</a></span> <span><a href="#" class="slink" onClick="clearall();"><img src="images/page_white.png" alt="'.$_LANG['msg_clear_all'].'" width="16" height="16" align="top" border="0"> '.$_LANG['msg_clear_all'].'</a></span></span></td></tr>';
	  while ($row = @mysql_fetch_array($res))
	  {
	  $isup   = ($c==1)    ? false : true;
	  $isdown = ($c==$num) ? false : true;
	  
	    switch ($row['type'])
		{
		  case CAPTCHA:
			$fields .= DrawCaptchafield($row, false, true, $isup, $isdown);
			break;
		  case TEXT:
		  	$fields .= DrawTextfield($row, true, $isup, $isdown);
			break;
		  case SELECT:
		    $fields .= DrawSelectField($row, true, $isup, $isdown);
			break;
		  case BROWSE:
		    $fields .= DrawBrowseField($row, true, $isup, $isdown);
			break;
		  case TEXTAREA:
		    $fields .= DrawTextarea($row, true, $isup, $isdown);
			break;
		  case MULTILIST:
		    $fields .= DrawMultilist($row, true, $isup, $isdown);
			break;
		  case CHECKBOX:
		    $fields .= DrawCheckbox($row, true, $isup, $isdown);
			break;
		  case RADIO:
		    $fields .= DrawRadiobox($row, true, $isup, $isdown);
			break;
		  case LABEL:
		    $fields .= DrawLabel($row,true, $isup, $isdown, !$is_thx);
			break;
		  case CALC_OUT:
		  	$fields .= DrawCalculation($row,true,$isup,$isdown);
		  	break;
		}
		$c++;
		
	  }
  
	 }
	 
	 /**
	  * Sorting calculations
	  */
	  
	 if ($_GET['calc_dir'] == 'desc')
	 {
	 	$calc_sql = "DESC";	
	 	$t->set_var("calc_direct", "2");
	 	$t->set_var("calc_dirhref", "asc");
	 }
	 else 
	 {
	 	$calc_sql =	"ASC";
	 	$t->set_var("calc_direct", "");
	 	$t->set_var("calc_dirhref", "desc");
	 }
	 
	 $res = @mysql_query("SELECT id, title FROM codertmp WHERE type = 8 && sid = '".$_SESSION['codersess']."' ORDER BY title ".$calc_sql.";");
	 while ($row = @mysql_fetch_row($res))
	 {
	 	$t->set_var(array("calc_id"		=> $row[0],
	 					  "calc_title"	=> $row[1],
	 					  "class" 	=> (is_int(++$l/2) ? " bgcolor=\"#FFFFFF\"" : " class=\"dataodd\"")));	
	 	
	 	$t->parse("calc_rows", "calc_row", true);
	 }
	 
	 $t->set_var(array("pageid" => $page_id,
	 				   "fields" => $fields,
					   "gracc" => $gracc,
					   "descr"     => $_LANG['msg_form_field_edition_tip']));
					   
	 $res = @mysql_query("SELECT subtext FROM pages WHERE id = ".$page_id.";");
	 $row = @mysql_fetch_row($res);
	 
	 $t->set_var("subtext", $row[0]);
	 $t->set_var($_LANG);
	 $t->parse("OUT", array("main", "page"));
     $t->p("OUT");

function MoveFields()
{
 $field = mysql_escape_string($_GET['field']);
 $page  = intval($_GET['page']);
 
 $pos = @mysql_fetch_row(@mysql_query("SELECT pos FROM codertmp WHERE id = '".$field."' && sid = '".$_SESSION['codersess']."';"));
 $pos = $pos[0];

 $max = @mysql_fetch_row(@mysql_query("SELECT MAX(pos) FROM codertmp WHERE page_id = ".$page." && sid = '".$_SESSION['codersess']."';"));
 $max = $max[0];

 if ($_GET['move']=='up')
 {
  if ($pos>1)
  {
  $res = @mysql_query("SELECT id FROM codertmp WHERE pos = ".($pos-1)." && page_id = ".$page." && sid = '".$_SESSION['codersess']."';");
  $row = @mysql_fetch_row($res);
  @mysql_query("UPDATE codertmp SET pos = (pos-1) WHERE id = '".$field."' && sid = '".$_SESSION['codersess']."';");
  @mysql_query("UPDATE codertmp SET pos = (pos+1) WHERE id = '".$row[0]."' && sid = '".$_SESSION['codersess']."';");
  }
 }
 else
 {
  if ($pos<$max)
  {
  $res = mysql_query("SELECT id FROM codertmp WHERE pos = ".($pos+1)." && page_id = ".$page." && sid = '".$_SESSION['codersess']."';");
  $row = mysql_fetch_row($res);
  mysql_query("UPDATE codertmp SET pos = (pos+1) WHERE id = '".$field."' && sid = '".$_SESSION['codersess']."';");
  mysql_query("UPDATE codertmp SET pos = (pos-1) WHERE id = '".$row[0]."' && sid = '".$_SESSION['codersess']."';");
  }
 }

}

function DeleteFields()
{

if (count($_POST['element'])>0)
{
 foreach($_POST['element'] as $id)
 {
  $res = @mysql_query("SELECT pos, page_id FROM codertmp WHERE id = '".$id."' && sid = '".$_SESSION['codersess']."';");
  $row = @mysql_fetch_row($res);
  
  @mysql_query("DELETE FROM codertmp WHERE id = '".mysql_escape_string($id)."' && sid = '".$_SESSION['codersess']."';");
  @mysql_query("UPDATE codertmp SET pos = (pos-1) WHERE pos>".$row[0]." && page_id = ".$row[1]." && sid = '".$_SESSION['codersess']."';");
 }
}
}

function AddField()
{
 
$page_id = intval($_GET['page']);
$field   = mysql_escape_string($_GET['field']);
$pos     = intval($_GET['pos']);

if (($page_id<1)||(($pos<1)&&($field != CALCULATION))) return;
 switch($_GET['field'])
 {
	case CAPTCHA: 
	 $title = mysql_escape_string($_POST['title']);
	 $name  = "captcha";
	 $type  = CAPTCHA;
	 $vals  = mysql_escape_string($_POST['vfield']);
	 $req   = 1;
	 $valid = intval($_POST['vfield']);
	 $size  = 0;
	break;
	
	case TEXT: 
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = TEXT;
	 $size  = 25;
	 $vals  = '';
	 $req   = intval($_POST['req']);
	 $valid = intval($_POST['vfield']);
	break;
	
	case SELECT:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = SELECT;
	 $size  = 1;
     if (is_array($_POST['valarray']))
	 {
	  $i=0;
	  foreach ($_POST['valarray'] AS $val)
	  {
	   if ((trim($val)!="")&&(trim($_POST['caparray'][$i])!=""))
	   {
	   $list .= $val."::".$_POST['caparray'][$i]."\r\n";
	   }
	   $i++;
	  }
	 }
 	 $vals  = mysql_escape_string(trim($list));
	 $req   = intval($_POST['req']);
	 $valid = 0;	
	break;
	
	case BROWSE:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = BROWSE;
	 $size  = 25;
	 $vals  = '';
	 $req   = intval($_POST['req']);
	 $valid = 0;	
	break;
	
	case TEXTAREA:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = TEXTAREA;
	 $size  = 25;
	 $vals  = '';
	 $req   = intval($_POST['req']);
	 $valid = intval($_POST['vfield']);	 
	break;

	case MULTILIST:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = MULTILIST;
	 $size  = intval($_POST['size']);
     if (is_array($_POST['valarray']))
	 {
	  $i=0;
	  foreach ($_POST['valarray'] AS $val)
	  {
	   if ((trim($val)!="")&&(trim($_POST['caparray'][$i])!=""))
	   {
	   $list .= $val."::".$_POST['caparray'][$i]."\r\n";
	   }
	   $i++;
	  }
	 }
 	 $vals  = mysql_escape_string(trim($list));
	 $req   = intval($_POST['req']);
	 $valid = 0;	
	break;
		
	case CHECKBOX:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = CHECKBOX;
	 $size  = 1;
     if (is_array($_POST['valarray']))
	 {
	  $i=0;
	  foreach ($_POST['valarray'] AS $val)
	  {
	   if ((trim($val)!="")&&(trim($_POST['caparray'][$i])!=""))
	   {
	     $default = '';
		 if (is_array($_POST['default']))
		 {
	     foreach($_POST['default'] as $isdef)
		 {
		  $default = ($isdef == $i) ? '^' : $default;
		 }
		 }
	   $list .= $default.$val."::".$_POST['caparray'][$i]."\r\n";
	   }
	   $i++;
	  }
	 }
 	 $vals  = mysql_escape_string(trim($list));
	 $req   = intval($_POST['req']);
	 $valid = 0;	
	break;
	
	case RADIO:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = RADIO;
	 $size  = 1;
     if (is_array($_POST['valarray']))
	 {
	  $i=0;
	  foreach ($_POST['valarray'] AS $val)
	  {
	   if ((trim($val)!="")&&(trim($_POST['caparray'][$i])!=""))
	   {
	   $default = (($_POST['default']==$i)&&($_POST['default'] != '')) ? '^' : ''; 
	   $list .= $default.$val."::".$_POST['caparray'][$i]."\r\n";
	   }
	   $i++;
	  }
	 }
 	 $vals  = mysql_escape_string(trim($list));
	 $req   = intval($_POST['req']);
	 $valid = 0;	
	break;
	
	case LABEL:
	 $title = '';
	 $name  = '';
	 $type  = LABEL;
	 $size  = 0;
	 $vals  = mysql_escape_string($_POST['maker_label']);
	 $req   = 0;
	 $valid = 0;
	break;
	
	case CALCULATION:
	 $title = mysql_escape_string($_POST['title']);
	 $type	= CALCULATION;
	 $size	= 0;
	 $vals	= mysql_escape_string(encodeFormula());
	 $name	= mysql_escape_string(FormulaToName());
	 $req	= 0;
	 $valid	= 0;
	break;
	 
	case CALC_OUT:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = "";
	 $type  = CALC_OUT;
	 $size  = 25;
	 $vals	= getFormula($_POST['calc']);
	 $req   = 0;
	 $valid = 0;
	 break;
 }
 
 $rres = @mysql_query("SELECT COUNT(*) FROM codertmp WHERE name='".$name."' AND page_id = ".$page_id." && sid = '".$_SESSION['codersess']."';");
 $rrow = @mysql_fetch_row($rres);
 
 
 if (($rrow[0]==0)||($_GET['field']==LABEL))
 {
 	if ($type != CALCULATION)
 	{
	 @mysql_query("UPDATE codertmp SET pos=(pos+1) WHERE pos>=".$pos." && page_id = ".$page_id." && sid = '".$_SESSION['codersess']."';");
 	}
 	
	$name  = (($_GET['field'] == CALCULATION) || ($_GET['field'] == CALC_OUT)) ? $name : EscapeFileString($name, true);
	##############################################################
	$tokenid = substr(uniqid(md5(microtime().$name),TRUE),0,8);
	##############################################################
	if ($_GET['field'] == 10)
	{
	@mysql_query("INSERT INTO codertmp (sid,id,title,name,type,size,pos,vals,req,valid,page_id) VALUES ('".$_SESSION['codersess']."', '".$tokenid."', '".$title."','".$name."',".$type.",".$size.",".$pos.",'".$vals."',".$req.",0,".$page_id.");");
	}
else 
	{
	@mysql_query("INSERT INTO codertmp (sid,id,title,name,type,size,pos,vals,req,valid,page_id) VALUES ('".$_SESSION['codersess']."', '".$tokenid."', '".$title."','".$name."',".$type.",".$size.",".$pos.",'".$vals."',".$req.",".$valid.",".$page_id.");");
	}
	
	
	
 }
}



function UpdateField()
{
 
$page_id = intval($_GET['page']);
$field   = intval($_GET['field']);

if ($page_id<1) return;
 switch($_GET['field'])
 {
	case CAPTCHA: 
	 $title = mysql_escape_string($_POST['title']);
	 $name  = "captcha";
	 $type  = CAPTCHA;
	 $vals  = mysql_escape_string($_POST['vfield']);
	 $req   = 1;
	 $valid = intval($_POST['vfield']);
	 $size  = 0;
	break;
	
	case TEXT: 
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = TEXT;
	 $size  = 25;
	 $vals  = '';
	 $req   = intval($_POST['req']);
	 $valid = intval($_POST['vfield']);
	break;
	
	case SELECT:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = SELECT;
	 $size  = 1;
     if (is_array($_POST['valarray']))
	 {
	  $i=0;
	  foreach ($_POST['valarray'] AS $val)
	  {
	   if ((trim($val)!="")&&(trim($_POST['caparray'][$i])!=""))
	   {
	   $list .= $val."::".$_POST['caparray'][$i]."\r\n";
	   }
	   $i++;
	  }
	 }
	 $vals  = trim($list);
	 $req   = intval($_POST['req']);
	 $valid = 0;	
	break;
	
	case BROWSE:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = BROWSE;
	 $size  = 25;
	 $vals  = '';
	 $req   = 0;
	 $valid = 0;	
	break;
	
	case TEXTAREA:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = TEXTAREA;
	 $size  = 25;
	 $vals  = '';
	 $req   = intval($_POST['req']);
	 $valid = intval($_POST['vfield']);	 
	break;

	case MULTILIST:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = MULTILIST;
	 $size  = intval($_POST['size']);
	      if (is_array($_POST['valarray']))
	 {
	  $i=0;
	  foreach ($_POST['valarray'] AS $val)
	  {
	   if ((trim($val)!="")&&(trim($_POST['caparray'][$i])!=""))
	   {
	   $list .= $val."::".$_POST['caparray'][$i]."\r\n";
	   }
	   $i++;
	  }
	 }
	 $vals  = trim($list);
	 $req   = intval($_POST['req']);
	 $valid = 0;	
	break;
		
	case CHECKBOX:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = CHECKBOX;
	 $size  = 1;
     if (is_array($_POST['valarray']))
	 {
	  $i=0;
	  foreach ($_POST['valarray'] AS $val)
	  {
	   if ((trim($val)!="")&&(trim($_POST['caparray'][$i])!=""))
	   {
	   
	   	 $default = '';
		 
		 if (is_array($_POST['default']))
		 {
	     foreach($_POST['default'] as $isdef)
		 {
		  $default = ($isdef == $i) ? '^' : $default;
		 }
		 }
	   $list .= $default.$val."::".$_POST['caparray'][$i]."\r\n";
	   }
	   $i++;
	  }
	 }
	 $vals  = trim($list);
	 $req   = intval($_POST['req']);
	 $valid = 0;	
	break;
	
	case RADIO:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = mysql_escape_string($_POST['field_name']);
	 $type  = RADIO;
	 $size  = 1;
     if (is_array($_POST['valarray']))
	 {
	  $i=0;
	  foreach ($_POST['valarray'] AS $val)
	  {
	   if ((trim($val)!="")&&(trim($_POST['caparray'][$i])!=""))
	   {
	   $default = (($_POST['default']==$i)&&($_POST['default'] != '')) ? '^' : ''; 
	   $list .= $default.$val."::".$_POST['caparray'][$i]."\r\n";
	   }
	   $i++;
	  }
	 }
	 $vals  = trim($list);
	 $req   = intval($_POST['req']);
	 $valid = 0;	
	break;
	
	case LABEL:
	 $title = '';
	 $name  = '';
	 $type  = LABEL;
	 $size  = 0;
	 $vals  = mysql_escape_string($_POST['maker_label']);
	 $req   = 0;
	 $valid = 0;
	break;
	
	case CALCULATION:
	 $title = mysql_escape_string($_POST['title']);
	 $name	= mysql_escape_string(FormulaToName()); //fixed 10.06.08
	 $type	= CALCULATION;
	 $size	= 0;
	 $vals	= mysql_escape_string(encodeFormula());
	 $req	= 0;
	 $valid	= 0;
	break;
	
    case CALC_OUT:
	 $title = mysql_escape_string($_POST['title']);
	 $name  = "";
	 $type  = CALC_OUT;
	 $size  = 25;
	 $vals	= getFormula($_POST['calc']);
	 $req   = 0;
	 $valid = 0;
	break;
 }

$name  = (($_GET['field'] == CALCULATION) || ($_GET['field'] == CALC_OUT)) ? $name : EscapeFileString($name, true);
if ($_GET['field'] == 10)
	{
	@mysql_query("UPDATE codertmp SET title = '".$title."', name = '".$name."', type = ".$type.", size = ".$size.", vals = '".$vals."', req = ".$req.", valid = '0' WHERE id = '".mysql_escape_string($_GET['id'])."' && sid = '".$_SESSION['codersess']."';");
	}
else 
	{
	@mysql_query("UPDATE codertmp SET title = '".$title."', name = '".$name."', type = ".$type.", size = ".$size.", vals = '".$vals."', req = ".$req.", valid = ".$valid." WHERE id = '".mysql_escape_string($_GET['id'])."' && sid = '".$_SESSION['codersess']."';");
	}
}

function Commit()
{
global $form_id, $page_id;

 @mysql_query("DELETE FROM flds WHERE page_id = ".$page_id.";");
 $res = @mysql_query("SELECT * FROM codertmp WHERE sid = '".$_SESSION['codersess']."';");
 while($row = @mysql_fetch_array($res))
 {
  $row = array_map("mysql_escape_string", $row);
  $sql = "INSERT INTO flds (id, title, name, type, size, pos, vals, req, valid, page_id) VALUES ('".$row['id']."', '".$row['title']."', '".$row['name']."', ".$row['type'].", ".$row['size'].", ".$row['pos'].", '".$row['vals']."', ".$row['req'].", ".$row['valid'].", ".$row['page_id'].");";
  mysql_query($sql);
 }
 
 @mysql_query("DELETE FROM codertmp WHERE sid = '".$_SESSION['codersess']."';");
 @mysql_query("DELETE FROM codersess WHERE id = '".$_SESSION['codersess']."';");
 unset($_SESSION['codersess']);
 
 @mysql_query("UPDATE pages SET subtext = '".mysql_escape_string($_GET['subtext'])."' WHERE id = ".$page_id.";");
 Header("Location: formedit.php?form=".$form_id);
 exit();
}

function Discard()
{
global $form_id;

 @mysql_query("DELETE FROM codersess WHERE id = '".$_SESSION['codersess']."';");
 @mysql_query("DELETE FROM codertmp WHERE sid = '".$_SESSION['codersess']."';");
 unset($_SESSION['codersess']);
 
 Header("Location: formedit.php?form=".$form_id);
 exit();
}

function encodeFormula() //fixed 10.06.08
{
	$formula = $_POST['formula'];
 	if (is_array($_POST['fld_id']))
	{
		$num = preg_split("((\*)|(\/)|(\-)|(\+)|(\()|(\)))", $formula, -1,PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		
		for ($x = 0; $x<count($num); $x++)
			{
			foreach ($_POST['fld_id'] as $id => $letter)
			{
				if ($num[$x]==$letter)
					{
					$num[$x]= "||".$id."||";
					}
			}
		}
		$formula = implode("",$num);
	}
	
	return $formula; 
}

function FormulaToName() //fixed 10.06.08
{
	$formula = $_POST['formula'];
 	if (is_array($_POST['fld_id']))
	{
		$num = preg_split("((\*)|(\/)|(\-)|(\+)|(\()|(\)))", $formula, -1,PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		foreach ($_POST['fld_id'] as $id => $letter)
		{
			$res = @mysql_query("SELECT * FROM codertmp WHERE id = '".mysql_escape_string($id)."' && sid = '".$_SESSION['codersess']."';");
			if (@mysql_num_rows($res) == 0)
			{
				$res = @mysql_query("SELECT * FROM flds WHERE id = '".mysql_escape_string($id)."';");
			}
			$row = @mysql_fetch_array($res);
			$ldelim = ($row['type'] != CALCULATION) ? "[" : "(";
			$rdelim = ($row['type'] != CALCULATION) ? "]" : ")";
				
			$_array[$letter] = $ldelim.FieldPrefix($row).$row['name'].$rdelim;
		}
		for ($x = 0; $x<count($num); $x++)
			{
			foreach ($_array as $letter => $name)
			{
				if ($num[$x]==$letter)
					{
					$num[$x]= $name;
					}
			}
		}
		$formula = implode("",$num);
	}
	
	return $formula; 
}

function getFormula($id)
{

 $id = mysql_escape_string($id);
 
 $res = @mysql_query("SELECT name FROM codertmp WHERE id = '".$id."' && sid = '".$_SESSION['codersess']."';");
 if (@mysql_num_rows($res) == 0)
 {
 	$res = @mysql_query("SELECT name FROM flds WHERE id = '".$id."';");
 }
 
 $row = @mysql_fetch_row($res);
 return $row[0];
}

function MakeSession()
{
 global $page_id, $uid;
 
 $_SESSION['codersess'] = uniqid(md5(time()+rand(0,500)));
 @mysql_query("INSERT INTO codersess(id,page_id,tm,user_id) VALUES ('".$_SESSION['codersess']."',".$page_id.",".time().",".$uid.");"); 
 @mysql_query("INSERT INTO codertmp SELECT codersess.id AS sid, flds.* FROM codersess, flds WHERE codersess.id = '".$_SESSION['codersess']."' && flds.page_id = ".$page_id.";");
}
?>
