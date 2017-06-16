<tr>
<td bgcolor="#FFFFFF">
<div id="pointer" style="position:relative; visibility:visible; left:0; top:0; width:100%; height:20px; z-index:1"><div id="fills" style="position:absolute; visibility:visible; left:0px; top:-1px; width:100%; height:1px; background-color:#FFFFFF; layer-background-color:#FFFFFF; z-index:1"></div><div id="title" style="position:absolute; visibility:visible; left:0px; top:0px; width:100%; z-index:2; vertical-align: bottom; line-height: 20px">
&nbsp;&nbsp;&nbsp;&nbsp;<a name="an0"></a><span class="bigtxt"><b><#msg_site#>: <#sitename#> </b></span>
</div></div>
</td>
</tr>

<tr>
<td class="color6">
<form name="site0" action="forms.php?do=groupdel" method="post">
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="6">
<tr>
<td><img src="images/1x1.gif"></td>
</tr>
<tr>
<td height="20">
<!--
<span class="slink"><#msg_sel_action#>: <span><a href="#" class="slink" title="<#msg_delete#>" onClick="DelClick(document.site0);"><img src="images/delete.png" alt="<#msg_delete#>" width="16" height="16" align="top" border="0"> <#msg_delete#></a> </span></span>
-->
  <TABLE border="0" cellpadding="0" cellspacing="5"><tr><td>
	<TABLE border="0" cellpadding="5" cellspacing="2" class="color10"><tr>
	<td align="center">
	<span class="slink"><#msg_sel_action#>: </span></td>
	<td align="center">
	<span><a href="#" class="slink" title="<#msg_Delete#>" onClick="DelClick(document.site0);"><img src="images/delete.png" alt="<#msg_Delete#>" width="16" height="16" align="top" border="0"> <#msg_Delete#></a> </span></td>
	</tr>
	</TABLE></td>
	<td><TABLE border="0" cellpadding="5" cellspacing="2" class="color10"><tr>
	<td align="center">
	<span class="slink">Action on site: </span></td>
	<td align="center">
	<span><a href="#" class="slink" title="<#msg_add_new_form#>" onclick="document.location = 'forms.php?do=addform&site=<#siteid#>'"><img src="images/application_form_add.png" alt="<#msg_add_new_form#>" width="16" height="16" align="top" border="0"> <#msg_add_new_form#></a></span></td>
	</tr>
	</TABLE><td></tr>
  </TABLE>
</td>
</tr>
<tr>
<td>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="data">
<thead>
<tr>
<th width="2%" id="firsth"><input type="checkbox" name="checkbox" value="checkbox" onclick="CheckAll(document.site0, this.checked);"></th>
<th width="2%">&nbsp;</th>
</th>
<th><a<#sel0#> href="siteform.php?siteid=<#siteid#>&order_by=names&direct=<#direct0#>"><#msg_forms#>&nbsp;&nbsp;&nbsp;</a></th>
<th width="6%"><a<#sel1#> href="siteform.php?siteid=<#siteid#>&order_by=pages&direct=<#direct1#>">Pages&nbsp;&nbsp;&nbsp;</a></th>
<th width="7%"><a<#sel4#> href="siteform.php?siteid=<#siteid#>&order_by=preview&direct=<#direct4#>">Preview&nbsp;&nbsp;&nbsp;</a></th>
<th width="11%"><a<#sel5#> href="siteform.php?siteid=<#siteid#>&order_by=thx&direct=<#direct5#>">Thanks&nbsp;&nbsp;&nbsp;</a></th>
<th width="6%"><a<#sel2#> href="siteform.php?siteid=<#siteid#>&order_by=emails&direct=<#direct2#>">Emails&nbsp;&nbsp;&nbsp;</a></th>
<th width="6%"><a<#sel3#> href="siteform.php?siteid=<#siteid#>&order_by=dbs&direct=<#direct3#>">Logs&nbsp;&nbsp;&nbsp;</a></th>
<th width="6%">&nbsp;</th>

</tr>
</thead>
<tbody>
<!-- BEGIN serv_row -->
<tr <#cell#>>
<td class="f"><input type="checkbox" name="chk[]" value="<#form_id#>"></td>
<td><#style_img#></td>
<td><strong><a href="formedit.php?form=<#form_id#>" title="<#msg_edit#>"><#form_name#></a></strong></td>

<td><#pages_num#></td>
<td><#is_preview#></td>
<td><#is_thx#></td>
<td><#emails_num#></td>
<td><#dbs_num#></td>

<td align=center nowrap>
<a href="formedit.php?form=<#form_id#>" class="slink" title="<#msg_edit#>"><img src="images/page_edit.png" alt="<#msg_edit#>" width="16" height="16" hspace="1" border="0" align="top"><#msg_edit#>&nbsp;</a>
<a href='forms.php?do=edit&form=<#form_id#>' class="slink"><img src="images/cog.png" alt="<#msg_preferences#>" width="16" height="16" hspace="1" border="0" align="top"><#msg_preferences#>&nbsp;</a>
<a href="#" onclick="conf('siteform.php?siteid=<#siteid#>&do=delete&form=<#form_id#>');" class="slink" title="<#msg_Delete#>"><img src="images/delete.png" alt="<#msg_Delete#>" width="16" height="16" hspace="1" border="0" align="top"><#msg_Delete#>&nbsp;</a>
</td></tr>
<!-- END serv_row -->
</tbody>
</table>
</td>
</tr>
</table>
</form>
</td>
</tr>


<script>
function conf(str)
{
var truthBeTold = window.confirm("<#msg_form_del#>"); 
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
 
 function DelClick(form)
 {
   if (confirm('<#msg_form_group_del#>'))
   {
    form.submit();
    return true;
   }
   else
   {
    return false;
   }
 }
</script>