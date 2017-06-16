<tr>
<td class="color2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
</table>
<!-- ~~~ [table for fields set #3 >>>] ~~~ -->
<table width="70%" border="0" align="left" cellpadding="0" cellspacing="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_email_tpl#></span></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%">
<!-- ~~~ (fields set #3) ~~~ -->
<table border="0" cellspacing="5" cellpadding="0">
<form name="frm" action="mail.php?do=<#do#>&form=<#formid#>" method="POST">
<#email#>

<tr>
<td align="right" nowrap><strong><#msg_mail_preset#></strong></td>
<td>
<select name="preset" class="selects" onchange="SetPreset(this.value);">
	<option value="0"<#preset0#>><#msg_none#></option>
	<option value="1"<#preset1#>><#msg_notification#></option>
	<option value="2"<#preset2#>><#msg_autoresponder#></option>
</select>
</td>
</tr>

<tr>
<td align="right" nowrap><strong><#msg_tpl_name#></strong> <span class="tlabel">*</span></td>
<td>
<input type="Text" name="name" id="name" size="35" class="widefields" onFocus="source_id = 'name'" value="<#name#>">
</td>
</tr>
<tr>
<td width="1"><img src="images/1x1.gif" width="1" height="8"></td>
<td width="100%" align="center">
</tr>
<tr>
<td align="right" nowrap><strong><#msg_from#></strong> <span class="tlabel">*</span></td></td>
<td>
<input type="Text" name="from" id="from" size="80" class="widefields" size="35" onFocus="source_id = 'from'" value="<#from#>" onselect="storeCaret(this)" onclick="storeCaret(this)" onkeyup="storeCaret(this)"></td>
</tr>
<tr>
<td align="right" nowrap><strong><#msg_to#></strong> <span class="tlabel">*</span></td>
<td>
<input type="Text" name="to" id="to" size="80" class="widefields" size="35" onFocus="source_id = 'to'" value="<#to#>" onselect="storeCaret(this)" onclick="storeCaret(this)" onkeyup="storeCaret(this)"></td>
</tr>
<tr>
<td align="right" nowrap><strong><#msg_cc#></strong></td>
<td>
<input type="Text" name="cc" id="cc" size="80" class="widefields"  size="35" onFocus="source_id = 'cc'" value="<#cc#>" onselect="storeCaret(this)" onclick="storeCaret(this)" onkeyup="storeCaret(this)">
</td>
</tr>
<tr>
<td align="right" nowrap><strong><#msg_bcc#></strong></td>
<td>
<input type="Text" name="bcc" id="bcc" size="80" class="widefields" size="35" onFocus="source_id = 'bcc'" value="<#bcc#>" onselect="storeCaret(this)" onclick="storeCaret(this)" onkeyup="storeCaret(this)"></td>
</tr>

<tr>
<td align="right" nowrap><strong><#msg_subject#></strong></td>
<td>
<input type="Text" name="subject" id="subject" size="80" class="widefields" onFocus="source_id = 'subject'" value="<#subject#>" onselect="storeCaret(this)" onclick="storeCaret(this)" onkeyup="storeCaret(this)"></td>
</tr>
<tr>
<td align="right" nowrap><strong><#msg_attachments#></strong></td>
<td>
<input type="Text" name="attach" id="attach" size="80" class="widefields" size="35" onFocus="source_id = 'attach'" value="<#attach#>" onselect="storeCaret(this)" onclick="storeCaret(this)" onkeyup="storeCaret(this)"></td>
</tr>

<tr>
<td align="right" nowrap><strong><#msg_format#></strong></td>
<td>
<input type="radio" name="format" value="0"<#f1#> id="format1"><label for="format1"><#msg_plain_txt#></label>
<input type="radio" name="format" value="1"<#f2#> id="format2"><label for="format2"><#msg_html#></label>
</td>
</tr>

<tr>
<td align="right" nowrap valign="top"><strong><#msg_body#></strong></td>
<td>
<textarea onselect="storeCaret(this)" onclick="storeCaret(this)" onkeyup="storeCaret(this)" name="body" id="body" rows="30" cols="100" wrap="virtual" onFocus="source_id = 'body'"><#body#></textarea>	</td>
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
<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_form#></span></td>
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
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="data">
<thead>
<tr>
<th id="firsth" width="50%"><a id="notselected"><#msg_field_name#></a></th>
<th><a id="notselected"><#msg_field_type#></a></th>
</tr>
</thead>
<tbody>
<#fields#>
</tbody>
</table>
<br>
<!-- END row -->

<br>
<center>Real time data</center>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="data">
<thead>
<tr>
<th id="firsth" width="50%"><a id="notselected">Field name</a></th>
<th><a id="notselected">Description</a></th>
</tr>
</thead>
<tbody>

<tr class="dataodd">
<td><a class="nlink2"  onclick = "InsertName('%REMOTE_ADDR',0);">Remote Address</a></td>
<td>User's IP address</a></td>
</tr>
<tr bgcolor="#ffffff">
<td><a class="nlink2"  onclick = "InsertName('%HTTP_REFERER',0);">HTTP Referrer</a></td>
<td>Referred page</a></td>
</tr>

<tr class="dataodd">
<td><a class="nlink2"  onclick = "InsertName('%DATE',0);">Date</a></td>
<td>Date of submittion</a></td>
</tr>

<tr bgcolor="#ffffff">
<td><a class="nlink2"  onclick = "InsertName('%TIME',0);">Time</a></td>
<td>Time of submittion</a></td>
</tr>

</tbody>
</table>


</td>
</tr>

</table>
</td>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
<tr>
<td colspan="3" class="color5" height="1"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
</table><!-- ~~~ [<<< table for fields set #4] ~~~ -->
</td>
</tr><!-- ~~~ [<<< forms 1] ~~~ -->
<!-- ~~~ [stupid line >>>] ~~~ --><tr>
<td class="color5"><img src="images/1x1.gif" width="1" height="1"></td>
</tr><!-- ~~~ [<<< stupid line] ~~~ -->
<!-- ~~~ [submiters >>>] ~~~ --><tr>
<td align="center" class="color2"><input name="Submit" type="submit" class="buttons" value="<#msg_save#>"> <input name="<#msg_cancel#>" type="button" class="buttons" value="<#msg_cancel#>" onclick="document.location = 'formedit.php?form=<#formid#>';"> <input name="Reset" type="reset" class="button" value="<#msg_reset#>"></td>
</tr><!-- ~~~ [<<< submiters] ~~~ -->
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
 if ((source_id=='attach')&&(type!=2))  { doit = false; }
 
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
  alert("<#msg_cannot_insert#>");
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

function SetPreset(num)
{
	if (num == 1)
	{
		document.frm.to.value = "<#user_email#>";	
		document.getElementById("name").value = "<#msg_notification#>";
		document.frm.subject.value = "\"<#form_name#>\" was submitted on [%DATE_GMT]";
		document.frm.attach.value = "<#attaches#>";
		document.frm.body.value = "<!-- BEGIN AUTOGENERATING DATA -->\n<#preset_fields#><!-- END AUTOGENERATING DATA -->";
	}
	
	if (num == 2)
	{
		document.getElementById("name").value = "<#msg_autoresponder#>";
		document.frm.subject.value = "Thank you";
		document.frm.attach.value = "<#attaches#>";
		document.frm.body.value = "You filled in next information:\n<!-- BEGIN AUTOGENERATING DATA -->\n<#preset_fields#><!-- END AUTOGENERATING DATA -->\nThank you!";	
	}
}
</script>