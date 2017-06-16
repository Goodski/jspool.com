<tr>
<td class="color2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
</table>
<!-- ~~~ [table for fields set #3 >>>] ~~~ -->
<table width="70%" border="0" align="left" cellpadding="0" cellspacing="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel">Email template</span></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%">
<!-- ~~~ (fields set #3) ~~~ -->
<table border="0" cellspacing="5" cellpadding="0">
<form action="log.php?do=<#do#>&form=<#formid#>" method="POST">
<#log#>
<tr>
<td align="right" nowrap><strong>Template name</strong> <span class="tlabel">*</span></td>
<td>
<input type="Text" name="name" id="name" size="35" class="fields" onFocus="source_id = 'name'" value="<#name#>">
</td>
</tr>
<tr>
<td align="right" nowrap><strong>Log file</strong> <span class="tlabel">*</span></td>
<td>
<input type="Text" name="file" id="file" class="fields" size="35" value="<#file#>">
</td>
</tr>




<tr>
<td align="right" nowrap valign="top"><strong>Body</strong></td>
<td>
<textarea name="body" id="body" rows="15" cols="50" wrap="virtual" onFocus="source_id = 'body'" onselect="storeCaret(this)" onclick="storeCaret(this)" onkeyup="storeCaret(this)"><#body#></textarea>	
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

<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel">Form</span></td>
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

<!-- BEGIN row -->
<center><a href="#" class="nlink" onclick="javascript:  window.open('wideform.php?page=<#pageid#>','_blank','height=400,width=600,toolbar=no,status=no,scrollbars=yes,resizable=yes,menubar=no,location=no,direction=no')"><#pagename#></a></center>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="data">
<thead>
<tr>
<th id="firsth" width="50%"><a href="#">Field name</a></th>
<th><a href="#">Field type</a></th>
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
</table>
</td>
</tr>

<td class="color5"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
<tr>
<td align="center" class="color2" ><input name="Submit" type="submit" class="buttons" value="Submit"> <input name="Reset" type="reset" class="button" value="Reset"></td>
</tr>
</table></td>
</tr>
</tr>
</form>


<script language="JavaScript">
var source_id;
function InsertName(field, type)
{
var src;
var doit = true;

if ((src = document.getElementById(source_id))&&(source_id != 'name'))
{
 if ((source_id=='to')&&(type==3))      { doit = false; }
 if ((source_id=='cc')&&(type==3))      { doit = false; }
 if ((source_id=='bcc')&&(type==3))     { doit = false; }
 if ((source_id=='from')&&(type==3))    { doit = false; }
 if ((source_id=='subject')&&(type==3)) { doit = false; }
 if ((source_id=='attach')&&(type==3))  { doit = false; }
 
 if ((source_id=='to')&&(type==2))      { doit = false; }
 if ((source_id=='cc')&&(type==2))      { doit = false; }
 if ((source_id=='bcc')&&(type==2))     { doit = false; }
 if ((source_id=='from')&&(type==2))    { doit = false; }
 if ((source_id=='subject')&&(type==2)) { doit = false; }
 
 
 if (doit)
 {
 insertText(src,'[' + field + ']');
 }
 else
 {
  alert("You cannot insert '"+field+"' to this area");
 }
}
}

function storeCaret(element){
   if (document.selection && document.selection.createRange){
      element.caretPos=document.selection.createRange().duplicate();
   }else if(element && element.selectionStart){
      element.caretPosNN=element.selectionStart;
   }
}
function insertText(element,text){
   element.focus();
   if (element && element.caretPos){
      element.caretPos.text=text; 
   }else if (element && element.caretPosNN+1 && element.selectionEnd+1){
      element.value=element.value.substring(0,element.selectionStart)+text+element.value.substring(element.selectionEnd,element.value.length); 
      element.setSelectionRange(element.caretPosNN+text.length,element.caretPosNN+text.length);
   }else if (element){
      element.value+=text;
   }
} 
</script>