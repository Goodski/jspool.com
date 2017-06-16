<?php
include("inc/init.php");
include("inc/control.php");
include("inc/template.lib.php");
include("inc/draw.php");
include("inc/generate.inc.php");
require('inc/zip.class.php');

$form_id = intval($_GET['form']);
if ($form_id<1) 
{
 echo "Form ID is incorrect";
 exit();
}

$pages = Generate($form_id);

  $zipfile = new zipfile('form.zip');
  foreach($pages AS $fl)
  {
  $name = pathinfo($fl);
  $zipfile -> addFileAndRead($fl, $name['basename']);
  }
  echo $zipfile->file();

  foreach($pages AS $fl)
  {
    unlink($fl);
  }
  
?>