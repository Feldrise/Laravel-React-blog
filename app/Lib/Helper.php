<?php 

namespace App\Lib;

trait Helper
{
    /**
     * Converts a title into a slug.
     *
     * @param string $text The title to convert.
     * @return string The resulting slug.
     */
    public function slugify($text) {
        // Convert accented characters to their ASCII equivalent.
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        // Remove non-alphanumeric characters.
        $text = preg_replace('/[^a-zA-Z0-9]/', '-', $text);
        // Remove dashes at the beginning and end of the string.
        $text = trim($text, '-');
        // Convert to lowercase.
        $text = strtolower($text);
        return $text;
    } 
}

?>