<?php

namespace App\Helpers;

use App\User;
use Request;

class CustomsHelper
{

    public function random_strings($length_of_string) {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }

    public function generateReferCode() {
        $number = self::random_strings(10);
        if (User::where('refer_code', $number)->count() > 0) self::generateReferCode();
        return $number;
    }
}
