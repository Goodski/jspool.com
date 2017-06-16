<tr>
<td class="color2">


<TABLE border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
<td valign="top" width="100%"> 
<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_form_design#> "<#page_name#>"</span> &nbsp;<a href="#" class="nlink" onclick="javascript:  window.open('wideform.php?page=<#pageid#>','_blank','height=400,width=600,toolbar=no,status=no,scrollbars=yes,resizable=yes,menubar=no,location=no,direction=no')"><#msg_preview#></a></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%">
<table border="0" cellspacing="2" cellpadding="0" width="100%">
<tr>
<td align="center">
<!-- BEGIN row -->
<#fields#>
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
</table>

</td>
<td>
<img src="images/1x1.gif" width="1" height="1">
</td>
<td valign="top"></td></tr>
</TABLE>






</td>
</tr><!-- ~~~ [<<< forms 1] ~~~ -->
<!-- ~~~ [stupid line >>>] ~~~ --><tr>
<td class="color5"><img src="images/1x1.gif" width="1" height="1"></td>
</tr><!-- ~~~ [<<< stupid line] ~~~ -->
<!-- ~~~ [submiters >>>] ~~~ --><tr>
<td align="center" class="color2">
<input type="button" class="buttons" value="<#msg_save#>" onclick="document.location = 'coder.php?do=commit&page=<#pageid#>';">
<input type="button" class="button" value="<#msg_cancel#>" onclick="document.location = 'coder.php?do=discard&page=<#pageid#>';">
</table></td>
</tr>
</tr>

<script>
function conf(str)
{
var truthBeTold = window.confirm("<#msg_flds_del_confirm#>"); 
if (truthBeTold) self.location=str;
}
function clearall()
{
for (var i=0;i<document.form1.elements.length;i++)
{

 if (document.form1.elements[i].id == '1qw23g84y5jbg843y')
 {
  document.form1.elements[i].checked = false;
 }
}
}

 function CheckAll(frm, mark)
 {
  	for (i = 0; i < frm.elements.length; i++)
    {
      if (frm.elements[i].id == '1qw23g84y5jbg843y') { frm.elements[i].checked = mark; }
    }
 }
</script>

</form>
