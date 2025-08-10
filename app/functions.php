<?php
use App\Helpers\Formatter;
use chillerlan\QRCode\QRCode;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

if (! function_exists('highlight')) {
    function highlight(string $value, ?string $search)
    {
        $value = escape($value);

        if (empty($search)) {
            return $value;
        }

        return preg_replace('/' . preg_quote($search, '/') . '/i', '<mark>$0</mark>', $value);
    }
}

if (! function_exists('escape')) {
    function escape(string $value)
    {
        return htmlspecialchars(stripslashes($value));
    }
}

if (! function_exists('content')) {
    function content(string $value, bool $use_antispambot = true)
    {
        $result = strtr($value, [
            '&nbsp;' => '',
        ]);

        if ($use_antispambot && function_exists('antispambot')) {
            $result = preg_replace_callback(
                '/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}\b/i',
                fn ($matches) => antispambot($matches[0] ?? ''),
                $result
            );
        }

        return $result;
    }
}

if (! function_exists('zeroise')) {
    function zeroise($number, $threshold)
    {
        return sprintf('%0' . $threshold . 's', $number);
    }
}

if (! function_exists('antispambot')) {
    function antispambot($email_address, $hex_encoding = 0)
    {
        $email_no_spam_address = '';

        for ($i = 0, $len = strlen($email_address); $i < $len; $i++) {
            $j = rand(0, 1 + $hex_encoding);

            if (0 === $j) {
                $email_no_spam_address .= '&#' . ord($email_address[$i]) . ';';
            } elseif (1 === $j) {
                $email_no_spam_address .= $email_address[$i];
            } elseif (2 === $j) {
                $email_no_spam_address .= '%' . zeroise(dechex(ord($email_address[$i])), 2);
            }
        }

        return str_replace('@', '&#64;', $email_no_spam_address);
    }
}

if (! function_exists('replace_link')) {
    function replace_link(string $text)
    {
        $pattern = '/\[([^\]]+)\]\(([^,\s]+)(?:,\s*(_blank))?\)/';
        $callback = function ($matches) {
            $linkText = $matches[1];
            $url = $matches[2];
            $target = isset($matches[3]) ? ' target="_blank" rel="noopener"' : '';

            return '<a href="' . htmlspecialchars($url) . '"' . $target . '>' . htmlspecialchars($linkText) . '</a>';
        };

        $html = preg_replace_callback($pattern, $callback, $text);

        return $html;
    }
}

if (! function_exists('date_format_korean')) {
    function date_format_korean(?Carbon $date, string $format = 'Y-m-d')
    {
        if (is_null($date)) {
            return null;
        }

        $result = $date->format($format);

        if (str_contains($format, 'D')) {
            $result = str_replace(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], ['월', '화', '수', '목', '금', '토', '일'], $result);
        }

        if (str_contains($format, 'l')) {
            $result = str_replace(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], ['월요일', '화요일', '수요일', '목요일', '금요일', '토요일', '일요일'], $result);
        }

        if (str_contains($format, 'A')) {
            $result = str_replace(['AM', 'PM'], ['오전', '오후'], $result);
        }

        if (str_contains($format, 'a')) {
            $result = str_replace(['am', 'pm'], ['오전', '오후'], $result);
        }

        return $result;
    }
}

if (! function_exists('qrcode')) {
    function qrcode(string $data)
    {
        return (new QRCode())->render($data);
    }
}

if (! function_exists('phone_format')) {
    function phone_format(string $phone)
    {
        return Formatter::phone($phone);
    }
}

if (! function_exists('jt_route')) {
    function jt_route(string $name, $parameters = [], bool $absolute = true)
    {
        if (Route::has(App::getLocale() . '.' . $name)) {
            return route(App::getLocale() . '.' . $name, $parameters, $absolute);
        }

        return route($name, $parameters, $absolute);
    }
}

if (! function_exists('jt_route_is')){

    function jt_route_is(string $pattern)
    {
        $pattern = App::getLocale() . '.' . $pattern;
        return request()->routeIs($pattern);
    }

}

if (! function_exists('jt_route_has')){

    function jt_route_has(string $pattern)
    {
        $pattern = App::getLocale() . '.' . $pattern;
        return Route::has($pattern);
    }

}
