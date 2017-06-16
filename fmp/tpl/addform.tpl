<tr>
<td class="color4"><table width="100%" border="0" cellspacing="6" cellpadding="0">
<tr>
<td><span class="tlabel">*</span> <#msg_req_fields#></td>
</tr>
</table>
</td>
</tr>

<tr>
<td class="color2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_form_details#></span></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%" align="center">
<table border="0" align="left" cellpadding="0" cellspacing="5">
<form action="forms.php?do=<#do#>" name="frm" method="post">
<tr>
<td align="right" nowrap><strong><#msg_form_name#></strong> <span class="tlabel">*</span></td>
<td>
<input name="formname" value="<#formname#>" type="text" class="widefields" size="61">
</td>
</tr>
<tr>
<td align="right" nowrap><strong><#msg_web_site#></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>
 <select name="siteid" class="selects">
  <OPTION value="0">Form Maker Pro server</OPTION>
  <#sitelist#>
 </select>
</td>
</tr>


<tr>
<td align="right" nowrap><strong><#msg_preset#></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>
 <select name="form_preset" class="selects" onchange="PresetPrev();">
 <option value="0">None</OPTION>
  <#form_presets#>
 </select>
 
<input type="button" value="preview" disabled name="prev" onclick="javascript:  window.open('preset.php?id='+document.frm.form_preset.value,'_blank','height=400,width=600,toolbar=no,status=no,scrollbars=yes,resizable=yes,menubar=no,location=no,direction=no')"> 
<input type="button" value="delete" disabled name="delpres" onclick="javascript: DelPreset(document.frm.form_preset.value);">
</td>
</tr>

<tr>
<td align="right" nowrap><strong>Preview</strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<input name="preview_page" value="1" type="checkbox">
</td>
</tr>

<tr>
<td align="right" nowrap><strong><#msg_thx_page#></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<input name="thkupage" value="1" type="checkbox" onclick="CheckThx();">
</td>
</tr>



<tr>
<td align="right" nowrap><strong><span id="rlabel">Redirect URL</SPAN></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<input name="redirect" value="<#redir#>" type="text" class="widefields" size="61">
</td>
</tr>

<tr>
<td align="right" nowrap><strong>Stop processing this form by</strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<input name="stopcheck" value="1" type="checkbox" <#stop_check#> onclick="setStopDate();">
<select name="stop_month">
<#stop_month#>
</SELECT>
<SELECT name="stop_day">
<#stop_day#>
</SELECT>
<SELECT name="stop_year">
<#stop_year#>
</SELECT>
</td>
</tr>

<script language="JavaScript">

function setStopDate()
{
	document.frm.stop_month.disabled	= !document.frm.stopcheck.checked;
	document.frm.stop_day.disabled		= !document.frm.stopcheck.checked;
	document.frm.stop_year.disabled		= !document.frm.stopcheck.checked;
}
function CheckThx()
{
	document.frm.redirect.disabled		= document.frm.thkupage.checked;
	document.getElementById('rlabel').disabled = document.frm.thkupage.checked;
}

setStopDate();
CheckThx();
</script>


<tr>
<td align="right" nowrap><strong><span id="rlabel">Unique submissions</SPAN></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<INPUT type="checkbox" name="unique" value="1"<#unique#>>results will be taken once for each different IP
</td>
</tr>

</table>
</td>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
<tr>
<td colspan="3" class="color5" height="1"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
</table>

</td>
</tr>
<tr>
<td class="color5"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
<tr>
<td align="center" class="color2"><input name="Submit" type="submit" class="buttons" value="<#msg_submit#>"> <input name="Cancel" type="button" class="buttons" value="<#msg_cancel#>" onclick="document.location = 'forms.php';"> <input name="Reset" type="reset" class="button" value="<#msg_reset#>"></td>
</tr>

<script language="JavaScript">
function PresetPrev()
{
	var link = document.frm.prev;
	var delp = document.frm.delpres;
	
	if (document.frm.form_preset.value > 0)
	{
		link.disabled = false;
		delp.disabled = false;
	}
	else
	{
		link.disabled = true;
		delp.disabled = true;
	}
}

function DelPreset(id)
{
	if (confirm('Are you sure you want to remove selected preset?'))
	{
		document.location = 'preset.php?do=delete&pid=' + id + '&site=' + document.frm.siteid.value;
	}
}
</script>
</form>
</table>

</td>
</tr>






