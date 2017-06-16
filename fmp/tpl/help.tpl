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
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_general_details#></span></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%" align="center">
<form action="fasthelp.php?do=send" name="form1" method="post">
<table border="0" align="left" cellpadding="0" cellspacing="5">
<tr>
<td align="right" nowrap><strong><#msg_login#></strong> <span class="tlabel">*</span></td>
<td>
<input name="login" value="<#login#>" type="text" class="fields" size="35">
</td>
</tr>
<tr>
<td align="right" nowrap><strong><#msg_email#></strong> <span class="tlabel">*</span></td>
<td>
<input name="email" value="<#email#>" type="text" class="fields" size="35">
</td>
</tr>

<tr>
<td align="right" nowrap><strong><#msg_type_of_request#></strong> <span class="tlabel">*</span></td>
<td>
<select name="req_type" class="selects">
	<option value="1"<#sel1#>><#msg_help_on_service#></option>
	<option value="2"<#sel2#>><#msg_bug_report#></option>
</select>
</td>
</tr>


</tr>
<tr>
<td align="right" nowrap valign="top"><strong><#msg_request#></strong> <span class="tlabel">*</span></td>
<td>
<textarea name="request" cols="80" rows="10"><#request#></textarea>
</td>
</tr>
<INPUT type="hidden" name="ref" value="<#ref#>">
</table>
</form>
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
<td align="center" class="color2"><input name="Submit" type="submit" class="buttons" value="<#msg_submit#>" onclick="document.form1.submit();"> <input name="Cancel" type="button" class="button" value="<#msg_cancel#>" onclick="document.location = '<#ref#>';"></td>
</tr>

</table>

</td>
</tr>



















<tr>
<td class="color6">







<table width="99%" border="0" align="center" cellpadding="0" cellspacing="6">
<tr>
<td colspan="2"><img src="images/1x1.gif"></td>
</tr>

<tr>
<td colspan="2">


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="data">
<thead>
<tr>
<th width="10%" id="firsth"><a id="selected3">Date</a></th>
<th width="15%"><a>Request type</a></th>
<th><a>Request</a></th>
<th width="10%"><a>Status</a></th>
</tr>
</thead>
<tbody>
<!-- BEGIN row -->
<tr<#class#> >
<td height="23" class="f"><#date#></td>
<td><#type#></td>
<td><b><a href="fasthelp.php?do=show&hash=<#hash#>"><#body#></a></b></td>
<td><#status#></td>
</tr>
<!-- END row -->
</tbody>
</table>
</td>
</tr>
<tr>
<td colspan="2"><img src="images/1x1.gif"></td>
</tr>
</table>
</td>
</tr>