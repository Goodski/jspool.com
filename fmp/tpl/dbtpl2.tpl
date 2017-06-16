<tr>
<td class="color2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
</table>
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_log_tpl#></span></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%">
<!-- ~~~ (fields set #3) ~~~ -->
<table border="0" cellspacing="5" cellpadding="0" width="100%">
<form action="db.php?do=<#do#>&form=<#formid#><#db#>" method="post" name="frm"> 
<tr>
<td align="right" width="10%" nowrap><strong><#msg_tpl_name#></strong> <span class="tlabel">*</span></td>
<td>
<input type="Text" name="name" id="name" size="35" class="fields" value="<#name#>">
</td>
</tr>
<tr>
<td align="center" nowrap colspan="2">

<!-- BEGIN row -->
<a href="#" class="nlink" onclick="javascript:  window.open('wideform.php?page=<#pageid#>','_blank','height=400,width=600,toolbar=no,status=no,scrollbars=yes,resizable=yes,menubar=no,location=no,direction=no')"><#pagename#></a>
<br><br>
<table width="50%" border="0" cellspacing="0" cellpadding="0" class="data">
<thead>
<tr>
<th id="firsth" width="50%"><a id="notselected"><#msg_field_name#></a></th>
<th><a id="notselected"><#msg_field_type#></a></th>
<th><a id="notselected"><#msg_use_in_query#></a></th>
<th><a id="notselected"><#msg_display#></a></th>
</tr>
</thead>
<tbody>
<#fields#>
</tbody>
</table>
<br>
<!-- END row -->

</td>
</tr>
</table>
</td>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
<tr>
<td colspan="3" class="color5" height="1"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
</table><!-- ~~~ [<<< table for fields set #3] ~~~ -->


<!-- ~~~ [table for fields set #4 >>>] ~~~ -->

<!-- ~~~ [<<< table for fields set #4] ~~~ -->
</td>
</tr><!-- ~~~ [<<< forms 1] ~~~ -->
<!-- ~~~ [stupid line >>>] ~~~ --><tr>
<td class="color5"><img src="images/1x1.gif" width="1" height="1"></td>
</tr><!-- ~~~ [<<< stupid line] ~~~ -->
<!-- ~~~ [submiters >>>] ~~~ --><tr>
<td align="center" class="color2"><input name="Submit" type="submit" class="buttons" value="<#msg_submit#>"> <input name="Cancel" type="button" class="buttons" value="<#msg_cancel#>" onclick="document.location = 'formedit.php?form=<#formid#>'"> <input name="Reset" type="reset" class="button" value="<#msg_reset#>"></td>
</tr><!-- ~~~ [<<< submiters] ~~~ -->
</table></td>
</tr>
</tr>
<script language="JavaScript">
function setDisplay(box, id)
{

	document.getElementById("disp"+id).disabled = !box.checked;
	document.getElementById("disp"+id).checked = box.checked;
}
</script>
</form>