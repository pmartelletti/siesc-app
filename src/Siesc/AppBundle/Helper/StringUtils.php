<?php
namespace Siesc\AppBundle\Helper;


class StringUtils
{
    public static function buildAcronym($string)
    {
        $v = $string;

        if(preg_match_all('/\b(\w)/',strtoupper($string),$m)) {
            $v = implode('',$m[1]); // $v is now SOQTU
        }

        return $v;
    }

    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }

    public static function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }
} 