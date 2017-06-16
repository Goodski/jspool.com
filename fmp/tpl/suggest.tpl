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
<form action="suggest.php?do=send" name="form1" method="post">
<table border="0" align="left" cellpadding="0" cellspacing="5">
<tr>
<td align="right" nowrap><strong><#msg_email#></strong> <span class="tlabel">*</span></td>
<td>
<input name="email" value="<#email#>" type="text" class="fields" size="35">
</td>
</tr>

<td align="right" nowrap valign="top"><strong>Suggestion</strong> <span class="tlabel">*</span></td>
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