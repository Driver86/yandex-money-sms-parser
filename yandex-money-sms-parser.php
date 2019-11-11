<?php

function yandexMoneySmsParser(string $text): array
{
    $data = [
        'wallet' => '',
        'amount' => '',
        'code' => '',
    ];

    $text = preg_replace_callback('/(^|[^0-9]+)(4[0-9]{12})($|[^0-9]+)/', function ($match) use (&$data) {
        $data['wallet'] = $match[2];
        return $match[1] . $match[3];
    }, $text);

    $text = preg_replace_callback('/(^|[^0-9]+)([0-9]+([,.][0-9]{1,2})?)(р\.|руб\.)/', function ($match) use (&$data) {
        $data['amount'] = $match[2];
        return $match[1] . $match[4];
    }, $text);

    $text = preg_replace_callback('/(^|[^0-9]+)([0-9]+)($|[^0-9]+)/', function ($match) use (&$data) {
        $data['code'] = $match[2];
        return $match[1] . $match[3];
    }, $text);

    return $data;
}
