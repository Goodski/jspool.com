<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_textar_field_adding#> "<#pagename#>"</span></td>
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


<table border="0" width="100%" height="39" background="">
  <tr>
    <td width="31%" height="33" valign="middle" background="">
	<p align="right"><#plen#> <b><#msg_title_name#> *&nbsp;&nbsp;&nbsp;</b></td>
    <td width="69%" height="33" valign="middle" background=""><input type="text" name="title" size="33" onChange="fill_out(document.form1.sel)" value="<#ftitle#>"></td>
  </tr>
  </table>
  <table border="0" width="100%" height="39" background="">
<tr>
    <td width="31%" height="33" valign="top" background="">
	<p align="right"><font face="Verdana" size="2"><b><#msg_advance#></b>&nbsp;&nbsp; </td>
    <td width="69%" height="33" valign="middle" background="">
	<input type="checkbox" value="1"  name="req"<#freq#>><font face="Verdana" size="2"><#msg_fld_req#></td>
  </tr>
<tr><td>&nbsp;</td> 
<td>
<input type="Radio" name="vfield" value="0"<#fval0#>> <#msg_val_none#><br>
<input type="Radio" name="vfield" value="4"<#fval4#>> <#msg_val_words#><br>
<input type="Radio" name="vfield" value="5"<#fval5#>> <#msg_val_srem#><br>
<input type="Radio" name="vfield" value="6"<#fval6#>> <#msg_val_nlrem#><br>
</td>
</tr>
  
  </table>
<input type="hidden" name="field_name" size="33" maxlength="50" value="<#fname#>" onChange="fn_tran(document.form1.sel)">
<select name="sel" style="visibility: hidden;">
<option value="10245y" selected><#used#></option>
<#usedf#>
</select> 

<script language=javascript>

var radio_data ="";
var field_name_string ="dfdfdf::";
var nothing ="";

<!--

<!--
function fill_out(selObj) {
get_data = document.form1.title.value;
while (get_data.indexOf(" ")>-1) {
get_data = "" + (get_data.substring(0, get_data.indexOf(" ")) + "_" + get_data.substring((get_data.indexOf(" ") + 1), 50));
}

while (get_data.indexOf("\"")>-1) {
get_data = "" + (get_data.substring(0, get_data.indexOf("\"")) + "_" + get_data.substring((get_data.indexOf("\"") + 1), 50));
}

while (get_data.indexOf("'")>-1) {
get_data = "" + (get_data.substring(0, get_data.indexOf("'")) + "_" + get_data.substring((get_data.indexOf("'") + 1), 50));
}

while (get_data.indexOf("$")>-1) {
get_data = "" + (get_data.substring(0, get_data.indexOf("$")) + "_" + get_data.substring((get_data.indexOf("$") + 1), 50));
}

while (get_data.indexOf("\.")>-1) {
get_data = "" + (get_data.substring(0, get_data.indexOf("\.")) + "_" + get_data.substring((get_data.indexOf("\.") + 1), 50));
}

while (get_data.indexOf("/")>-1) {
get_data = "" + (get_data.substring(0, get_data.indexOf("/")) + "_" + get_data.substring((get_data.indexOf("/") + 1), 50));
}

while (get_data.indexOf("#")>-1) {
get_data = "" + (get_data.substring(0, get_data.indexOf("#")) + "_" + get_data.substring((get_data.indexOf("#") + 1), 50));
}

var addnum = true;
var numfi = 0;

while(addnum)
{
if (numfi==0)
{ 
sufix='';
}
else
{
sufix = numfi;
}

document.form1.field_name.value = get_data+sufix;
var used_name = false;
for( var i = 0; i < selObj.options.length; i++ )
        {
                if( selObj.options( i ).value==document.form1.field_name.value)
				{
						used_name = true;
				}
        }
 if (used_name)
 {
 numfi++;
 }
 else
 {
  addnum = false;
 }
}
}
//-->

<!--
function fn_tran(selObj) {
get_data = document.form1.field_name.value;
while (get_data.indexOf(" ")>-1) {
get_data = "" + (get_data.substring(0, get_data.indexOf(" ")) + "_" + get_data.substring((get_data.indexOf(" ") + 1), get_data.length));
}
//document.form1.title.value = document.form1.field_name.value;
document.form1.field_name.value = get_data;

for( var i = 0; i < selObj.options.length; i++ )
        {
		 // alert("This name("+selObj.options( i ).value+") is exist")
                if( selObj.options( i ).value==document.form1.field_name.value)
				{
				
				       alert("This name("+document.form1.field_name.value+") is exist")
						document.form1.field_name.value=''
                       
				}
        }
}
//-->

<!--



//-->
function checkform() {
if (document.form1.title.value==''){alert ("<#msg_title_blank#>");document.form1.title.select();document.form1.title.focus();return false;}   
if (document.form1.field_name.value==''){alert ("Your 'Field Name' cannot be left blank. Please check again");document.form1.field_name.select();document.form1.field_name.focus();return false;}   
else {	return true;}
}

</script>
