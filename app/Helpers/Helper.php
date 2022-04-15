<?php

namespace App\Helpers;

class Helper
{
    public static function ellipse(string $input)
    {
        $str = $input;

        if( strlen($input) > 200) {
            $str = explode( "\n", wordwrap( $input, 200));
            $str = $str[0] . '...';
        }

        echo $str;
    }
}
