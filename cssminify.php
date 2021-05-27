<?php

// Your CSS file
$css=file_get_contents('style.css');

// All the magic happens
$css=preg_replace(
    [
        '/\r|\n|\t/',
        '/\s{2,}/',
        '/\s*(;|\{|\}|\:|\,)\s*(\w*)/',
        '/\/\*.*\*\//U'
    ],
    [
        '',
        '',
        '\1\2',
        ''
    ],
    $css
);

// output de CSS code minified, or you may want to put it back in a CSS file
echo $css;

?>
