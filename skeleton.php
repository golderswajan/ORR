
<?php
// Read all subfolders
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("E:/Programe files/www/htdocs/se/dashboard/"),RecursiveIteratorIterator::SELF_FIRST);
$data = "";
$html = "";

foreach($iterator as $folder)
{
  if($folder->isDir())
  {
    $all_files = glob($folder->getRealpath()."/*.php");
    $html.= "Files in this Directory:".count($all_files);
    foreach ($all_files as $filename)
    {

      $data .= "\n------------------------------------------------------\n".$filename."\n------------------------------------------------------\n";
      $html .= "<br>------------------------------------------------------<br>".$filename."<br>------------------------------------------------------<br>";
      $js = "<br>------------------------------------------------------<br>".$filename."<br>------------------------------------------------------<br>";

       // Extract functions.
      $lines   = file($filename, FILE_IGNORE_NEW_LINES);
      $matched = preg_grep('/public/', $lines);
      foreach ($matched as $line) 
      { 
        $data.= $line."\n";
        $html .=  $line."<br>";
        $js .=  $line."<br>";
      }
    }
    
  }
}
// Writing the final output
  $fp = fopen("functions.txt", 'w');
  fwrite($fp, $data);


  echo $html;

?>
