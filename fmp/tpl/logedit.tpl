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
<form action="logedit.php?do=update&id=<#id#>&log=<#log#>" name="form1" method="post">
<table border="0" align="left" cellpadding="0" cellspacing="5">

<tr>
<td align="right" nowrap><strong>ID</strong></td>
<td>
<#id#>
</td>
</tr>

<!-- BEGIN row -->
<tr>
<td align="right" nowrap><strong><#title#></strong></td>
<td>
<input type="text" name="<#name#>" value="<#value#>" class="fields">
</td>
</tr>
<!-- END row -->

<tr><td>&nbsp;</td><td></td></tr>
<tr>
<td align="right" valign="top" nowrap><strong>Comments:</strong></td>
<td>
<INPUT type="text" class="fields" name="comments" value="<#comments#>">
</td>
</tr>


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
<td align="center" class="color2"><input name="Submit" type="submit" class="buttons" value="<#msg_save#>" onclick="document.form1.submit();"> <input name="Cancel" type="button" class="button" value="<#msg_cancel#>" onclick="document.location = 'browse.php?id=<#log#>&form=<#form_id#>';"></td>
</tr>

</table>

</td>
</tr>