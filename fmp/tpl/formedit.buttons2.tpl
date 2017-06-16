<tr>
<td class="color5"><table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td class="color2"><table border="0" align="right" cellpadding="9" cellspacing="0">
<tr>
<td class="color2"></td>
</tr>
</table><table border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="25" height="29" align="right" valign="middle"></td>
<td valign="middle" colspan="3" nowrap></td>
<td>
<input type="button" class="button" value="<#msg_get_pages#>" onclick="return PreLoad();">&nbsp;
</td>
</tr>

<script language="JavaScript">
 function PreLoad()
 {
  var msg;
  
  msg = "<#msg_dear#> <#uname#>,\n";
  msg += "<#msg_correct_form#>";
  
<!-- BEGIN row_msg -->
  msg += "<#msg_name#> - <#msg_url#>\n"
<!-- END row_msg -->

  msg += "<#msg_cannot_url#>";
  alert(msg);

   document.location = "generate.php?form=<#formid#>";

 }
</script>

</table></td>
</tr>
</table></td>
</tr>