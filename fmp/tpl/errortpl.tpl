<!-- ~~~ [system msg (note) >>>] ~~~ -->
<tr>
<td class="color8"><table width="100%" border="0" cellspacing="2" cellpadding="0">
<tr valign="top">
<td><img src="images/sysmsg-icon-info.gif" alt="information" width="33" height="33" hspace="10" vspace="9"></td>
<td width="100%" class="color2"><table width="100%" border="0" cellspacing="9" cellpadding="0">
<tr>
<td><!-- ~~~ (message>>) ~~~ --><strong>Info mesage:</strong><br>
The placeholders [%OUT_TITLE] and [%OUT_MSG] have to be in error.html. [%OUT_TITLE] is the name of the error; [%OUT_MSG] is the error message. 
</tr>
</table></td>
</tr>
</table></td>
</tr>



<tr>
<td class="color2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel">Error template</span></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%" align="center">
<form action="error.php?do=update&form=<#formid#>" method="post">
<table border="0" align="left" cellpadding="0" cellspacing="5">

<tr>
<td align="right" nowrap colspan="2">
<textarea rows="20" cols="100" name="error"><#errortpl#></textarea>

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
<td align="center" class="color2"><input name="Submit" type="submit" class="buttons" value="Submit"> <input name="Cancel" type="button" class="buttons" value="<#msg_cancel#>" onclick="document.location = 'formedit.php?form=<#formid#>'"> <input name="Reset" type="reset" class="button" value="Reset"></td>
</tr><!-- ~~~ [<<< submiters] ~~~ -->

</table>

</td>
</tr>

</form>


