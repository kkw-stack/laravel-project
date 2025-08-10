<?php
namespace App\Helpers;

class Formatter
{
    public static function phone(string $value) : string
    {
        if (false === static::isPhone($value)) {
            return $value;
        }

        return preg_replace('/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/', '$1-$2-$3', $value);
    }

    public static function isPhone(string $value) : bool
    {
        return preg_match(static::getPhoneRegex(), $value);
    }

    public static function getPhoneRegex($isHtml = false) : string
    {
        return $isHtml ? '^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$' : '/^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/';
    }

    public static function getPasswordRegex($isHtml = false) : string
    {
        return $isHtml ? '^(?=.*[A-Za-z])(?=.*\d)(?=.*[@!#*])[A-Za-z\d@!#*]{8,}$' : '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@!#*])[A-Za-z\d@!#*]{8,}$/';
    }

    public static function convertToUnicode(string $value) : string
    {
        return addslashes(substr(json_encode($value), 1, -1));
    }
}
