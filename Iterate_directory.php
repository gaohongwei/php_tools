<?php

$rootpath = 'c:\wamp\www\SO_Num';
$pattern='href=';
$fileinfos = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootpath)
);
foreach($fileinfos as $pathname => $fileinfo) {
    if (!$fileinfo->isFile()) continue;

    $file_parts = pathinfo($pathname);
    if(!array_key_exists('extension',$file_parts) || $file_parts['extension'] != 'php')continue;
    echo $pathname . '<br>';
    
    foreach(file($pathname) as $line)
    {
      if(stripos($line, $pattern)!==false  )
      {
        echo htmlentities($line).'<br>';
      }
    }   
}
?>