<tr>
<td class="color2">

<table width="11%" border="0" align="left" cellpadding="0" cellspacing="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_fields#></span></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%">

<table border="0" cellspacing="5" cellpadding="0">
<form action="coder.php?page=<#pageid#>&do=delete" name="form1" method="post">

<tr>
<td><input type="button" name="textfield" value="<#msg_captcha#>" class="buttonsf" onclick="document.location = 'draw.php?page=<#pageid#>&field=10'"></td>
</tr>

<tr>
<td><input type="button" name="textfield" value="<#msg_textfield#>" class="buttonsf" onclick="document.location = 'draw.php?page=<#pageid#>&field=0'"></td>
</tr>

<tr>
<td><input type="button" name="select" value="<#msg_select#>" class="buttonsf" onclick="document.location = 'draw.php?page=<#pageid#>&field=1'"></td>
</tr>

<tr>
<td><input type="button" name="browse" value="<#msg_browse#>" class="buttonsf" onclick="document.location = 'draw.php?page=<#pageid#>&field=2'"></td>
</tr>

<tr>
<td><input type="button" name="textarea" value="<#msg_textarea#>" class="buttonsf" onclick="document.location = 'draw.php?page=<#pageid#>&field=3'"></td>
</tr>

<tr>
<td><input type="button" name="multiple" value="<#msg_multilist#>" class="buttonsf" onclick="document.location = 'draw.php?page=<#pageid#>&field=4'"></td>
</tr>

<tr>
<td><input type="button" name="checkbox" value="<#msg_checkbox#>" class="buttonsf" onclick="document.location = 'draw.php?page=<#pageid#>&field=5'"></td>
</tr>

<tr>
<td><input type="button" name="radio" value="<#msg_radio#>" class="buttonsf" onclick="document.location = 'draw.php?page=<#pageid#>&field=6'"></td>
</tr>

<tr>
<td><input type="button" name="label" value="<#msg_label#>" class="buttonsf" onclick="document.location = 'draw.php?page=<#pageid#>&field=7'"></td>
</tr>

<tr>
<td><input type="button" name="label" value="<#msg_calc#>" class="buttonsf" onclick="document.location = 'draw.php?page=<#pageid#>&field=9'"></td>
</tr>

</table>
</td>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
<tr>
<td colspan="3" class="color5" height="1"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
</table>

<TABLE border="0" width="85%" cellpadding="0" cellspacing="0">
<tr><td valign="top" width="55%"> 
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
<#gracc#>
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

<TABLE border="0" width="100%" cellpadding="0" cellspacing="0">
<tr><td valign="top" width="55%"> 
<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel">Submit button caption</td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%">
<table border="0" cellspacing="2" cellpadding="0" width="100%">
<tr>
<td>
&nbsp;&nbsp;&nbsp;Submit button:&nbsp;<INPUT type="text" name="subtext" value="<#subtext#>" class="fields">
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
</TABLE>

</td>
<td>
<img src="images/1x1.gif" width="1" height="1">
</td>

<td valign="top">

<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel">Calculations</span></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%" align="center">
<br>				
				<table width="90%" border="0" cellspacing="0" cellpadding="0" class="data">
				<thead>
				<tr>
				<th><a id="selected<#calc_direct#>" href="coder.php?page=<#pageid#>&calc_dir=<#calc_dirhref#>">Title</a></th>
				<th width="6%">&nbsp;</th>
				</tr>
				</thead>
				<tbody>
				<!-- BEGIN calc_row -->
					<tr<#class#>>
						<td><strong><a href="draw.php?do=edit&id=<#calc_id#>&field=8&page=<#pageid#>"><#calc_title#></a></strong></td>
						<td nowrap><a href="draw.php?do=edit&id=<#calc_id#>&field=8&page=<#pageid#>" class="slink"><img src="images/calculator_edit.png" alt="<#msg_edit#>" width="16" height="16" hspace="1" border="0" align="top"><#msg_edit#></a> <a href="coder.php?do=delcalc&id=<#calc_id#>&page=<#pageid#>" class="slink" title="delete"><img src="images/delete.png" alt="<#msg_Delete#>" width="16" height="16" hspace="1" border="0" align="top"><#msg_Delete#></a></td>
					</tr>
				<!-- END calc_row -->
				</tbody>
				</table>
<br>
<INPUT type="button" class="buttons" value="Add calculation" onclick="document.location = 'draw.php?page=<#pageid#>&field=8';">
<br><br>
</td>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
<tr>
<td colspan="3" class="color5" height="1"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
</table>

</td></tr>
</TABLE>
</td>
</tr><tr>
<td class="color5"><img src="images/1x1.gif" width="1" height="1"></td>
</tr><tr>
<td align="center" class="color2">
<input type="button" class="buttons" value="<#msg_save#>" onclick="document.location = 'coder.php?do=commit&page=<#pageid#>&subtext='+escape(document.form1.subtext.value);">
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
