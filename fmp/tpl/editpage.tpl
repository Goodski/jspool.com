<!-- ~~~ [system msg (note) >>>] ~~~ -->
<tr>
<td class="color4"><table width="100%" border="0" cellspacing="6" cellpadding="0">
<tr>
<td><!-- ~~~ (message>>) ~~~ --><span class="tlabel">*</span> <#msg_req_fields#></td>
</tr>
</table>
</td>
</tr>
<!-- ~~~ [<<< system msg (note)] ~~~ -->
<!-- ~~~ [forms 1 >>>] ~~~ -->
<tr>
<td class="color2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_page_details#></span></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%" align="center">
<table border="0" align="left" cellpadding="0" cellspacing="5">
<form action="addpage.php?form=<#formid#>&do=<#do#>" method="post">
<tr>
<td align="right" nowrap><strong><#msg_page_name#></strong> <span class="tlabel">*</span></td>
<td>
<input name="pagename" value="<#pagename#>" id="pagename" type="text" class="widefields" size="100"<#onblur#>>
</td>
</tr>
<tr>
<td align="right" nowrap><strong><#msg_page_url#></strong> <span class="tlabel">*</span></td>
<td>
<input name="pageurl" value="<#pageurl#>" id="pageurl" type="text" class="widefields" size="100"<#disabled#>>
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
<td align="center" class="color2"><input name="Submit" type="submit" class="buttons" value="<#msg_submit#>"> <input name="cancel" type="button" class="buttons" value="<#msg_cancel#>" onclick="document.location = 'formedit.php?form=<#formid#>';"> <input name="Reset" type="reset" class="button" value="<#msg_reset#>"></td>
</tr><!-- ~~~ [<<< submiters] ~~~ -->
</form>
</table>

<script language="JavaScript">
 function SetURL()
 {
  var name, url, kname = '', html = '';
  var def = '<#site_url#>';
  name = document.getElementById('pagename');
  url  = document.getElementById('pageurl');

  sname = name.value;
  
  for (var i = 0; i < sname.length; i++) {
    var chr = sname.charAt(i);
	
	if (chr == ' ')
	{
		kname = kname + '-';
	}
	else
	{
	 kname = kname + chr;
	}
  }
  
  kname = escape(kname);
  if ((kname.charAt(kname.length-4) !='.') &&  (kname.charAt(kname.length-5) !='.')) 
  {
   html = '.html';
  }
  
  url.value = def + kname + html;

 }
</script>

</td>
</tr>

