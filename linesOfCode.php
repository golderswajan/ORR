<?
countLinesOfCode("E:/Programe files/www/htdocs/se/");

function countLinesOfCode($path) {
   $lines = 0;
   $items = glob(rtrim($path, '/') . '/*');

   $extentions = array('php','css','js');

   foreach($items as $item) {

       if (is_file($item) AND in_array(pathinfo($item, PATHINFO_EXTENSION),$extentions)) {
           $fileContents = file_get_contents($item);
           preg_match_all('/<?(?:php)?(.*?)($|?>)/s', $fileContents, $matches);

           foreach($matches[1] as $match) {
               $lines += substr_count($match, PHP_EOL);
           }

       } else if (is_dir($item)) {
           $lines += countLinesOfCode($item);
           continue;
       }       

   }

   echo $lines;
}

var_dump(countLinesOfCode(dirname(__FILE__)));
?>