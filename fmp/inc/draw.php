<?php
function DrawCaptchafield($data, $img = false, $ctrl = false, $isup = true, $isdown = true, $style = false)
{
$fullpath = '';
$path = explode( '/', $_SERVER['SCRIPT_NAME'] );
for( $i = 0; $i < sizeof($path) - 1; $i++ ) $fullpath .= $path[$i]."/";
$fullpath = substr($fullpath,0,strlen($fullpath) - 1);
$p = "http://".$_SERVER['SERVER_NAME'].$fullpath."/forms/formprocessorpro.php";
$p .= /*"http://localhost:81/captcha/b.php"*/"?captcha&t=".$data['vals'];

 switch ( $data['vals'] )
 {
	 default:$desc = "";break;
	 case 1:$desc = "Use top register.";break;
	 case 2:$desc = "Use top register.";break;
	 case 3:$desc = "Use top and bottom register.";break;
	 case 0:$desc = "Use digits only.";break;	 
 }

 $ret .= $img ? "<tr><td class=\"formLabel\">Type the text from this image. ".$desc."</td><td  class=\"formfield\"><br><img src=\"$p\" style=\"border: 1px solid silver;\" alt=\"Captcha Image: you will need to recognize the text in it.\"></td></tr><tr><td  class=\"formLabel\">".$data['title']."</td>":"";

 //$ret  .= "";
 $ret .= $ctrl ? '<td><input type="checkbox" id="1qw23g84y5jbg843y" name="element[]" value="'.$data['id'].'"></td><td class="formLabel">'.$desc.'</td>' : '';
 $req  = "";
 //$ret .= "<td style=\"color: red;\">".$data['title'].$req."</td>\r\n";
 //$ret .= '<td class=\"formLabel\">'.$data['title']."</td>";
 $ret .= (!$img)?"</td>":"";
 $ret .= '<td class="formfield"><input class="format" type="text" id="r_'.$data['name'].'" size="'.$data['size'].'" name="r_'.$data['name'].'" title="'.$data['title'].'" value=""'.($style ? '  class="format"' : '').'>'."</td>\r\n";
 
 $up   = $isup   ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=up"><img src="images/icon-arrow-up.gif" alt="Up" border="0"></a>'     : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $down = $isdown ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=down"><img src="images/icon-arrow-down.gif" alt="Down" border="0"></a>' : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $ret .= $ctrl ? '<td nowrap><a href="draw.php?do=edit&id='.$data['id'].'&field='.$data['type'].'&page='.$data['page_id'].'" class="slink"><img src="images/icon-action-edit.gif" alt="<#msg_open#>" border="0"><#msg_open#></a> '.$up.' '.$down.'</td>' : '';
 
 $ret .= "</tr>";
 return $ret;
}

function DrawTextfield($data, $ctrl = false, $isup = true, $isdown = true, $style = false)
{
 $ret  = "<tr>";
 $ret .= $ctrl ? '<td><input type="checkbox" id="1qw23g84y5jbg843y" name="element[]" value="'.$data['id'].'"></td>' : '';
 $req  = ($data['req']==1) ? DrawStar($style) : '';
 $ret .= "<td class=\"formLabel\">".$data['title'].$req."</td>\r\n";
 $ret .= '<td class="formField"><input type="text" size="'.$data['size'].'" name="'.FieldPrefix($data).$data['name'].'" id = "'.FieldPrefix($data).$data['name'].'" value="'.$data['vals'].'" title="'.$data['title'].'"'.($style ? ' class="format"' : 'class="format"').'>'."</td>\r\n";

 $up   = $isup   ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=up"><img src="images/icon-arrow-up.gif" alt="Up" border="0" align="absmiddle"></a>'     : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $down = $isdown ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=down"><img src="images/icon-arrow-down.gif" alt="Down" border="0" align="absmiddle"></a>' : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $ret .= $ctrl ? '<td nowrap><a href="draw.php?do=edit&id='.$data['id'].'&field='.$data['type'].'&page='.$data['page_id'].'" class="slink"><img src="images/icon-action-edit.gif" alt="<#msg_open#>" border="0" align="absmiddle"><#msg_open#></a> '.$up.' '.$down.'</td>' : '';
 
 $ret .= "</tr>";
 return $ret;
}

function DrawSelectField($data, $ctrl = false, $isup = true, $isdown = true, $style = false)
{
 $ret  = "<tr>";
 $ret .= $ctrl ? '<td><input type="checkbox" id="1qw23g84y5jbg843y" name="element[]" value="'.$data['id'].'"></td>' : '';
$req  = ($data['req']==1) ? DrawStar($style) : '';
 $ret .= "<td class=\"formLabel\">".$data['title'].$req."</td>\r\n";
 $ret .= '<td nowrap class="formField"><select name="'.FieldPrefix($data).$data['name'].'" id="'.FieldPrefix($data).$data['name'].'" title="'.$data['title'].'"'.($style ? ' class="format"' : '').'>';

 $vals = explode("\r\n",$data['vals']);
 foreach ($vals as $val)
 {
  $tmp = explode('::',$val);
  $ret .= "<option value='".$tmp[0]."'>".$tmp[1]."</option>\r\n";
 }
 $ret .= "</select></td>\r\n";

 $up   = $isup   ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=up"><img src="images/icon-arrow-up.gif" alt="Up" border="0" align="absmiddle"></a>'     : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $down = $isdown ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=down"><img src="images/icon-arrow-down.gif" alt="Down" border="0" align="absmiddle"></a>' : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $ret .= $ctrl ? '<td nowrap><a href="medit.php?id='.$data['id'].'" class="slink"><img src="images/icon-action-edit.gif" alt="<#msg_open#>" border="0" align="absmiddle"><#msg_open#></a> '.$up.' '.$down.'</td>' : '';

 $ret .= "</tr>";
 
 return $ret;
}

function DrawBrowseField($data, $ctrl = false, $isup = true, $isdown = true, $style = false)
{
 $ret  = "<tr>";
 $ret .= $ctrl ? '<td><input type="checkbox" id="1qw23g84y5jbg843y" name="element[]" value="'.$data['id'].'"></td>' : '';
 $req  = ($data['req']==1) ? DrawStar($style) : '';
 $ret .= "<td class=\"formLabel\">".$data['title'].$req."</td>\r\n";
 $ret .= '<td class="formField"><input type="file" size="'.$data['size'].'" name="'.FieldPrefix($data).$data['name'].'" id="'.FieldPrefix($data).$data['name'].'" title="'.$data['title'].'"'.($style ? ' class="format"' : '').'>'."</td>\r\n";

 $up   = $isup   ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=up"><img src="images/icon-arrow-up.gif" alt="Up" border="0" align="absmiddle"></a>'     : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $down = $isdown ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=down"><img src="images/icon-arrow-down.gif" alt="Down" border="0" align="absmiddle"></a>' : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $ret .= $ctrl ? '<td nowrap><a href="draw.php?do=edit&id='.$data['id'].'&field='.$data['type'].'&page='.$data['page_id'].'" class="slink"><img src="images/icon-action-edit.gif" alt="<#msg_open#>" border="0" align="absmiddle"><#msg_open#></a> '.$up.' '.$down.'</td>' : '';

 
 $ret .= "</tr>";
 return $ret;
}

function DrawTextarea($data, $ctrl = false, $isup = true, $isdown = true, $style = false)
{
 $ret  = "<tr>";
 $ret .= $ctrl ? '<td><input type="checkbox" id="1qw23g84y5jbg843y" name="element[]" value="'.$data['id'].'" title="'.$data['title'].'"></td>' : '';
$req  = ($data['req']==1) ? DrawStar($style) : '';
 $ret .= "<td class=\"formLabel\">".$data['title'].$req."</td>\r\n";
 $ret .= '<td class="formField"><textarea rows="5" cols="'.$data['size'].'" id="'.FieldPrefix($data).$data['name'].'" name="'.FieldPrefix($data).$data['name'].'" title="'.$data['title'].'" '.($style ? ' class="format"' : '').'>'.$data['vals'].'</textarea>'."</td>\r\n";

 $up   = $isup   ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=up"><img src="images/icon-arrow-up.gif" alt="Up" border="0" align="absmiddle"></a>'     : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $down = $isdown ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=down"><img src="images/icon-arrow-down.gif" alt="Down" border="0" align="absmiddle"></a>' : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $ret .= $ctrl ? '<td nowrap><a href="draw.php?do=edit&id='.$data['id'].'&field='.$data['type'].'&page='.$data['page_id'].'" class="slink"><img src="images/icon-action-edit.gif" alt="<#msg_open#>" border="0" align="absmiddle"><#msg_open#></a> '.$up.' '.$down.'</td>' : '';

 $ret .= "</tr>";
 return $ret;
}

function DrawMultilist($data, $ctrl = false, $isup = true, $isdown = true, $style = false)
{
 $ret  = "<tr>";
 $ret .= $ctrl ? '<td><input type="checkbox" id="1qw23g84y5jbg843y" name="element[]" value="'.$data['id'].'"></td>' : '';
$req  = ($data['req']==1) ? DrawStar($style) : '';
 $ret .= "<td class=\"formLabel\">".$data['title'].$req."</td>\r\n";
 $ret .= '<td class="formField"><select size="'.$data['size'].'" multiple name="'.FieldPrefix($data).$data['name'].'[]" id="'.FieldPrefix($data).$data['name'].'[]" title="'.$data['title'].'"'.($style ? ' class="format"' : '').'>';
 
 $vals = explode("\r\n",$data['vals']);
 foreach ($vals as $val)
 {
  $tmp = explode('::',$val);
  $ret .= "<option  class=\"format\" value='".$tmp[0]."'>".$tmp[1]."</option>\r\n";
 }
 $ret .= "</select></td>\r\n";

 $up   = $isup   ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=up"><img src="images/icon-arrow-up.gif" alt="Up" border="0" align="absmiddle"></a>'     : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $down = $isdown ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=down"><img src="images/icon-arrow-down.gif" alt="Down" border="0" align="absmiddle"></a>' : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $ret .= $ctrl ? '<td nowrap><a href="medit.php?id='.$data['id'].'" class="slink"><img src="images/icon-action-edit.gif" alt="<#msg_open#>" border="0" align="absmiddle"><#msg_open#></a> '.$up.' '.$down.'</td>' : '';

 $ret .= "</tr>";
 
 return $ret;
}

function DrawCheckbox($data, $ctrl = false, $isup = true, $isdown = true, $style = false)
{
 $ret  = "<tr>";
 $ret .= $ctrl ? '<td><input type="checkbox" id="1qw23g84y5jbg843y" name="element[]" value="'.$data['id'].'"></td>' : '';
$req  = ($data['req']==1) ? DrawStar($style) : '';
 $ret .= "<td class=\"formLabel\">".$data['title'].$req."</td>\r\n";
 $ret .= '<td class="formField">';
 
 $vals = explode("\r\n",$data['vals']);
 foreach ($vals as $val)
 {
  $tmp = explode('::',$val);
  $default = '';
  if ($tmp[0][0]=='^')
  {
   $default = ' checked';
   $tmp[0]  = substr($tmp[0],1); 
  }
  else
  {
   $default = '';
  }
  $ret .= '<input type="checkbox" name="'.FieldPrefix($data).$data['name'].'[]" id="'.FieldPrefix($data).$data['name'].'[]" value="'.$tmp[0].'"'.$default.' title="'.$data['title'].'"'.($style ? ' class="format_1 optionLabel"' : '').'>'.$tmp[1]."<br>\r\n";
 }
 $ret .= "</td>\r\n";

 $up   = $isup   ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=up"><img src="images/icon-arrow-up.gif" alt="Up" border="0" align="absmiddle"></a>'     : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $down = $isdown ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=down"><img src="images/icon-arrow-down.gif" alt="Down" border="0" align="absmiddle"></a>' : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $ret .= $ctrl ? '<td nowrap><a href="medit.php?id='.$data['id'].'" class="slink"><img src="images/icon-action-edit.gif" alt="<#msg_open#>" border="0" align="absmiddle"><#msg_open#></a> '.$up.' '.$down.'</td>' : '';

 $ret .= "</tr>";
 
 return $ret;
}

function DrawRadiobox($data, $ctrl = false, $isup = true, $isdown = true, $style = false)
{
 $ret  = "<tr>";
 $ret .= $ctrl ? '<td><input type="checkbox" id="1qw23g84y5jbg843y" name="element[]" value="'.$data['id'].'"></td>' : ''; 
 $req  = ($data['req']==1) ? DrawStar($style) : '';
 $ret .= "<td class=\"formLabel\">".$data['title'].$req."</td>\r\n";
 $ret .= '<td class="formField">';
 
 $vals = explode("\r\n",$data['vals']);
 foreach ($vals as $val)
 {
  $tmp = explode('::',$val);
  $default = '';
  if ($tmp[0][0]=='^')
  {
   $default = ' checked';
   $tmp[0]  = substr($tmp[0],1); 
  }
  else
  {
   $default = '';
  }
  
  $ret .= '<input type="radio" name="'.FieldPrefix($data).$data['name'].'" id="'.FieldPrefix($data).$data['name'].'" value="'.$tmp[0].'"'.$default.' title="'.$data['title'].'"'.($style ? ' class="format_1 optionLabel"' : '').'>'.$tmp[1]."<br>\r\n";
 }
 $ret .= "</td>\r\n";

 $up   = $isup   ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=up"><img src="images/icon-arrow-up.gif" alt="Up" border="0" align="absmiddle"></a>'     : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $down = $isdown ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=down"><img src="images/icon-arrow-down.gif" alt="Down" border="0" align="absmiddle"></a>' : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $ret .= $ctrl ? '<td nowrap><a href="medit.php?id='.$data['id'].'" class="slink"><img src="images/icon-action-edit.gif" alt="<#msg_open#>" border="0" align="absmiddle"><#msg_open#></a> '.$up.' '.$down.'</td>' : '';

 $ret .= "</tr>";
 
 return $ret;
}

function DrawLabel($data, $ctrl = false, $isup = true, $isdown = true, $draw_checkbox = true, $style = false)
{
 $ret  = "<tr>";
 $ret .= $ctrl ? '<td>'.($draw_checkbox ? '<input type="checkbox" id="1qw23g84y5jbg843y" name="element[]" value="'.$data['id'].'">' : '').'</td>' : ''; 
 $ret .= "<td  class=\"formLabel2\" colspan=\"2\">".$data['vals']."</td>\r\n";

 $up   = $isup   ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=up"><img src="images/icon-arrow-up.gif" alt="Up" border="0" align="absmiddle"></a>'     : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $down = $isdown ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=down"><img src="images/icon-arrow-down.gif" alt="Down" border="0" align="absmiddle"></a>' : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $ret .= $ctrl ? '<td nowrap><a href="draw.php?do=edit&id='.$data['id'].'&field='.$data['type'].'&page='.$data['page_id'].'" class="slink"><img src="images/icon-action-edit.gif" alt="<#msg_open#>" border="0" align="absmiddle"><#msg_open#></a> '.$up.' '.$down.'</td>' : '';

 $ret .= "</tr>";
 return $ret;
}
function DrawCalculation($data, $ctrl = false, $isup = true, $isdown = true, $val = false, $style = false)
{
 $ret  = "<tr>";
 $ret .= $ctrl ? '<td><input type="checkbox" id="1qw23g84y5jbg843y" name="element[]" value="'.$data['id'].'"></td>' : '';
 $req  = ($data['req']==1) ? DrawStar($style) : '';
 $ret .= "<td class=\"formLabel\"><b>".$data['title']."</b> ".$req."</td>\r\n";
 $ret .= '<td>'.($val ? "[<".$data['vals'].">]" : $data['title'])."</td>\r\n";

 $up   = $isup   ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=up"><img src="images/icon-arrow-up.gif" alt="Up" border="0" align="absmiddle"></a>'     : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $down = $isdown ? '<a href="coder.php?page='.$data['page_id'].'&field='.$data['id'].'&move=down"><img src="images/icon-arrow-down.gif" alt="Down" border="0" align="absmiddle"></a>' : '<img src="images/1x1.gif" border=0 width=13 height=13">';
 $ret .= $ctrl ? '<td nowrap><a href="draw.php?do=edit&id='.$data['id'].'&field='.$data['type'].'&page='.$data['page_id'].'" class="slink"><img src="images/icon-action-edit.gif" alt="<#msg_open#>" border="0" align="absmiddle"><#msg_open#></a> '.$up.' '.$down.'</td>' : '';
 
 $ret .= "</tr>";
 return $ret;
}

function DrawStar($styled = false)
{
	return $styled ? '<span class="arrow">*</span>' : '<font color="#FF0000">*</font>';
}

function FieldPrefix($data)
{
 switch ($data['valid'])
 {
	case EMAIL:
		$prefix = 'e';
		break;
	case DIGITS:
		$prefix = 'd';
		break;
	case CURRENCY:
		$prefix = 'c';
		break;
	case WORD:
		$prefix = 'w';
		break;
	case SPACES:
		$prefix = 's';
		break;
	case LINE:
		$prefix = 'n';
		break;
	default:
		$prefix = '';
 }
 
 $prefix  = (($data['type'] == MULTILIST)||($data['type'] == CHECKBOX)) ? 'm' : $prefix;
 $prefix  = ($data['req']==1) ? 'r'.$prefix : $prefix;
 $prefix .= empty($prefix) ? '' : '_';
 
 return $prefix;
}
?>
