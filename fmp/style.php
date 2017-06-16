<?php 
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/draw.php");

/**
 * Definitions
 */
 
 $faces		= array("Helvetica Neue", "Arial, Sans-serif", "Verdana", "Times, Serif", "Script, Cursive", "Comic, Fantacy", "Monospace, Courier");
 $sizes		= array("8px", "9px", "10px", "11px", "12px", "13px", "14px", "15px", "16px", "17px", "18px");
 $widths	= array("0px", "1px", "2px", "3px", "4px", "5px");
 $margins	= array("0px", "5px", "10px", "15px", "20px", "25px", "30px", "35px", "40px","50px");
 $fwidths	= array("50px", "100px", "125px", "150px", "175px", "200px", "225px", "250px", "275px", "300px");
 $lfloats	= array("left", "none");
  

if ($_GET['do'] == 'save')
{
	SaveStyle();
}

if ($_GET['do'] == 'clear')
{
	ClearStyle();
}

	$t = new Template("tpl");
	$t->set_file(array("page" => $index2_tpl, "main"=> "style.tpl"));		 
	$t->set_block("main","row","rows");
	$t->set_var(array(	"uname"		=> $uname,
						"path"		=> "<a href=\"forms.php\">".$_LANG['msg_forms']."</a> / <span id=\"selected\"><b>".$_LANG['msg_styling']."</span>",
						"subheader_icon" => "images/application_form.png",
						"path_info"	=> $_LANG['msg_styling'],
						"descr"	 => $_LANG['msg_styling_tip']));
	$t->set_var("referer", $_SERVER['HTTP_REFERER']);

    if (is_array($_POST['chk']))						
    {
    	$style = count($_POST['chk'] == 1) ? getStyle($_POST['chk'][0]) : getStandartStyle();
    }
    else 
    {
    	if (intval($_GET['form'])>0)
    	{
    		$style = getStyle($_GET['form']);
    	}
    	else 
    	{
		    header("Location: ".$_SERVER['HTTP_REFERER']);	
    		exit();
    	}
    }

    /**
     * Fonts assignment
     */
     
    foreach ($faces as $font)
    {
    	$header_font_opts	.= "<OPTION VALUE=\"".$font."\"".($font == $style['head_font'] ? " SELECTED" : "").">".$font."</OPTION>\n";
    	$text_font_opts		.= "<OPTION VALUE=\"".$font."\"".($font == $style['text_font'] ? " SELECTED" : "").">".$font."</OPTION>\n";
	   	$fields_font_opts	.= "<OPTION VALUE=\"".$font."\"".($font == $style['fields_font'] ? " SELECTED" : "").">".$font."</OPTION>\n";
    	$submit_font_opts	.= "<OPTION VALUE=\"".$font."\"".($font == $style['submit_font'] ? " SELECTED" : "").">".$font."</OPTION>\n";
		$labels_font_opts	.= "<OPTION VALUE=\"".$font."\"".($font == $style['labels_font'] ? " SELECTED" : "").">".$font."</OPTION>\n";
    }
    
    $t->set_var("header_font_opts", $header_font_opts);
    $t->set_var("text_font_opts", $text_font_opts);
    $t->set_var("fields_font_opts", $fields_font_opts);
    $t->set_var("submit_font_opts",	$submit_font_opts);
	$t->set_var("labels_font_opts", $labels_font_opts);
    
    
    /**
     * Sizes assignment
     */
     
    foreach ($sizes as $size) 
    {
    	$header_size_opts	.= "<OPTION VALUE=\"".$size."\"".($size == $style['head_size'] ? " SELECTED" : "").">".$size."</OPTION>\n";		
    	$text_size_opts		.= "<OPTION VALUE=\"".$size."\"".($size == $style['text_size'] ? " SELECTED" : "").">".$size."</OPTION>\n";		
    	$fields_size_opts	.= "<OPTION VALUE=\"".$size."\"".($size == $style['fields_size'] ? " SELECTED" : "").">".$size."</OPTION>\n";		
    	$submit_size_opts	.= "<OPTION VALUE=\"".$size."\"".($size == $style['submit_size'] ? " SELECTED" : "").">".$size."</OPTION>\n";		
    }
    
    $t->set_var("header_size_opts",	$header_size_opts);
    $t->set_var("text_size_opts",	$text_size_opts);
    $t->set_var("fields_size_opts",	$fields_size_opts);
    $t->set_var("submit_size_opts",	$submit_size_opts);
    
    /**
     * Border widths assignment
     */
     
	foreach ($widths as $width) 
   	{
		$form_width_opts	.= "<OPTION VALUE=\"".$width."\"".($width == $style['form_border_width'] ? " SELECTED" : "").">".$width."</OPTION>\n";		
	}
	
	foreach ($fwidths as $fwidth) 
	{
		$form_fwidth_opts	.= "<OPTION VALUE=\"".$fwidth."\"".($fwidth == $style['fields_width'] ? " SELECTED" : "").">".$fwidth."</OPTION>\n";		
	}
	
	foreach ($fwidths as $lwidth) 
	{
		$labels_width_opts	.= "<OPTION VALUE=\"".$lwidth."\"".($lwidth == $style['labels_width'] ? " SELECTED" : "").">".$lwidth."</OPTION>\n";		
	}
   
   	$t->set_var("form_width_opts",		$form_width_opts);
	$t->set_var("labels_width_opts",		$labels_width_opts);
	$t->set_var("form_fwidth_opts",		$form_fwidth_opts);

	
    /**
     * Margin assignment
     */
     
	foreach ($margins as $margin) 
   	{
		$margin_opts	.= "<OPTION VALUE=\"".$margin."\"".($margin == $style['form_margin'] ? " SELECTED" : "").">".$margin."</OPTION>\n";		
	}
   
   	$t->set_var("margin_opts",		$margin_opts);
   	   	
   	/**
   	 * Color assignment
   	 */
   	 
   	$t->set_var("bg_color",		$style['bg_color']);
   	
   	$t->set_var("head_color",	$style['head_color']);
   	
   	$t->set_var("text_color",	$style['text_color']);
   	$t->set_var("arrow_color",	$style['text_arrow']);
   	
   	$t->set_var("form_bg_color",	$style['form_bg_color']);
   	$t->set_var("form_br_color",	$style['form_border_color']);

   	$t->set_var("fields_fg_color",	$style['fields_fg']);
   	$t->set_var("fields_bg_color",	$style['fields_bg']);
   	$t->set_var("fields_br_color",	$style['fields_border_c']);
   	
  	
   	/**
   	 * Checkbox assignment
   	 */
   	 
   	$t->set_var("border_yes", $style['fields_border'] ? "checked " : "");
   	$t->set_var("border_no", !$style['fields_border'] ? "checked " : "");

   	$t->set_var("bold_yes", $style['submit_bold'] ? "checked " : "");
   	$t->set_var("bold_no", !$style['submit_bold'] ? "checked " : "");
   	
   	$t->set_var("lbold_yes", $style['labels_bold'] ? "checked " : "");
   	$t->set_var("lbold_no", !$style['labels_bold'] ? "checked " : "");
   	 
   	 
    $t->set_var("forms", is_array($_POST['chk']) ? implode(";", $_POST['chk']) : intval($_GET['form']));
	$t->set_var($_LANG);
	$t->parse("OUT", array("main", "page"));
	$t->p("OUT");	

	
function getStyle($form_id)
{
	$res = @mysql_query("SELECT style FROM forms WHERE id = ".intval($form_id).";");
	$row = @mysql_fetch_row($res);
	
	return empty($row[0]) ? getStandartStyle() : unserialize($row[0]);
}

function getStandartStyle()
{
	$style = array();
	
	// Background
	$style['bg_color']			= '#FFFFFF';
	
	// Header
	$style['head_font']			= 'Helvetica Neue';
	$style['head_size']			= '16px';
	$style['head_color']		= '#094761';
	
	// Text
	$style['text_font']			= 'Helvetica Neue';
	$style['text_size']			= '14px';
	$style['text_color']		= '#000000';
	$style['text_arrow']		= '#FF0000';
	
	// Form
	$style['form_bg_color']		= '#EEEEEE';
	$style['form_border_color']	= '#AAAAAA';
	$style['form_border_width']	= '2px';
	$style['form_margin']		= '25px';
	
	// Fields
	$style['fields_font']		= 'Helvetica Neue';
	$style['fields_size']		= '14px';
	$style['fields_fg']			= '#003D59';
	$style['fields_bg']			= '#FFFFFF';
	$style['fields_border']		= false;
	$style['fields_border_c']	= '#AAAAAA';
	$style['fields_width']	= '250px';
	
	//Labels
	$style['labels_font']		= 'Helvetica Neue';
	$style['labels_bold']		= true;	
	$style['labels_width']		= '100px';
	$style['labels_float']		= 'left';
	
	// Submit
	$style['submit_font']		= 'Helvetica Neue';
	$style['submit_size']		= '14px';
	$style['submit_bold']		= false;
	
	return $style;	
}

function SaveStyle()
{
	$style						= array();
	$style['bg_color']			= $_POST['bg_color'];
	$style['head_font']			= $_POST['h1_font'];
	$style['head_size']			= $_POST['h1_size'];
	$style['head_color']		= $_POST['h1_color'];
	$style['text_font']			= $_POST['g_font'];
	$style['text_size']			= $_POST['g_size'];
	$style['text_color']		= $_POST['g_color'];
	$style['text_arrow']		= $_POST['g_acolor'];
	$style['form_bg_color']		= $_POST['form_bg_color'];
	$style['form_border_color']	= $_POST['form_br_color'];
	$style['form_border_width']	= $_POST['form_br_t'];
	$style['form_margin']		= $_POST['form_ma'];
	$style['fields_font']		= $_POST['f_font'];
	$style['fields_size']		= $_POST['f_size'];
	$style['fields_fg']			= $_POST['f_fg_color'];
	$style['fields_bg']			= $_POST['f_bg_color'];
	$style['fields_border']		= ($_POST['f_bord'] == 1);
	$style['fields_border_c']	= $_POST['f_brd_color'];
	$style['fields_width']		= $_POST['f_width'];
	$style['labels_font']		= $_POST['l_font'];
	$style['labels_width']		= $_POST['l_width'];
	$style['labels_float']		= $_POST['l_float'];
	$style['labels_bold']		= ($_POST['lb_bold'] == 1);
	$style['submit_font']		= $_POST['sm_font'];
	$style['submit_size']		= $_POST['sm_size'];
	$style['submit_bold']		= ($_POST['sm_bold'] == 1);
	
	$ids = explode(";", $_GET['forms']);
	$style = mysql_escape_string(serialize($style));	
	
	foreach ($ids as $id)
	{
		$id = intval($id);
		@mysql_query("UPDATE forms SET style = '".$style."' WHERE id = ".$id.";");
	}
	
	header("Location: ".$_SERVER['HTTP_REFERER']);	
	exit();
}

function ClearStyle()
{
	if (is_array($_POST['chk']))
	{
		foreach ($_POST['chk'] as $id)
		{
			@mysql_query("UPDATE forms SET style = NULL WHERE id = ".intval($id).";");
		}
	}
	else
	{
		@mysql_query("UPDATE forms SET style = NULL WHERE id = ".intval($_GET['form']).";");
	}
	
	header("Location: ".$_SERVER['HTTP_REFERER']);	
	exit();
}
?>