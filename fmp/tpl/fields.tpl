</form>
<table width="80%" border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
 <td width="5%"><b><#msg_title_name#>:</b></td>
 <td align="left"><#ftitle#></td>
</tr>
<#size#>
</table>

<form name=form2 action="coder.php?do=add&page=<#pageid#>&field=<#field#>&pos=<#pos#>" onsubmit="return CheckAll();" method=post>

<table width="80%" cellpadding="0" cellspacing="0" class="data" align="center">
<THEAD>
<th id="firsth"><a id="notselected"><#msg_number#></a></th>
<#default#>
 <th><a id="notselected"><#msg_caption#></a></th>
 <th><a id="notselected"><#msg_value#></a></th>
</THEAD>
<tbody>
<!-- BEGIN row -->

<tr<#class#>>
<td class="f"><#num#></td>
<#def#>
<td><input type="text" size="30" id="c<#num#>" onFocus="setVal(this);" onBlur="autofill(this);" name="caparray[]" value="<#capval#>" tabindex="<#tabindex#>"></td>
<td><input type="text" size="30" id="v<#num#>" name="valarray[]" value="<#valval#>"></td>
</tr>

<!-- END row -->
</tbody>
</table>
<img src="images/1x1.gif" width="1" height="3"><br>
<CENTER><input type="button" class="buttons" value="<#msg_add_new_opt#>" onClick="AddOpt();"></CENTER>
<br>

<input type="hidden" name="title" value="<#ftitle#>">
<input type="hidden" name="field_name" value="<#fname#>">
<input type="hidden" name="req" value="<#req#>">
<input type="hidden" name="size" value="<#sizeval#>">
<input type="hidden" id="unchng" value="0">
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
 
 function AddOpt()
 {
  document.form2.action="drawm.php?page=<#pageid#>&field=<#field#>&pos=<#pos#>&title=<#ftitle#>&field_name=<#fname#>&req=<#req#>&field_num=<#field_num#>&size=<#sizeval#>";
  document.form2.submit();
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


