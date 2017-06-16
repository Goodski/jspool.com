<tr>
<td class="color2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
</table>
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_log_tpl#></span></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%">

<table border="0" cellspacing="5" cellpadding="0" width="100%">
<form action="db.php?do=<#do#>&form=<#formid#><#db#>" method="post" name="frm"> 
<INPUT type="hidden" name="referer" value="<#referer#>">
<tr>
<td align="right" width="10%" nowrap><strong><#msg_tpl_name#></strong> <span class="tlabel">*</span></td>
<td>
<input type="Text" name="name" id="name" size="35" class="fields" value="<#name#>">
</td>
</tr>
<tr>
<td align="center" nowrap colspan="2">

<!-- BEGIN row -->
<a href="#" class="nlink" onclick="javascript:  window.open('wideform.php?page=<#pageid#>','_blank','height=400,width=600,toolbar=no,status=no,scrollbars=yes,resizable=yes,menubar=no,location=no,direction=no')"><#pagename#></a>
<br><br>
<table width="50%" border="0" cellspacing="0" cellpadding="0" class="data">
<thead>
<tr>
<th id="firsth" width="50%"><a id="notselected"><#msg_field_name#></a></th>
<th width="20%"><a id="notselected"><#msg_field_type#></a></th>
<th width="15%"><a id="notselected"><#msg_use_in_query#></a></th>
<th width="15%"><a id="notselected"><#msg_display#></a></th>
</tr>
</thead>
<tbody>
<#fields#>
</tbody>
</table>
<br>
<!-- END row -->





<br>
<center>Real time data</center><br>
<table width="50%" border="0" cellspacing="0" cellpadding="0" class="data">
<thead>
<tr>
<th id="firsth" width="35%"><a id="notselected"><#msg_field_name#></a></th>
<th width="35%"><a id="notselected">Description</a></th>
<th width="15%"><a id="notselected"><#msg_use_in_query#></a></th>
<th width="15%"><a id="notselected"><#msg_display#></a></th>
</tr>
</thead>
<tbody>

<tr class="dataodd">
<td>Remote Address</td>
<td>User's IP address</td>
<td><input type="checkbox" name="use_ip" onclick="set_pred(this, 'ip');" value="1"<#use_ip#>></td>
<td><input type="checkbox" name="show_ip" id="show_ip" value="1"<#show_ip#>></td>
</tr>

<tr bgcolor="#FFFFFF">
<td>HTTP Referrer</td>
<td>Referred page</td>
<td><input type="checkbox" name="use_ref" onclick="set_pred(this, 'ref');" value="1"<#use_ref#>></td>
<td><input type="checkbox" name="show_ref" id="show_ref" value="1"<#show_ref#>></td>
</tr>

<tr class="dataodd">
<td>Date</td>
<td>Date of submittion</td>
<td><input type="checkbox" name="use_date" onclick="set_pred(this, 'date');" value="1"<#use_date#>></td>
<td><input type="checkbox" name="show_date" id="show_date" value="1"<#show_date#>></td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Time</td>
<td>Time of submittion</td>
<td><input type="checkbox" name="use_time" onclick="set_pred(this, 'time');" value="1"<#use_time#>></td>
<td><input type="checkbox" name="show_time" id="show_time" value="1"<#show_time#>></td>
</tr>

</tbody>
</table>
<br>

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
</tr><tr>
<td align="center" class="color2"><input name="Submit" type="submit" class="buttons" value="<#msg_submit#>"> 
<input name="Cancel" type="button" class="buttons" value="<#msg_cancel#>" onclick="document.location = '<#referer#>'"> <input name="Reset" type="reset" class="button" value="<#msg_reset#>"></td>
</tr>
</table></td>
</tr>
</tr>
<script language="JavaScript">
function setDisplay(box, id)
{
	document.getElementById("disp"+id).disabled = !box.checked;
	document.getElementById("disp"+id).checked = box.checked;
}

function set_pred(box, id)
{
	document.getElementById("show_"+id).disabled = !box.checked;
	document.getElementById("show_"+id).checked = box.checked;
}

	document.frm.show_ip.disabled = !document.frm.use_ip.checked;
	document.frm.show_ip.checked  = document.frm.show_ip.disabled ? false : document.frm.show_ip.checked; 
	document.frm.show_ref.disabled = !document.frm.use_ref.checked;
	document.frm.show_ref.checked  = document.frm.show_ref.disabled ? false : document.frm.show_ref.checked; 
	document.frm.show_date.disabled = !document.frm.use_date.checked;
	document.frm.show_date.checked  = document.frm.show_date.disabled ? false : document.frm.show_date.checked; 
	document.frm.show_time.disabled = !document.frm.use_time.checked;
	document.frm.show_time.checked  = document.frm.show_time.disabled ? false : document.frm.show_time.checked; 
	
</script>
</form>
