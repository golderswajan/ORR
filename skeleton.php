<?php

// Read all file and folders.
$path = "E:\Programe files\www\htdocs\se";
$it = new RecursiveTreeIterator(new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS));
  foreach($it as $path) {
  echo $path."<br>";
}

// Read all subfolders
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("E:/Programe files/www/htdocs/se"),RecursiveIteratorIterator::SELF_FIRST);
$data = "";
foreach($iterator as $file)
{
  if($file->isDir())
  {
    //echo $file->getRealpath()."\n";
    // Read all files in directory.

    $all_files = glob($file->getRealpath()."/*.*");
    //$data .= $file->getRealpath()."";
    for ($i=0; $i<count($all_files); $i++)
    {
      $filename = $all_files[$i];
      $supported_format = array('php');
      $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
      if (in_array($ext, $supported_format))
      {
         // Extract functions.

        $lines   = file($filename, FILE_IGNORE_NEW_LINES);
        $matched = preg_grep('/public/', $lines);

        $data .= "\n------------------------------------------------------\n".$filename."\n------------------------------------------------------\n";
        foreach ($matched as $line) 
        { 
          $data.= $line."\n";
        }
        
       // $fp = "functions.txt";
        //file_put_contents($fp, $data, FILE_APPEND | LOCK_EX);
      }
    }
    
  }
}
// Writing the final output
  $fp = fopen("functions.txt", 'w');
  fwrite($fp, $data);

// Read all files in directory.
/*
$all_files = glob("../bll/*.*");
$data = "";
for ($i=0; $i<count($all_files); $i++)
{
  $filename = $all_files[$i];
  $supported_format = array('php');
  $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
  if (in_array($ext, $supported_format))
  {
     // Extract functions.

    $lines   = file($filename, FILE_IGNORE_NEW_LINES);
    $matched = preg_grep('/public/', $lines);

    $data .= "\n---------------------\n".$filename."\n---------------------\n";
    foreach ($matched as $line) 
    { 
      $data.= $line."\n";
    }
    
   // $fp = "functions.txt";
    //file_put_contents($fp, $data, FILE_APPEND | LOCK_EX);
  }
}
// Writing the final output
$fp = fopen("functions.txt", 'w');
fwrite($fp, $data);*/


?>