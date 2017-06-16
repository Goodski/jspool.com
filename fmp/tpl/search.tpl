<tr>
<td class="color5"><table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td class="color2"><table border="0" align="right" cellpadding="9" cellspacing="0">

</table><table border="0" width="98%" cellspacing="0" cellpadding="0">
<form name="form2" method="post" action="<#saction#>">
<tr>
<td width="25" height="29" align="right" valign="middle"><img src="images/magnifier.png" width="16" height="16" hspace="4" align="top"></td>
<td valign="middle" nowrap><#msg_search#>:&nbsp;</td>
<td><input name="search" type="text" value="<#s_query#>" class="fields">
&nbsp;&nbsp;&nbsp;
<select class="selects" name="s_key">
<option value="">All fields</option>
<#s_options#>
</select>

<INPUT type="checkbox" name="wholeword" value="1" class="checkboxes"<#whole_check#>>Match whole word only</INPUT>
</td>
<td align="right">&nbsp;<input name="Submit" type="submit" class="buttons" value="<#msg_search#>"></td>
</tr>
</form>
</table>
</td>
</tr>
</table></td>
</tr>