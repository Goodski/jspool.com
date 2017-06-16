<tr>
<td class="color2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
</table>

<form name=form1 onsubmit="return checkform()"  action="coder.php?do=<#do#>&page=<#pageid#>&field=<#field#>&pos=<#pos#>" method=post>

<table width="11%" border="0" align="left" cellpadding="0" cellspacing="0">
</table>
<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_form_design#> "<#pagename#>"</span> &nbsp;<a href="#" class="nlink" onclick="javascript:  window.open('wideform.php?page=<#pageid#>'_blank','height=400,width=600,toolbar=no,status=no,scrollbars=yes,resizable=yes,menubar=no,location=no,direction=no')"><#msg_preview#></a></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%">


<table border="0" cellspacing="5" cellpadding="0" width="100%">
<tr>
<td align="center">

<#out1#>

</td>
</tr>

</table>
</td>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
<tr>
<td colspan="3" class="color5" height="1"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
</table><!-- ~~~ [<<< table for fields set #4] ~~~ -->
</td>
</tr><!-- ~~~ [<<< forms 1] ~~~ -->
<!-- ~~~ [stupid line >>>] ~~~ --><tr>
<td class="color5"><img src="images/1x1.gif" width="1" height="1"></td>
</tr><!-- ~~~ [<<< stupid line] ~~~ -->
<!-- ~~~ [submiters >>>] ~~~ --><tr>
<td align="center" class="color2">

<input type="Submit" class="buttons" value="<#msg_submit#>">
<input type="button" class="button" value="<#msg_cancel#>" onclick="document.location = 'coder.php?page=<#pageid#>';">
</table></td>
</tr>
</tr>



</form>
