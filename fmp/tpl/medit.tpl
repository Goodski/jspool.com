</form>
<form name=form2 action="coder.php?do=update&page=<#pageid#>&field=<#field#>&id=<#id#>" method=post>
<table width="80%" border="0" cellpadding="0" cellspacing="0" class="data" align="center">
<tr>
 <td width="20%"><b><#msg_title_name#>:</b></td>
 <td align="left"><input type="text" name="title" size="33" value="<#ftitle#>">
 <input type="hidden" name="field_name" size="33" maxlength="50" value="<#fname#>">
 </td>
</tr>

<#size#>
<#rfield#>
</table>
<br><BR>
<table width="80%" cellpadding="0" cellspacing="0" class="data" align="center">
<THEAD>
<th align="center" id="firsth"><#msg_number#></th>
<#default#>
 <th><a id="notselected"><#msg_caption#></a></th>
 <th><a id="notselected"><#msg_value#></a></th>
 <th width="9%"></th>
</THEAD>
<!-- BEGIN row -->
<tr<#class#>>
<td class="f" align="center"><#num#></td>
 <#def#>
  <td align="center"><input type="text" size="30" name="caparray[]" id="c<#num#>" onFocus="setVal(this);" onBlur="autofill(this);" value="<#caption#>" tabindex="<#tabindex#>"></td>
 <td align="center"><input type="text" size="30" name="valarray[]" id="v<#num#>" value="<#value#>"></td>
 <td align="center"><a href="medit.php?do=delete&id=<#id#>&option=<#num#>"><img src="images/delete.png" border="0" alt="<#msg_delete#>"></a> <#isup#> <#isdown#></td>
</tr>
<!-- END row -->
</table>
<img src="images/1x1.gif" width="1" height="3"><br><br>
<center><input type="button" class="buttons" value="<#msg_add_new_opt#>" onclick="document.location = 'medit.php?do=add&id=<#id#>&new=<#new#>'"></center><br>

<input type="hidden" id="unchng" value="">
<script language="JavaScript">
 function setVal(obj)
 {
  var src;
  var unchng;
  
  src =  document.getElementById('v'+obj.id.substring(1,obj.id.lenght)); 
  unchng = document.getElementById('unchng');
  if (obj.value==src.value)
  {
   unchng.value = 0;
  }
  else
  {
   unchng.value = 1;
  }
 }
 
 function autofill(obj)
 {
  var src;
  var num;
  var unchng;
  num = obj.id.substring(1,obj.id.lenght);
  
  unchng = document.getElementById('unchng')
  src =  document.getElementById('v'+num);
  
  if (unchng.value == 0)
  {
  src.value = obj.value;
  }
 }
 
 function CheckAll()
 {
  var are_empty = false;
  
  for (var i=0; i<document.form2.length; i++)
  {
   if ((document.form2.elements[i].value == '')&&((document.form2.elements[i].name=='caparray[]')||(document.form2.elements[i].name=='valarray[]')))
   {
    are_empty = true;
   }
  }
  
  if (are_empty)
  {
    return confirm('<#msg_emflds_note#>');
  }
  else
  {
    return true;
  }
 }
</script>

<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="100%">

<table border="0" cellspacing="0" cellpadding="0" width="0%">
<tr><td align="center">