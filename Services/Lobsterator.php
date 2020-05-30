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
        $colorArray = array(255, 255, 255);
        $ih = new LImageHandler;
        $imgObj = $ih->load($img_path);
        $width = $imgObj->getWidth();
        $height = $imgObj->getHeight();
        $fontSize = self::getFontSize($width, $height);
        $imgObj->text($text, self::FONT_PATH, $fontSize, $colorArray, LImageHandler::CORNER_CENTER_BOTTOM, 0, 50);
        $f_array = explode("/", $img_path);
        $filename = end($f_array);
        if(!is_dir("result")) {
            mkdir("result");
        }
        $result = "result/{$filename}";
        $imgObj->save($result);

        return $result;
    }

    private static function getFontSize(int $width, int $height): int
    {
        // TODO: определение размера шрифта в зависимости от размера картинки
        return 45;
    }
}