<?php
	
	$path = "E:/Programe files/www/htdocs/se";
    function recursive_glob($pattern) 
    {
        $first_files = glob($pattern);
        foreach (glob(dirname($pattern).'/*') as $dir) 
        {
             $first_files = array_merge($first_files, recursive_glob($dir.'/'.basename($pattern)));
        }
        return $first_files;
    }
    
    function all_functions($all_files)
    {
        $html = "";
        $data = "";
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
          }
        }
        echo $html;
    }
    // Calling the function
    $files = recursive_glob($path);
    all_functions($files);

?>