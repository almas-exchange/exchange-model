<?php

use Illuminate\Support\Carbon;

if (!function_exists('modelNamespace')) {
    function modelNamespace($model)
    {
        return config('exchange-model.model_namespace') ? config('exchange-model.model_namespace') . $model : '\\App\\Models\\' . $model;
    }
}

if (!function_exists('getNameWithIban')) {
    function getNameWithIban($iban)
    {
        $code = substr($iban, 2, 3);
        switch ($code) {
            case '055':
                return ['bank_name' => 'Eghtesad Novin', 'label' => 'اقتصاد نوین', 'code' => 'en'];
            case '054':
                return ['bank_name' => 'Parsian', 'label' => 'پارسیان', 'code' => 'parsian'];
            case '057':
                return ['bank_name' => 'Pasargad', 'label' => 'پاسارگاد', 'code' => 'bpi'];
            case '021':
                return ['bank_name' => 'Iran Post Bank', 'label' => 'پست بانک', 'code' => 'post'];
            case '018':
                return ['bank_name' => 'Tejarat', 'label' => 'تجارت', 'code' => 'tejarat'];
            case '051':
                return ['bank_name' => 'Moasese Etebari Tose-e', 'label' => 'موسسه اعتباری توسعه', 'code' => 'tt'];
            case '020':
                return ['bank_name' => 'Tose-e Saderat', 'label' => 'توسعه تجارت', 'code' => 'tt'];
            case '013':
                return ['bank_name' => 'Refah', 'label' => 'رفاه', 'code' => 'rb'];
            case '056':
                return ['bank_name' => 'Saman', 'label' => 'سامان', 'code' => 'sb'];
            case '015':
                return ['bank_name' => 'Sepah', 'label' => 'سپه', 'code' => 'sepah'];
            case '058':
                return ['bank_name' => 'Sarmayeh', 'label' => 'سرمایه', 'code' => 'sarmayeh'];
            case '019':
                return ['bank_name' => 'Saderat Iran', 'label' => 'صادرات ایران', 'code' => 'bsi'];
            case '011':
                return ['bank_name' => 'Sanat Madan', 'label' => 'صنعت و معدن', 'code' => 'bim'];
            case '053':
                return ['bank_name' => 'Kar Afarin', 'label' => 'کارآفرین', 'code' => 'kar'];
            case '016':
                return ['bank_name' => 'Keshavarzi', 'label' => 'کشاورزی', 'code' => 'bki'];
            case '010':
                return ['bank_name' => 'Central Bank', 'label' => 'مرکزی', 'code' => null];
            case '014':
                return ['bank_name' => 'Maskan', 'label' => 'مسکن', 'code' => 'maskan'];
            case '012':
                return ['bank_name' => 'Mellat', 'label' => 'ملت', 'code' => 'mellat'];
            case '017':
                return ['bank_name' => 'Melli Iran', 'label' => 'ملی', 'code' => 'bmi'];
            default:
                return ['bank_name' => 'Unknown', 'label' => 'سایر', 'code' => null];
        }
    }
}

if (!function_exists('getNameWithCard')) {
    function getNameWithCard($card)
    {
        $code = substr($card, 0, 6);
        switch ($code) {
            case '603799':
                return ['label' => 'ملی', 'code' => 'bmi'];
            case '589210':
                return ['label' => 'سپه', 'code' => 'sepah'];
            case '627648':
                return ['label' => 'توسعه صادرات', 'code' => 'edbi'];
            case '627961':
                return ['label' => 'صنعت و معدن', 'code' => 'bim'];
            case '603770':
                return ['label' => 'کشاورزی', 'code' => 'bki'];
            case '628023':
                return ['label' => 'مسکن', 'code' => 'maskan'];
            case '627760':
                return ['label' => 'پست بانک', 'code' => 'post'];
            case '502908':
                return ['label' => 'توسعه تعاون', 'code' => 'tt'];
            case '627412':
                return ['label' => 'اقتصاد نوین', 'code' => 'en'];
            case '622106':
                return ['label' => 'پارسیان', 'code' => 'parsian'];
            case '502229':
                return ['label' => 'پاسارگاد', 'code' => 'bpi'];
            case '627488':
                return ['label' => 'کارآفرین', 'code' => 'kar'];
            case '621986':
                return ['label' => 'سامان', 'code' => 'sb'];
            case '639346':
                return ['label' => 'سینا', 'code' => 'sina'];
            case '639607':
                return ['label' => 'سرمایه', 'code' => 'sarmayeh'];
            case '636214':
                return ['label' => 'آینده', 'code' => 'ba'];
            case '502806':
                return ['label' => 'شهر', 'code' => 'shahr'];
            case '502938':
                return ['label' => 'دی', 'code' => 'day'];
            case '603769':
                return ['label' => 'صادرات', 'code' => 'bsi'];
            case '610433':
                return ['label' => 'ملت', 'code' => 'mellat'];
            case '627353':
                return ['label' => 'تجارت', 'code' => 'tejarat'];
            case '589463':
                return ['label' => 'رفاه', 'code' => 'rb'];
            case '627381':
                return ['label' => 'انصار', 'code' => 'ansar'];
            case '639370':
                return ['label' => 'مهر اقتصاد', 'code' => 'sepah'];
            default:
                return ['label' => 'سایر', 'code' => null];
        }
    }
}

if (!function_exists('randomString')) {
    function randomString($length = 10, $strtoupper = true)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        if ($strtoupper) {
            return strtoupper($randomString);
        }
        return $randomString;
    }
}

if (!function_exists('addAmount')) {
    function addAmount(string $num1, string $num2, ?int $scale = 18)
    {
        $bcadd = bcadd($num1, $num2, $scale);
        $rtrim = rtrim($bcadd, '0');
        return rtrim($rtrim, '.');
    }
}

if (!function_exists('subAmount')) {
    function subAmount(string $num1, string $num2, ?int $scale = 18)
    {
        $bcsub = bcsub($num1, $num2, $scale);
        $rtrim = rtrim($bcsub, '0');
        return rtrim($rtrim, '.');
    }
}

if (!function_exists('mulAmount')) {
    function mulAmount(string $num1, string $num2, ?int $scale = 18)
    {
        $bcmul = bcmul($num1, $num2, $scale);
        $rtrim = rtrim($bcmul, '0');
        return rtrim($rtrim, '.');
    }
}

if (!function_exists('divAmount')) {
    function divAmount(string $num1, string $num2, ?int $scale = 18)
    {
        $bcdiv = bcdiv($num1, $num2, $scale);
        $rtrim = rtrim($bcdiv, '0');
        return rtrim($rtrim, '.');
    }
}

if (!function_exists('timeFrame')) {
    function timeFrame($time, $frame)
    {
        $result = null;
        if (in_array($frame, ['1', 'm1', '60', '60s', '1minute', '1_minute', 'first', '60seconds', '60_seconds'])) {
            $result = $time - fmod($time, 60);
        } elseif (in_array($frame, ['2', '5', 'm5', '300', '300s', '5minutes', '5_minutes', '300seconds', '300_seconds'])) {
            $result = $time - fmod($time, 300);
        } elseif (in_array($frame, ['3', '15', 'm15', '900', '900s', '15minutes', '15_minutes', '900seconds', '900_seconds'])) {
            $result = $time - fmod($time, 900);
        } elseif (in_array($frame, ['4', '30', 'm30', '1800', '1800s', '30minutes', '30_minutes', '1800seconds', '1800_seconds'])) {
            $result = $time - fmod($time, 1800);
        } elseif (in_array($frame, ['5', '60', 'h1', '3600', '3600s', '60minutes', '60_minutes', '3600seconds', '3600_seconds'])) {
            $result = Carbon::createFromTimestamp($time)->startOfHour()->unix();
        } elseif (in_array($frame, ['6', '240', 'h4', '14400', '14400s', '240minutes', '240_minutes', '14400seconds', '14400_seconds'])) {
            $startOfDay = Carbon::createFromTimestamp($time)->startOfDay()->unix();
            $different = $time - $startOfDay;
            $afterStartOfDay = $different - fmod($different, 14400);
            $result = $startOfDay + $afterStartOfDay;
        } elseif (in_array($frame, ['7', '1440', 'd', 'd1', '86400', '86400s', '1440minutes', '1440_minutes', '86400seconds', '86400_seconds'])) {
            $result = Carbon::createFromTimestamp($time)->startOfDay()->unix();
        }
        return $result;
    }
}
if (!function_exists('ClassifyChar')) {
    function ClassifyChar($ch)
    {
        if (('a' <= $ch && 'z' >= $ch) || ' ' == $ch)
            return 'lower';
        if ('A' <= $ch && 'Z' >= $ch)
            return 'upper';
        if ('0' <= $ch && '9' >= $ch)
            return 'number';
        if (false === strpos("`~!@#$%^&*()_-+={}|[]\\:\";',./<>?", $ch))
            return 'symbol';
        return 'other';
    }
}

if (!function_exists('passwordScore')) {
    function passwordScore($pw)
    {
        if (!strlen($pw))
            return 0;

        $score = array("lower" => 26, "upper" => 26, "number" => 10, "symbol" => 35, "other" => 20);

        $dist = array();
        $used = array();
        for ($i = 0; $i < strlen($pw); $i++) {
            if (!isset($used[$pw[$i]])) {
                $used[$pw[$i]] = 1;
                $c = ClassifyChar($pw[$i]);
                if (!isset($dist[$c]))
                    $dist[$c] = $score[$c] / 2;
                else
                    $dist[$c] = $score[$c];
            }
        }
        $total = 0;
        foreach ($dist as $k => $v) {
            $total += $v;
        }

        $used = array();
        $strength = 1;
        for ($i = 0; $i < strlen($pw); $i++) {
            if (!isset($used[$pw[$i]]))
                $used[$pw[$i]] = 1;
            else
                $used[$pw[$i]]++;

            if ($total > $used[$pw[$i]])
                $strength *= $total / $used[$pw[$i]];
        }

        $result = ((int)(log($strength))) * 2;
        if ($result >= 100) {
            $result = 100;
        }
        return $result;
    }
}

if (!function_exists('config_path')) {
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}


if (!function_exists('getTableName')) {
    function getTableName($marketName)
    {
        $marketName = str_replace(' ', '', strtolower(str_replace('/', '_', $marketName)));
        return [
            'sell'      => $marketName . '_order_sell',
            'buy'       => $marketName . '_order_buy',
            'sell_pool' => $marketName . '_order_sell_pool',
            'buy_pool'  => $marketName . '_order_buy_pool'
        ];
    }
}

if (!function_exists('getQueueName')) {
    function getQueueName($marketName)
    {
        return str_replace(' ', '', strtolower(str_replace('/', '_', $marketName)));
    }
}

if (!function_exists('getCacheNameMarketLastPrice')) {
    function getCacheNameMarketLastPrice($marketName)
    {
        return str_replace(' ', '', strtolower(str_replace('/', '_', $marketName))) . '_price';
    }
}

if (!function_exists('getCacheNameMarketLastUp')) {
    function getCacheNameMarketLastUp($marketName)
    {
        return str_replace(' ', '', strtolower(str_replace('/', '_', $marketName))) . '_up';
    }
}