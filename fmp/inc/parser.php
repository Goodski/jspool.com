<?php
    function Parse($file, $vars)
    {
     $source = @implode("\n",@file($file));

     foreach ($vars as $key=>$value)
     {
      $source = str_replace("{".$key."}",$value, $source);
     }
      $source = preg_replace("/\{((.)*?)\}/i",'',$source);
     return $source;
    }
?>