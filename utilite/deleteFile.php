<?php
$dir = "../cache_files";
$di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
foreach ( $ri as $file ) 
    {
        $file->isDir() ?  rmdir($file) : unlink($file);
    }
return true;
?>