<?php
include("inc/init.php");
	
	$hash = mysql_escape_string($_REQUEST['hash']);
	$res = @mysql_query("SELECT * FROM requests WHERE hash = '".$hash."';");
	
	if(@mysql_num_rows($res) != 1)
	{
		header("Location: /");
		exit();
	}
	
	$row = @mysql_fetch_array($res);
	
	if($row['status'] == 1)
	{
		echo "<b>Request closed.</b>";
		exit();
	}
	
	if($_GET['do'] == 'responce')
	{
		@mysql_query("UPDATE requests SET status = 1, responce = '".mysql_escape_string($_POST['responce'])."' WHERE hash = '".$hash."';");	
		@mail($row['email'], 'Re: Form Maker Pro', $_POST['responce'], "From: support@web-site-scripts.com");
		echo "<b>Responce sent</b>";
	}
	else
	{
		echo "<HTML>\n";
		echo "<BODY>\n";
		echo "<center><TABLE width=\"60%\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\"><tr><td><b>From:</b></td>\n";
		echo "<td>".$row['login']." &lt;".$row['email']."&gt;</td>\n";
		echo "</tr><tr><td><b>Request type:</b></td>";
		echo "<td>".(($row['type'] == 1) ? "Help on service" : "Bug report")."</td>\n";
		echo "</tr><tr><td><b>Request:</b></td>\n";
		echo "<td>".nl2br(htmlspecialchars($row['body']))."</td>";
		echo "</tr><form action=\"responce.php?hash=".$hash."&do=responce\" method=\"POST\">\n";
		echo "<tr><td colspan=2>&nbsp;</td></tr><tr><td><b>Response:</b></td><td>\n";
		echo "<TEXTAREA name=\"responce\" cols=\"50\" rows=\"10\"></TEXTAREA>";
		echo "</td></tr>\n";
		echo "<tr><td colspan=2 align=center><input type=Submit></td></tr>\n";		
		echo "</TABLE></center>\n";		
		echo "</BODY>";
		echo "</HTML>";
	}
?>