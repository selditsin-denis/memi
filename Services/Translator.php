<?php


namespace Services;

class Translator
{
    private const API_KEY = "trnsl.1.1.20160530T115212Z.bb853798efcc4f27.79bbe71d46f7a63f99acb6c9975159433f749862";
    private const LANG = "en-ru";

    private function __construct()
    {
    }

    public static function translate(string $text): string
    {
        $array = array(
            'key'   => self::API_KEY,
            'lang' => self::LANG,
            'text' => $text
        );

        $ch = curl_init('https://translate.yandex.net/api/v1.5/tr.json/translate?');
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array, '', '&'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $html = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($html, true);

        echo $result['text'][0];
        return $result['text'][0];
    }
}