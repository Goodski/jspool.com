
<table border="0" width="100%" height="39" background="">
<tr><td colspan="2"><span class="title"><#msg_calc_field_adding#> "<#pagename#>"</span></td></tr>
</table>

<TABLE width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="40%">

<TABLE cellpadding="0" cellspacing="0" width="100%" border="0">
<tr valign="top">
<td>
<b><#msg_title_name#> *</b>
</td>
<td>
<input type="text" name="title" size="35" value="<#ftitle#>">
</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>

<tr valign="top">
<td>
<b>Operators</b>
</td>
<td>
<input type="button" class="buttons" value=" + " onclick="AddSign('+')"> 
<input type="button" class="buttons" value=" - " onclick="AddSign('-')"> 
<input type="button" class="buttons" value=" * " onclick="AddSign('*')"> 
<input type="button" class="buttons" value=" / " onclick="AddSign('/')"> 
<input type="button" class="buttons" value=" ( " onclick="AddSign('(')"> 
<input type="button" class="buttons" value=" ) " onclick="AddSign(')')">
</td></tr>

<tr>
<td>
<b>Formula:</b>
</td>
<td>
<TEXTAREA name="formula" onselect="storeCaret(this)" onclick="storeCaret(this)" onkeyup="storeCaret(this)" cols="35" rows="3"><#formula#></TEXTAREA>

</td></tr></TABLE>

</td>
<td>


<table width="80%" border="0" cellpadding="0" cellspacing="0" class="data" align="center">
<THEAD>
<th id="firsth" width="30%"><a id="notselected">Variable name</a></th>
 <th><a id="notselected">Title</a></th>
 </THEAD>
<tbody>
<!-- BEGIN row -->
<tr<#class#>>
<td class="f" align="center"><a class="nlink" href="#" onclick="insertText(document.form1.formula,'<#letter#>');"><#letter#></a></td>
<td><a class="nlink" href="#" onclick="insertText(document.form1.formula,'<#letter#>');"><#fld_title#></a>
<INPUT type="hidden" name="fld_id[<#fld_id#>]" value="<#letter#>">
</td>
</tr>
<!-- END row -->
</tbody>
</table>
</td></tr>
</table>
<script language="JavaScript">
function checkform()
{
	if (document.form1.title.value == "")
	{
		alert ("<#msg_title_blank#>");
		document.form1.title.select();
		document.form1.title.focus();
		return false;	
	}

	if (document.form1.formula.value == "")
	{
		alert ("<#msg_formula_blank#>");
		document.form1.formula.select();
		document.form1.formula.focus();
		return false;	
	}
	
	return true;
}

function storeCaret(element){
   if (document.selection && document.selection.createRange){
      element.caretPos=document.selection.createRange().duplicate();
   }else if(element && element.selectionStart){
      element.caretPosNN=element.selectionStart;
   }
}

function insertText(element,text){
   element.focus();
   if (element && element.caretPos){
      element.caretPos.text=text; 
   }else if (element && element.caretPosNN+1 && element.selectionEnd+1){
      element.value=element.value.substring(0,element.selectionStart)+text+element.value.substring(element.selectionEnd,element.value.length); 
      element.setSelectionRange(element.caretPosNN+text.length,element.caretPosNN+text.length);
   }else if (element){
      element.value+=text;
   }
} 

function AddSign(sign)
{
	insertText(document.form1.formula,sign);
}
</SCRIPT>
<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="100%">

<table border="0" cellspacing="0" cellpadding="0" width="0%">
<tr><td align="center">