<?php
//_______________________________Set these Paramaters

//
$subject = $_POST['subject'];

//
$emailadd = 'info@jspool.com';

//
$url ='thanks.php';

//
$req = '0';

//
$text = "Results from jspool contact form:\n\n";
$space = ' ';
$line = '
';
foreach ($_POST as $key => $value)
{
	if ($req == '1')
{
	if ($value == '')
{echo "$key is Empty"; die;}
}
$j = strlen($key);
if ($j>= 20)
{echo "Name of form element $key cannot be longer than 20 caracters"; die;}
$j = 20-$j;
for ($i=1; $i<=$j; $i++)
{$space .= ' ';}
$value = str_replace('\n', "$line", $value);
$conc = "{$key}: $space{$value}$line";
$text.=$conc;
$space= ' ';
} 
mail($emailadd, $suject, $text, 'From:'.$emailadd.'');
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';	
 


?> 