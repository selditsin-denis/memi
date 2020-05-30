<?php

namespace Services;

use Includes\LImageHandler;

class Lobsterator
{
    public const FONT_PATH = __DIR__."/../fonts/lobster.ttf";
    private string $result_path;

    private function __construct()
    {

    }

    public static function lobsterate(string $img_path, string $text): string
    {
        $word = explode(",", $text)[0].")";
        $colorArray = array(255, 255, 255);
        $ih = new LImageHandler;
        $imgObj = $ih->load($img_path);
        $width = $imgObj->getWidth();
        $height = $imgObj->getHeight();
        $fontSize = self::getFontSize($width, strlen($word)/2);
        $imgObj->text($word, self::FONT_PATH, $fontSize, $colorArray, LImageHandler::CORNER_CENTER_BOTTOM, 0, $height/11);
        $f_array = explode("/", $img_path);
        $filename = end($f_array);
        if(!is_dir("result")) {
            mkdir("result");
        }
        $result = "result/{$filename}";
        $imgObj->save($result);

//        echo $width."x".$height.":".$fontSize;
        return $result;
    }

    private static function getFontSize(int $width, int $textLength): int
    {
        $k = 0.65;
        if($textLength > 20){
            $k = 1.3;
        }elseif ($textLength <= 5){
            $k = 0.4;
        }
        return $width / $textLength * $k;
    }
}