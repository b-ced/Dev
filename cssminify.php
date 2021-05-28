<?php

/**
 * cssMinify
 *
 * Usage : cssMinify(<file> [, $returncode] [, $suffix] [, $verbose])
 * 
 * @param  string $file : CSS file
 * @param  bool $returncode : If true, will return the code directly, otherwise we write to a file (with the suffix below)
 * @param  string $suffix : suffix we append to the saved file (in case we put back in file)
 *                          Empty $suffix will overwrite the input $file
 * @param  string $verbose : will show some informations
 * 
 */



function cssMinify(string $file, bool $returncode = FALSE, string $suffix = '_min', bool $verbose = FALSE)
{
    // Do we have anything here ?
    if (!file_exists($file)) {
        return FALSE;
    }
    // Ok let's get data from the file
    $css = file_get_contents($file);

    $verbose1 = strlen($css);

    // All the magic happens
    $css = preg_replace(
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
    $verbose2 = strlen($css);

    if ($returncode) {
        //  Do we return the code ?
        return $css;
    } else {
        // Or do we write it back to a file ?
        $out = str_replace('.css', $suffix . '.css', $file);
        file_put_contents($out, $css);
    }
    // Output some informations
    if ($verbose) {
        printf('cssMinify - input file : %s (%d), output file : %s (%d) => %d bytes removed', $file, $verbose1, $out, $verbose2, ($verbose1 - $verbose2));
    }
}
echo cssMinify('style.css', FALSE, '_min', TRUE);

?>
