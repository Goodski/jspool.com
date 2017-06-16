   <table border="0" cellpadding="0" cellspacing="2">
   <form action="database.php" method="post" name="form1">
   <tr>
      <td> <strong><#choose#></strong>&nbsp;</td>
      <td>
         <select name="chform" onChange="document.form1.submit()">
            <!-- BEGIN row -->
            <option value="<#formn#>" <#is_selected#>><#formn#></option>
            <!-- END row -->

         </select>
      </td>
   </tr>
   </form>
   </table>
<#separator#>

<#fcr#>
<form action="database.php?step2=1" method="post">
<table border="0" cellpadding="0" cellpadding="0" align="center">

<tr><td><#show_form_pages#></td></tr>

<tr><td align="center"><br><input type="Submit" class="buttons" value="<#dbfile#>"></td></tr>

</table>
