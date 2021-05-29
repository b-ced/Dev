<?php

/**
 * cssMinify
 * A PHP function to minify CSS code
 * Usage : cssMinify(<file> [, $returncode] [, $verbose] [, $suffix])
 * 
 * @param  string $file : CSS file
 * @param  bool $returncode : If true, will return the code directly, otherwise we write to a file (with the suffix below)
 * @param  string $verbose : will show some informations
 * @param  string $suffix : suffix we append to the saved file (in case we put back in file)
 *                          Empty $suffix will overwrite the input $file
 * 
 */



function cssMinify(string $file, bool $returncode = FALSE, bool $verbose = FALSE, string $suffix = '_min')
{
    // Do we have anything here ?
    if (!file_exists($file)) {
        return FALSE;
    }
    // Ok let's get data from the file
    $css = file_get_contents($file);
    $verb = strlen($css);
    $out = str_replace('.css', $suffix . '.css', $file);

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

    // Output some informations
    if ($verbose) {
        printf(
            "cssMinify - input file : %s (%d), output file : %s (%d) => %d bytes removed\n",
            $file,
            $verb,
            ($returncode ? 'code returned' : $out),
            strlen($css),
            ($verb - strlen($css))
        );
    }
    if ($returncode) {
        //  Do we return the code ?
        return $css;
    } else {
        // Or do we write it back to a file ?
        file_put_contents($out, $css);
    }
}


?>
