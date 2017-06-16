<FORM action="<#delaction#>" method="POST" name="delfrm">
<tr>
<td class="color6">

<table width="99%" border="0" align="center" cellpadding="0" cellspacing="6">
<tr>
<td colspan="2"><img src="images/1x1.gif"></td>
</tr>
<tr>
<td height="20" colspan="2">
  <TABLE border="0" cellpadding="0" cellspacing="5"><tr><td>
	<TABLE border="0" cellpadding="5" cellspacing="2" class="color10"><tr>
	<td align="center">
	<span class="slink"><#msg_sel_action#>: </span></td>
	<td align="center">
	<span><a href="#" class="slink" title="<#msg_Delete#>" onClick="return DelClick();"><img src="images/delete.png" alt="<#msg_Delete#>" width="16" height="16" align="top" border="0"> <#msg_Delete#></a></td>
	<td align="center">
	<a href="#" class="slink" title="<#msg_comment#>" onClick="return CommClick(document.delfrm);"><img src="images/comment_add.png" alt="<#msg_comment#>" width="16" height="16" align="top" border="0"> <#msg_comment#></a></span>
	</span>
	</td></tr>
	</TABLE></td>
	<td><TABLE border="0" cellpadding="5" cellspacing="2" class="color10">
	<td align="center">
	<span class="slink">Action on data: </span></td>
	<td align="center">
	<span><a href="export.php?form=<#E_FORM#>&id=<#E_ID#>&order_by=<#E_ORDER#>&desc=<#E_DESC#>&search=<#E_SEARCH#>&s_key=<#E_SKEY#>&wholeword=<#E_WHOLE#>" class="slink" title="<#msg_csv_export#>"><img src="images/page_white_excel.png" alt="<#msg_csv_export#>" width="16" height="16" align="top" border="0"> <#msg_csv_export#></a></span></td>
	<td align="center">
	<span><a href="db.php?do=edit&form=<#E_FORM#>&db=<#E_ID#>" class="slink" title="Log <#msg_preferences#>"><img src="images/database_edit.png" alt="Log <#msg_preferences#>" width="16" height="16" align="top" border="0" align="top"> Log <#msg_preferences#></a></span></td>
	</tr>
	</TABLE></td></tr>
  </TABLE>
</td>
</tr>
<tr>
<td colspan="2">
<#s_result#>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="data">
<thead>
<tr>
<#thead#>
</tr>
</thead>
<tbody>
<#trows#>
</tbody>
</table>

</td>
</tr>
<tr>
<td><img src="images/icon-nav-prev.gif" width="5" height="5" alt="&lt;&lt;"> <a href="<#prev_path#>" class="slink"><#msg_prev#></a> | <a href="<#next_path#>" class="slink"><#msg_next#></a> <img src="images/icon-nav-next.gif" alt="&gt;&gt;" width="5" height="5"></td>
<td align="right" class="paging"> <#prev5#> <#msg_pages#>: <#plabel#>  &#8230;  <#msg_of#> <#pages#> <#next5#></td>
</tr>
</FORM>
</table></td>
</tr>

<script>
 function DelClick()
 {
   if (confirm('<#msg_rec_group_del#>'))
   {
    document.delfrm.submit();
    return true;
   }
   else
   {
    return false;
   }
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
 
 function AddComment(id, log, comment)
 {
 	var b, c;
 	b = (c = prompt("Enter new comments, please", comment));
 	
	if ((c!=comment)&&(b != null))
	{
		document.location = 'logedit.php?do=comment&id='+id+'&log='+log+'&comment='+escape(c)+'&ref='+escape(document.location);	
	}
 }
 
 function CommClick(frm)
 {
 	var b, c, i, n;
 	b = (c = prompt("Enter new comments, please", ""));
 	
	n=0;
	for (i = 0; i <= frm.elements.length; i++)
    {
     try
     {
       if (frm.elements[i].checked) {n++};
     }
     catch(er)
     {
     }
    }
	
	if ((b != null)&&(n != 0))
	{
		document.delfrm.action = 'logedit.php?do=group&log=<#id#>&comment='+escape(c)+'&ref='+escape(document.location);
		document.delfrm.submit();
		return true;
	}
 }
</script>
