<?php

namespace Services;

use Includes\LImageHandler;

class Lobsterator
{
    private string $img_path;
    private string $text;
    public const FONT_PATH = __DIR__."/fonts/lobster.ttf";

    public function __construct(string $img_path, string $text)
    {
        $this->img_path = $img_path;
        $this->text = $text;
    }

    public function lobsterate(): string
    {
        $colorArray = array(255, 255, 255);
        $ih = new LImageHandler;
        $imgObj = $ih->load($this->img_path);
        $width = $imgObj->getWidth();
        $height = $imgObj->getHeight();
        $fontSize = $this->getFontSize($width, $height);
        $imgObj->text($this->text, self::FONT_PATH, $fontSize, $colorArray, LImageHandler::CORNER_CENTER_BOTTOM, 0, 50);

        $filename = explode("\\", $this->img_path);

        $path = "result\\{$filename}";
        $imgObj->save($path);

        return $path;
    }

    public function getFontSize(int $width, int $height): int
    {
        // TODO: определение размера шрифта в зависимости от размера картинки
        return 45;
    }
}