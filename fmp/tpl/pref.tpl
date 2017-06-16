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
<form action="options.php?do=update" name="form1" method="post">
<table border="0" align="left" cellpadding="0" cellspacing="5">
<tr>
<td align="right" nowrap><strong><#msg_language#></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>
 <select class="selects" name="lan">
   <option value="english">english</option>
 </select>
</td>
</tr>

<tr>
<td align="right" nowrap><strong><#msg_login#></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>
<input name="log" value="<#log#>" disabled type="text" class="fields" size="35">
</td>
</tr>
<tr>
<td align="right" nowrap><strong><#msg_password#></strong> <span class="tlabel">*</span></td>
<td>
<input type="Password" name="pass" value="<#pass#>" class="fields" size="35">
</td>
</tr>

<tr>
<td align="right" nowrap><strong><#msg_confirm#></strong> <span class="tlabel">*</span></td>
<td>
<input type="Password" name="pass2" value="<#pass#>" class="fields" size="35">
</td>
</tr>

<tr>
<td align="right" nowrap><strong><#msg_email#></strong> <span class="tlabel">*</span></td>
<td>
<input name="email" value="<#email#>" type="text" class="fields" size="35">
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
<td class="color2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel">Settings</span></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%" align="center">
<table border="0" align="left" cellpadding="0" cellspacing="5">


<tr>
<td align="right" nowrap><strong>Show tips</strong></td>
<td>
<INPUT type="checkbox" value="1" name="tipz"<#tipz#>>
</td>
</tr>



<tr>
<td align="right" nowrap><strong>Date format</strong></td>
<td>
<select name="date_format" class="selects">
<OPTION value="d.m.Y"<#df1#>>DD.MM.YYYY</OPTION>
<OPTION value="m.d.Y"<#df2#>>MM.DD.YYYY</OPTION>
</SELECT>
</td>
</tr>


<tr>
<td align="right" nowrap><strong>Time format</strong></td>
<td>
<select name="time_format" class="selects">
<OPTION value="H:i:s"<#tf1#>>24 hours</OPTION>
<OPTION value="g:i:sa"<#tf2#>>12 hours</OPTION>
</SELECT>
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
</form>









<tr>
<td class="color5"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
<tr>
<td align="center" class="color2"><input name="Submit" type="submit" class="buttons" value="<#msg_submit#>" onclick="document.form1.submit();"> <input name="Reset" type="reset" class="button" value="<#msg_reset#>" onclick="document.form1.reset();"></td>
</tr>
</table>
</td>
</tr>
