<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_multi_field_adding#> "<#pagename#>"</span></td>
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


</form>
<form name=form2 onsubmit="return checkform()"  action="drawm.php?page=<#pageid#>&field=<#field#>&pos=<#pos#>" method=post>
<table border="0" width="100%" height="39" background="">
  <tr>
    <td width="31%" height="33" valign="middle" background="">
	<p align="right"><#plen#> <b><#msg_title_name#> *&nbsp;&nbsp;&nbsp;</b></td>
    <td width="69%" height="33" valign="middle" background=""><input type="text" name="title" size="33" onChange="fill_out(document.form2.sel)" value=""></td>
  </tr>
  <tr>
    <td width="31%" height="33" valign="middle" background=""><p align="right"><b>Size</b>&nbsp;&nbsp;&nbsp;</td>
    <td width="69%" height="33" valign="middle" background="">
	<select name="size">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	</select></td>
  </tr>


  <tr>
    <td width="31%" height="33" valign="middle" background=""><p align="right"><b><#msg_opts_num#>:</b>&nbsp;&nbsp;&nbsp;</td>
    <td width="69%" height="33" valign="middle" background=""><input type="text" name="field_num" size="7" maxlength="50" value="" onChange="fn_tran(document.form2.sel)"></td>
  </tr>

  
  <tr>
    <td width="31%" height="33" valign="top" background="">
	<p align="right"><font face="Verdana" size="2"><b><#msg_advance#></b>&nbsp;&nbsp; </td>
    <td width="69%" height="33" valign="middle" background="">
	<input type="checkbox" value="1"  name="req"><#msg_fld_req#></td>
  </tr>

  </table>
<input type="hidden" name="field_name" size="33" maxlength="50" value="" onChange="fn_tran(document.form2.sel)">
<select name="sel" style="visibility: hidden;">
<option value="10245y" selected><#used#></option>
<#usedf#>
</select>


<script language=javascript>
var radio_data ="";
var field_name_string ="1::erer::";
var nothing ="";
function IsEmptyField(TextObj){return IsEmptyStr(TextObj.value)} 
function IsEmptyStr(Str){var retval = true;for (var i=0; i < Str.length; ++i){	var c = Str.charAt(i);if (c != ' ' && c != '\t') retval = false;}	return retval;
}

function checkform() {
	if (IsEmptyField(document.form2.title)){alert ("<#msg_title_blank#>");document.form2.title.select();document.form2.title.focus();return false;}   
	if (IsEmptyField(document.form2.field_name)){alert ("Your 'Field Name' cannot be left blank. Please check again");document.form2.field_name.select();document.form2.field_name.focus();return false;}   
	//if (radio_data == 3 && IsEmptyField(document.form2.adv_error) || document.form2.adv_error.value == "???"){alert ("Please enter the error message");document.form2.adv_error.value="???";document.form2.adv_error.select();document.form2.adv_error.focus();return false;}
	//if (IsEmptyField(document.form2.list)){document.form2.field_value.select();document.form2.field_value.focus();return false;}
	var field_name_string_array = field_name_string.split("::");
	for (var loop=0; loop < field_name_string_array.length; loop++){
		if (field_name_string_array[loop] == document.form2.field_name.value) {
			nothing = 1;
		}
	}
	if (nothing == 1) {
		alert("This Field Name '" + document.form2.field_name.value + "' was used");
		document.form2.field_name.select();
		document.form2.field_name.focus();
		nothing = 0;
		return false;	
	}
	else{
		return true;
	}

	return true;
}

function fill_out(selObj) {
get_data = document.form2.title.value;
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

document.form2.field_name.value = get_data+sufix;
var used_name = false;
for( var i = 0; i < selObj.options.length; i++ )
        {
                if( selObj.options( i ).value==document.form2.field_name.value)
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

function fn_tran(selObj) {
get_data = document.form2.field_name.value;
while (get_data.indexOf(" ")>-1) {
get_data = "" + (get_data.substring(0, get_data.indexOf(" ")) + "_" + get_data.substring((get_data.indexOf(" ") + 1), get_data.length));
}

document.form2.field_name.value = get_data;
for( var i = 0; i < selObj.options.length; i++ )
        {
		 // alert("This name("+selObj.options( i ).value+") is exist")
                if( selObj.options( i ).value==document.form2.field_name.value)
				{
				
				       alert("This name("+document.form2.field_name.value+") is exist")
						document.form2.field_name.value=''
                       
				}
        }
}
</script>

