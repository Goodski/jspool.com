<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_text_field_adding#> "<#pagename#>"</span></td>
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
	<p align="right"><b><#msg_title_name#> *&nbsp;&nbsp;&nbsp;</b></td>
    <td width="69%" height="33" valign="middle" background=""><input type="text" name="title" size="33" onChange="fill_out(document.form1.sel)" value="<#ftitle#>"></td>
  </tr>
  <tr>
    <td width="31%" height="33" valign="middle" background=""><p align="right"><#msg_preset#>&nbsp;&nbsp;&nbsp;</td>
    <td width="69%" height="33" valign="middle" background="">

    <select size="1" name="pre" onChange="preset(document.form1.sel)">
    <option value=""><#msg_select_one#></option>
    <option value="Calculation">Calculation Field</option>
    <option value="Your_Company_Name"><#msg_pre_comp_name#>:</option>
    <option value="First_Name"><#msg_pre_fname#>:</option>
    <option value="Last_Name"><#msg_pre_lname#>:</option>
	<option value="Email"><#msg_pre_email#>:</option>
    <option value="Address_1"><#msg_pre_addr1#>:</option>
    <option value="Address_2"><#msg_pre_addr2#>:</option>
    <option value="City"><#msg_pre_city#>:</option>
    <option value="State"><#msg_pre_state#>:</option>
    <option value="Zip_Code"><#msg_pre_zip#>:</option>
    <option value="Country"><#msg_pre_country#>:</option>
    <option value="Homepage"><#msg_pre_homepage#>:</option>
    <option value="Phone"><#msg_pre_phone#>:</option>
    <option value="Fax"><#msg_pre_fax#>:</option>
    </td>
  </tr>
  </table>
  <table border="0" width="100%" height="39" background="">
<tr>
    <td width="31%" height="33" valign="top" background="">
	<p align="right"><b><#msg_advance#></b>&nbsp;&nbsp; </font></td>
    <td width="69%" height="33" valign="middle" background="">
	<input type="checkbox" value="1"  name="req"<#freq#>><#msg_fld_req#></td>
  </tr>
<tr><td>&nbsp;</td> 
<td>
<input type="Radio" name="vfield" value="0"<#fval0#>> <#msg_val_none#><br>
<input type="Radio" name="vfield" value="1"<#fval1#>> <#msg_val_email#><br>
<input type="Radio" name="vfield" value="2"<#fval2#>> <#msg_val_dig#><br>
<input type="Radio" name="vfield" value="3"<#fval3#>> <#msg_val_curr#><br>
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
function preset(selObj) {

if (document.form1.pre.selectedIndex == 0){document.form1.title.value=""; document.form1.field_name.value="";}
if (document.form1.pre.selectedIndex == 1){document.form1.title.value=document.form1.title.value;document.form1.vfield[2].checked=true;}
if (document.form1.pre.selectedIndex == 2){document.form1.title.value="<#msg_pre_comp_name#>";document.form1.vfield[0].checked=true;}
if (document.form1.pre.selectedIndex == 3){document.form1.title.value="<#msg_pre_fname#>";document.form1.vfield[0].checked=true;}
if (document.form1.pre.selectedIndex == 4){document.form1.title.value="<#msg_pre_lname#>";document.form1.vfield[0].checked=true;}
if (document.form1.pre.selectedIndex == 5){document.form1.title.value="<#msg_pre_email#>";document.form1.vfield[1].checked=true;}
if (document.form1.pre.selectedIndex == 6){document.form1.title.value="<#msg_pre_addr1#>";document.form1.vfield[0].checked=true;}
if (document.form1.pre.selectedIndex == 7){document.form1.title.value="<#msg_pre_addr2#>";document.form1.vfield[0].checked=true;}
if (document.form1.pre.selectedIndex == 8){document.form1.title.value="<#msg_pre_city#>";document.form1.vfield[0].checked=true;}
if (document.form1.pre.selectedIndex == 9){document.form1.title.value="<#msg_pre_state#>";document.form1.vfield[0].checked=true;}
if (document.form1.pre.selectedIndex == 10){document.form1.title.value="<#msg_pre_zip#>";document.form1.vfield[2].checked=true;}
if (document.form1.pre.selectedIndex == 11){document.form1.title.value="<#msg_pre_country#>";document.form1.vfield[0].checked=true;}
if (document.form1.pre.selectedIndex == 12){document.form1.title.value="<#msg_pre_homepage#>";document.form1.vfield[0].checked=true;}
if (document.form1.pre.selectedIndex == 13){document.form1.title.value="<#msg_pre_phone#>";document.form1.vfield[0].checked=true;}
if (document.form1.pre.selectedIndex == 14){document.form1.title.value="<#msg_pre_fax#>";document.form1.vfield[0].checked=true;}
fill_out(document.form1.sel);
}


//-->
function checkform() {
if (document.form1.title.value==''){alert ("<#msg_title_blank#>");document.form1.title.select();document.form1.title.focus();return false;}   
else {	return true;}
}



</script>
