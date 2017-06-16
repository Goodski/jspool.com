<?php 
function PreviewGen($form_id, $print_val = true)
{
	$res = @mysql_query("SELECT id, name FROM pages WHERE form_id = ".$form_id." AND thx = 0 AND preview = 0 ORDER by pos ASC;");
	while ($row = @mysql_fetch_row($res))
	{
		$content .= "<h1 align=\"center\">".$row[1]."</h1>\r\n";
		
		$content .= "<table width=100% cellspacing=0 border=0>\r\n";
		$res2 = @mysql_query("SELECT * FROM flds WHERE page_id = ".$row[0]." AND type < 7 ORDER BY pos;");
		while ($row2 = @mysql_fetch_array($res2))
		{
				$content .= "<tr>\r\n";
				
				$uploaded = ($row2['type'] == BROWSE) ? '_uploaded' : '';
  				$fname = FieldPrefix($row2).$row2['name'];
				$content .= "<td>".$row2['title']."</td><td>".($print_val ? "[".$fname.$uploaded."]" : "")."</td>\r\n";
				
				$content .= "</tr>";
		}
		
		$content .= "</table>\r\n\r\n";
	}
	
	if (intval(@implode(null,@mysql_fetch_row(@mysql_query("SELECT COUNT(t1.id) FROM flds as t1, pages as t2 WHERE t1.type = 8 AND t1.page_id = t2.id AND t2.form_id = ".$form_id.";")))) > 0)
	{

	$content .= "<table width=100% cellspacing=0 border=0>\r\n";
	$content .= "<tr align=\"center\" valign=\"middle\"><td colspan=2><h1>Calculations</h1></td></tr>\r\n";	
	$res = @mysql_query("SELECT t1.* FROM flds AS t1, pages AS t2 WHERE t1.type = 8 AND t1.page_id = t2.id AND t2.form_id = ".$form_id." ORDER BY t1.page_id, t1.title;");
	while($row = @mysql_fetch_array($res))
	{
		$content .= "<tr>\r\n";
		$content .= "<td>".$row['title']."</td><td>".($print_val ? "[<".$row['name'].">]" : "")."</td>\r\n";
		$content .= "</tr>";
	}
	}
	$content .= "</table>\r\n\r\n";
return $content;
}
?>