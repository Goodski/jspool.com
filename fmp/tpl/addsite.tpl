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
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_site_details#></span></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%" align="center">
<table border="0" align="left" cellpadding="0" cellspacing="5">
<form action="sites.php?<#do#>=<#id#>" method="post">
<tr>
<td align="right" nowrap><strong><#msg_site_url#></strong> <span class="tlabel">*</span></td>
<td>
<input name="sitename" value="<#sitename#>" type="text" id="name" class="widefields" size="60" onBlur="copyURL();" >
</td>
</tr>

<tr>
<td align="right" nowrap><strong><#msg_site_reffs#></strong> <span class="tlabel">*</span></td>
<td><input name="siterefs" type="text" value="<#siterefs#>" id="refs" class="widefields" size="60"></td>
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
<td align="center" class="color2"><input name="Submit" type="submit" class="buttons" value="<#msg_submit#>"> <input name="Cancel" type="button" class="buttons" value="<#msg_cancel#>" onclick="document.location = 'sites.php';"> <input name="Reset" type="reset" class="button" value="<#msg_reset#>"></td>
</tr><!-- ~~~ [<<< submiters] ~~~ -->
</form>
</table>

</td>
</tr>

<script>
 function copyURL()
 {
 var refs, name;
 
   refs = document.getElementById('refs');
   name = document.getElementById('name');
  
  if (name.value != '')
  {
   var sname = name.value.toLowerCase();
   if (sname.substring(0,7)=='http://')
   {
    sname = sname.substring(7,sname.length);
   }
   else
   {
     if (sname.substring(0,8)=='https://')
     {
      sname = sname.substring(8,sname.length);
     }    
   }
  

  var kname = '';
  for (var i = 0; i < sname.length; i++) {
    var chr = sname.charAt(i);
	if (chr != '/')	kname = kname + chr;
  }
  sname = kname;
  
  if (sname.substring(0,4)=='www.')
  {
   sname = sname.substring(4,sname.length);
  }  
   
   refs.value = sname + ',' + 'www.' + sname;
   }
 }
</script>
