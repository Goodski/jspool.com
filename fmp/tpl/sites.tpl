<tr>
<td class="color6">
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="6">
<tr>
<td colspan="2"><img src="images/1x1.gif"></td>
</tr>
<form name="siteform" action="sites.php?do=delgroup" method="post">
<tr>
<td height="20" colspan="2">
  <TABLE border="0" cellpadding="0" cellspacing="5"><tr><td>	
	<TABLE border="0" cellpadding="5" cellspacing="2" class="color10"><tr>
	<td align="center">
	<span class="slink"><#msg_sel_action#>: </span></td>
	<td align="center">
	<span><a href="#" class="slink" title="<#msg_Delete#>" onClick="return DelClick();"><img src="images/delete.png" alt="<#msg_Delete#>" width="16" height="16" align="top" border="0"> <#msg_Delete#></a></span></td>
	</tr>
	</TABLE></td>
	<td><TABLE border="0" cellpadding="5" cellspacing="2" class="color10"><tr>
	<td align="center">
	<span class="slink">Action on sites: </span></td>
	<td align="center">
	<span><a href="#" class="slink" title="<#msg_add_new_site#>" onclick="document.location = 'sites.php?addnew=1'"><img src="images/server_add.png" alt="<#msg_add_new_site#>" width="16" height="16" align="top" border="0"> <#msg_add_new_site#></a></span></td>
	</tr>
	</TABLE></td></tr>
  </TABLE>
</td>
</tr>
<tr>
<td colspan="2">


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="data">
<thead>
<tr>
<th width="2%" id="firsth"><input type="checkbox" name="checkbox" value="checkbox" onclick="CheckAll(document.siteform, this.checked);">
</th>
<th><a<#sel0#> href="sites.php?order_by=sites&direct=<#direct0#>"><#msg_sites#></a></th>
<th width="10%"><a<#sel1#> href="sites.php?order_by=forms&direct=<#direct1#>">Forms</a></th>
<th width="6%">&nbsp;</th>
</tr>
</thead>
<tbody>

<tr class="iselected">
<td class="f" height="23">&nbsp;</td>
<td><strong><a href="siteform.php?siteid=0">Form Maker Pro server</a></strong></td>
<td><#serv_form_num#></td>
<td nowrap>
<a href="forms.php#an0" class="slink" title="<#msg_edit#>"><img src="images/page_edit.png" alt="<#msg_edit#>" width="16" height="16" hspace="1" border="0" align="top"><#msg_edit#></a></td>
</tr>


<!-- BEGIN row -->
<tr<#class#>>
<td class="f"><input type="checkbox" name="chk[]" value="<#sitenum#>"></td>
<td><strong><a href="siteform.php?siteid=<#sitenum#>"><#sitename#></a></strong></td>
<td><#form_num#></td>
<td nowrap>
<a href="forms.php#an<#sitenum#>" class="slink" title="<#msg_edit#>"><img src="images/page_edit.png" alt="<#msg_edit#>" width="16" height="16" hspace="1" border="0" align="top"><#msg_edit#>&nbsp;</a>
<a href="sites.php?edit=<#sitenum#>" class="slink" title="<#msg_preferences#>"><img src="images/cog.png" alt="<#msg_preferences#>" width="16" height="16" hspace="1" border="0" align="top"><#msg_preferences#>&nbsp;</a> 
<a href="#" onclick="javascript: conf('sites.php?delete=<#sitenum#>');" class="slink" title="<#msg_Delete#>"><img src="images/delete.png" alt="<#msg_Delete#>" width="16" height="16" hspace="1" border="0" align="top"><#msg_Delete#>&nbsp;</a></td>
</tr>
<!-- END row -->



</tbody>
</table>
</td>






</tr>
</form>
<tr>
<td colspan="2"><img src="images/1x1.gif"></td>
</tr>
</table></td>
</tr>





<script>
function conf(str)
{
var truthBeTold = window.confirm("<#msg_site_del#>"); 
<#del_p#>
if (truthBeTold) self.location=str;
}

 function CheckAll(frm, mark)
 {
  	for (i = 0; i <= frm.elements.length; i++)
    {
     try
     {
       frm.elements[i].checked = mark;
     }
     catch(er)
     {
     }
    }
 }
 
 function DelClick()
 {
   if (confirm('<#msg_site_group_del#>'))
   {
   	<#del_p#>
    document.siteform.submit();
    return true;
   }
   else
   {
    return false;
   }
 }
</script>
