
<?php
// Read all subfolders
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("E:\Programe files\www\htdocs\Noor"),RecursiveIteratorIterator::SELF_FIRST);

$html = "";

foreach($iterator as $folder)
{
  if($folder->isDir())
  {
    $all_files = glob($folder->getRealpath()."/*.*");
    $html.= "Files in this Directory:".count($all_files)."<br>";
    foreach ($all_files as $filename)
    {

      $html .= $filename."<br>";
    }
  }
}
  echo $html;
?>