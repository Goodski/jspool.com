<tr>
<td class="color4"><table width="100%" border="0" cellspacing="6" cellpadding="0">
<tr>
<td><span class="tlabel">*</span> <#msg_req_fields#></td>
</tr>
</table>
</td>
</tr>
<tr>
<td class="color2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3" class="tlabel-bg"><table border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
<td><img src="images/tlabel-a.gif" width="18" height="11"></td>
<td class="color2" style="padding:0 8px"><span class="tlabel"><#msg_page_details#></span></td>
<td><img src="images/tlabel-b.gif" width="3" height="11"></td>
</tr>
</table></td>
</tr>
<tr>
<td class="color5" width="1"><img src="images/1x1.gif" width="1" height="1"></td>
<td width="100%" align="center">
<table border="0" align="left" cellpadding="0" cellspacing="5">
<form action="addpage.php?form=<#formid#>&do=<#do#>" method="post">
<tr>
<td align="right" nowrap><strong><#msg_page_name#></strong> <span class="tlabel">*</span></td>
<td>
<input name="pagename" value="<#pagename#>" id="pagename" type="text" class="widefields" size="100"<#onblur#>>
</td>
</tr>
<tr>
<td align="right" nowrap><strong><#msg_page_url#></strong> <span class="tlabel">*</span></td>
<td>
<input name="pageurl" value="<#pageurl#>" id="pageurl" type="text" class="widefields" size="100"<#disabled#>>
</td>
</tr>

<tr>
<td align="right" nowrap><strong><#msg_position#></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>
 <select name="pos" class="selects">
   <option value="1"><#msg_first#></option>
   <#pos#>
 </select>
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
<tr>
<td class="color5"><img src="images/1x1.gif" width="1" height="1"></td>
</tr>
<tr>
<td align="center" class="color2"><input name="Submit" type="submit" class="buttons" value="<#msg_submit#>"> <input name="cancel" type="button" class="buttons" value="<#msg_cancel#>" onclick="document.location = 'formedit.php?form=<#formid#>';"> <input name="Reset" type="reset" class="button" value="<#msg_reset#>"></td>
</tr>
</form>
</table>

<script language="JavaScript">
 function SetURL()
 {
  var name, url, kname = '', html = '', ext = '';
  var def = '<#site_url#>';
  name = document.getElementById('pagename');
  url  = document.getElementById('pageurl');

  sname = name.value;
  
  for (var i = 0; i < sname.length; i++) {
    var chr = sname.charAt(i);
	
	if (chr == ' ')
	{
		kname = kname + '-';
	}
	else
	{
	 kname = kname + chr;
	}
  }
 
  //kname = escape(kname); 
  
  if (kname.charAt(kname.length-5) == '.')
  {
    ext = kname.substring(kname.length-4,kname.length);  
  }
  
  if (kname.charAt(kname.length-4) == '.')
  {
    ext = kname.substring(kname.length-3,kname.length);  
  }

  if (kname.charAt(kname.length-3) == '.')
  {
    ext = kname.substring(kname.length-2,kname.length);  
  }
      
  ext = ext.toLowerCase();

ext = (ext == 'ad') ? "" : ext;
ext = (ext == 'ae') ? "" : ext;
ext = (ext == 'af') ? "" : ext;
ext = (ext == 'ag') ? "" : ext;
ext = (ext == 'ai') ? "" : ext;
ext = (ext == 'al') ? "" : ext;
ext = (ext == 'am') ? "" : ext;
ext = (ext == 'an') ? "" : ext;
ext = (ext == 'ao') ? "" : ext;
ext = (ext == 'aq') ? "" : ext;
ext = (ext == 'ar') ? "" : ext;
ext = (ext == 'as') ? "" : ext;
ext = (ext == 'at') ? "" : ext;
ext = (ext == 'au') ? "" : ext;
ext = (ext == 'aw') ? "" : ext;
ext = (ext == 'az') ? "" : ext;
ext = (ext == 'ba') ? "" : ext;
ext = (ext == 'bb') ? "" : ext;
ext = (ext == 'bd') ? "" : ext;
ext = (ext == 'be') ? "" : ext;
ext = (ext == 'bf') ? "" : ext;
ext = (ext == 'bg') ? "" : ext;
ext = (ext == 'bh') ? "" : ext;
ext = (ext == 'bi') ? "" : ext;
ext = (ext == 'bj') ? "" : ext;
ext = (ext == 'bm') ? "" : ext;
ext = (ext == 'bn') ? "" : ext;
ext = (ext == 'bo') ? "" : ext;
ext = (ext == 'br') ? "" : ext;
ext = (ext == 'bs') ? "" : ext;
ext = (ext == 'bt') ? "" : ext;
ext = (ext == 'bv') ? "" : ext;
ext = (ext == 'bw') ? "" : ext;
ext = (ext == 'by') ? "" : ext;
ext = (ext == 'bz') ? "" : ext;
ext = (ext == 'ca') ? "" : ext;
ext = (ext == 'cc') ? "" : ext;
ext = (ext == 'cf') ? "" : ext;
ext = (ext == 'cg') ? "" : ext;
ext = (ext == 'ch') ? "" : ext;
ext = (ext == 'ci') ? "" : ext;
ext = (ext == 'ck') ? "" : ext;
ext = (ext == 'cl') ? "" : ext;
ext = (ext == 'cm') ? "" : ext;
ext = (ext == 'cn') ? "" : ext;
ext = (ext == 'co') ? "" : ext;
ext = (ext == 'cr') ? "" : ext;
ext = (ext == 'cs') ? "" : ext;
ext = (ext == 'cu') ? "" : ext;
ext = (ext == 'cv') ? "" : ext;
ext = (ext == 'cx') ? "" : ext;
ext = (ext == 'cy') ? "" : ext;
ext = (ext == 'cz') ? "" : ext;
ext = (ext == 'de') ? "" : ext;
ext = (ext == 'dj') ? "" : ext;
ext = (ext == 'dk') ? "" : ext;
ext = (ext == 'dm') ? "" : ext;
ext = (ext == 'do') ? "" : ext;
ext = (ext == 'dz') ? "" : ext;
ext = (ext == 'ec') ? "" : ext;
ext = (ext == 'ee') ? "" : ext;
ext = (ext == 'eg') ? "" : ext;
ext = (ext == 'eh') ? "" : ext;
ext = (ext == 'er') ? "" : ext;
ext = (ext == 'es') ? "" : ext;
ext = (ext == 'et') ? "" : ext;
ext = (ext == 'fi') ? "" : ext;
ext = (ext == 'fj') ? "" : ext;
ext = (ext == 'fk') ? "" : ext;
ext = (ext == 'fm') ? "" : ext;
ext = (ext == 'fo') ? "" : ext;
ext = (ext == 'fr') ? "" : ext;
ext = (ext == 'fx') ? "" : ext;
ext = (ext == 'ga') ? "" : ext;
ext = (ext == 'gb') ? "" : ext;
ext = (ext == 'gd') ? "" : ext;
ext = (ext == 'ge') ? "" : ext;
ext = (ext == 'gf') ? "" : ext;
ext = (ext == 'gh') ? "" : ext;
ext = (ext == 'gi') ? "" : ext;
ext = (ext == 'gl') ? "" : ext;
ext = (ext == 'gm') ? "" : ext;
ext = (ext == 'gn') ? "" : ext;
ext = (ext == 'gp') ? "" : ext;
ext = (ext == 'gq') ? "" : ext;
ext = (ext == 'gr') ? "" : ext;
ext = (ext == 'gs') ? "" : ext;
ext = (ext == 'gt') ? "" : ext;
ext = (ext == 'gu') ? "" : ext;
ext = (ext == 'gw') ? "" : ext;
ext = (ext == 'gy') ? "" : ext;
ext = (ext == 'hk') ? "" : ext;
ext = (ext == 'hm') ? "" : ext;
ext = (ext == 'hn') ? "" : ext;
ext = (ext == 'hr') ? "" : ext;
ext = (ext == 'ht') ? "" : ext;
ext = (ext == 'hu') ? "" : ext;
ext = (ext == 'id') ? "" : ext;
ext = (ext == 'ie') ? "" : ext;
ext = (ext == 'il') ? "" : ext;
ext = (ext == 'in') ? "" : ext;
ext = (ext == 'io') ? "" : ext;
ext = (ext == 'iq') ? "" : ext;
ext = (ext == 'ir') ? "" : ext;
ext = (ext == 'is') ? "" : ext;
ext = (ext == 'it') ? "" : ext;
ext = (ext == 'jm') ? "" : ext;
ext = (ext == 'jo') ? "" : ext;
ext = (ext == 'jp') ? "" : ext;
ext = (ext == 'ke') ? "" : ext;
ext = (ext == 'kg') ? "" : ext;
ext = (ext == 'kh') ? "" : ext;
ext = (ext == 'ki') ? "" : ext;
ext = (ext == 'km') ? "" : ext;
ext = (ext == 'kn') ? "" : ext;
ext = (ext == 'kp') ? "" : ext;
ext = (ext == 'kr') ? "" : ext;
ext = (ext == 'kw') ? "" : ext;
ext = (ext == 'ky') ? "" : ext;
ext = (ext == 'kz') ? "" : ext;
ext = (ext == 'la') ? "" : ext;
ext = (ext == 'lb') ? "" : ext;
ext = (ext == 'lc') ? "" : ext;
ext = (ext == 'li') ? "" : ext;
ext = (ext == 'lk') ? "" : ext;
ext = (ext == 'lr') ? "" : ext;
ext = (ext == 'ls') ? "" : ext;
ext = (ext == 'lt') ? "" : ext;
ext = (ext == 'lu') ? "" : ext;
ext = (ext == 'lv') ? "" : ext;
ext = (ext == 'ly') ? "" : ext;
ext = (ext == 'ma') ? "" : ext;
ext = (ext == 'mc') ? "" : ext;
ext = (ext == 'md') ? "" : ext;
ext = (ext == 'mg') ? "" : ext;
ext = (ext == 'mh') ? "" : ext;
ext = (ext == 'mk') ? "" : ext;
ext = (ext == 'ml') ? "" : ext;
ext = (ext == 'mm') ? "" : ext;
ext = (ext == 'mn') ? "" : ext;
ext = (ext == 'mo') ? "" : ext;
ext = (ext == 'mp') ? "" : ext;
ext = (ext == 'mq') ? "" : ext;
ext = (ext == 'mr') ? "" : ext;
ext = (ext == 'ms') ? "" : ext;
ext = (ext == 'mt') ? "" : ext;
ext = (ext == 'mu') ? "" : ext;
ext = (ext == 'mv') ? "" : ext;
ext = (ext == 'mw') ? "" : ext;
ext = (ext == 'mx') ? "" : ext;
ext = (ext == 'my') ? "" : ext;
ext = (ext == 'mz') ? "" : ext;
ext = (ext == 'na') ? "" : ext;
ext = (ext == 'nc') ? "" : ext;
ext = (ext == 'ne') ? "" : ext;
ext = (ext == 'nf') ? "" : ext;
ext = (ext == 'ng') ? "" : ext;
ext = (ext == 'ni') ? "" : ext;
ext = (ext == 'nl') ? "" : ext;
ext = (ext == 'no') ? "" : ext;
ext = (ext == 'np') ? "" : ext;
ext = (ext == 'nr') ? "" : ext;
ext = (ext == 'nt') ? "" : ext;
ext = (ext == 'nu') ? "" : ext;
ext = (ext == 'nz') ? "" : ext;
ext = (ext == 'om') ? "" : ext;
ext = (ext == 'pa') ? "" : ext;
ext = (ext == 'pe') ? "" : ext;
ext = (ext == 'pf') ? "" : ext;
ext = (ext == 'pg') ? "" : ext;
ext = (ext == 'ph') ? "" : ext;
ext = (ext == 'pk') ? "" : ext;
ext = (ext == 'pl') ? "" : ext;
ext = (ext == 'pm') ? "" : ext;
ext = (ext == 'pn') ? "" : ext;
ext = (ext == 'pr') ? "" : ext;
ext = (ext == 'pt') ? "" : ext;
ext = (ext == 'pw') ? "" : ext;
ext = (ext == 'py') ? "" : ext;
ext = (ext == 'qa') ? "" : ext;
ext = (ext == 're') ? "" : ext;
ext = (ext == 'ro') ? "" : ext;
ext = (ext == 'ru') ? "" : ext;
ext = (ext == 'rw') ? "" : ext;
ext = (ext == 'sa') ? "" : ext;
ext = (ext == 'sb') ? "" : ext;
ext = (ext == 'sc') ? "" : ext;
ext = (ext == 'sd') ? "" : ext;
ext = (ext == 'se') ? "" : ext;
ext = (ext == 'sg') ? "" : ext;
ext = (ext == 'sh') ? "" : ext;
ext = (ext == 'si') ? "" : ext;
ext = (ext == 'sj') ? "" : ext;
ext = (ext == 'sk') ? "" : ext;
ext = (ext == 'sl') ? "" : ext;
ext = (ext == 'sm') ? "" : ext;
ext = (ext == 'sn') ? "" : ext;
ext = (ext == 'so') ? "" : ext;
ext = (ext == 'sr') ? "" : ext;
ext = (ext == 'st') ? "" : ext;
ext = (ext == 'su') ? "" : ext;
ext = (ext == 'sv') ? "" : ext;
ext = (ext == 'sy') ? "" : ext;
ext = (ext == 'sz') ? "" : ext;
ext = (ext == 'tc') ? "" : ext;
ext = (ext == 'td') ? "" : ext;
ext = (ext == 'tf') ? "" : ext;
ext = (ext == 'tg') ? "" : ext;
ext = (ext == 'th') ? "" : ext;
ext = (ext == 'tj') ? "" : ext;
ext = (ext == 'tk') ? "" : ext;
ext = (ext == 'tm') ? "" : ext;
ext = (ext == 'tn') ? "" : ext;
ext = (ext == 'to') ? "" : ext;
ext = (ext == 'tp') ? "" : ext;
ext = (ext == 'tr') ? "" : ext;
ext = (ext == 'tt') ? "" : ext;
ext = (ext == 'tv') ? "" : ext;
ext = (ext == 'tw') ? "" : ext;
ext = (ext == 'tz') ? "" : ext;
ext = (ext == 'ua') ? "" : ext;
ext = (ext == 'ug') ? "" : ext;
ext = (ext == 'uk') ? "" : ext;
ext = (ext == 'um') ? "" : ext;
ext = (ext == 'us') ? "" : ext;
ext = (ext == 'uy') ? "" : ext;
ext = (ext == 'uz') ? "" : ext;
ext = (ext == 'va') ? "" : ext;
ext = (ext == 'vc') ? "" : ext;
ext = (ext == 've') ? "" : ext;
ext = (ext == 'vg') ? "" : ext;
ext = (ext == 'vi') ? "" : ext;
ext = (ext == 'vn') ? "" : ext;
ext = (ext == 'vu') ? "" : ext;
ext = (ext == 'wf') ? "" : ext;
ext = (ext == 'ws') ? "" : ext;
ext = (ext == 'ye') ? "" : ext;
ext = (ext == 'yt') ? "" : ext;
ext = (ext == 'yu') ? "" : ext;
ext = (ext == 'za') ? "" : ext;
ext = (ext == 'zm') ? "" : ext;
ext = (ext == 'zr') ? "" : ext;
ext = (ext == 'zw') ? "" : ext;
ext = (ext == 'com') ? "" : ext;
ext = (ext == 'edu') ? "" : ext;
ext = (ext == 'gov') ? "" : ext;
ext = (ext == 'int') ? "" : ext;
ext = (ext == 'mil') ? "" : ext;
ext = (ext == 'net') ? "" : ext;
ext = (ext == 'org') ? "" : ext;
ext = (ext == 'arpa') ? "" : ext;
ext = (ext == 'info') ? "" : ext;
ext = (ext == 'name') ? "" : ext;
ext = (ext == 'nato') ? "" : ext;
  
  if (ext=='') 
  {
   html = '.html';
  }
  
  url.value = def + kname + html;
 }
</script>

</td>
</tr>

