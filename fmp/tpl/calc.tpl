<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_calc_field_adding#> "<#pagename#>"</span> &nbsp;<a href="#" class="nlink" onclick="javascript:  window.open('wideform.php?page=<#pageid#>','_blank','height=400,width=600,toolbar=no,status=no,scrollbars=yes,resizable=yes,menubar=no,location=no,direction=no')"><#msg_preview#></a></td>
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


<table border="0" width="100%" height="39" background="">
  <tr>
    <td width="31%" height="33" valign="middle" background="">
	<p align="right"><b><#msg_title_name#> *&nbsp;&nbsp;&nbsp;</b></td>
    <td width="69%" height="33" valign="middle" background=""><input type="text" name="title" size="33"  value="<#ftitle#>"></td>
  </tr>
  <tr>
    <td width="31%" height="33" valign="middle" background=""><p align="right"><#msg_calc#>&nbsp;&nbsp;&nbsp;</td>
    <td width="69%" height="33" valign="middle" background="">

    <select size="1" name="calc">
    <#calcs#>
    </SELECT>

    </td>
  </tr>
  </table>
  <table border="0" width="100%" height="39" background="">

  </table>

<script language=javascript>
function checkform()
{
	if (document.form1.title.value=='')
	{
		alert ("<#msg_title_blank#>");
		document.form1.title.select();
		document.form1.title.focus();
		return false;
	}   
	else
	{
		return true;
	}
}



</script>