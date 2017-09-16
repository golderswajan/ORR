
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
    $html.= count($all_files);
    for ($i=0; $i<count($all_files); $i++)
    {
      $filename = $all_files[$i];

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

  echo "<script type='text/javascript'> var data_ = ".$html."</script>";

?>
<script type="text/javascript">
  document.write(data_+'new line');
</script>