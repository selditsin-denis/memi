<?php

namespace Services;

use Includes\LImageHandler;

class Lobsterator
{
    private string $img_path;
    private string $text;
    public const FONT_PATH = __DIR__."/../fonts/lobster.ttf";
    private string $result_path;

    public function __construct(string $img_path, string $text)
    {
        $this->img_path = $img_path;
        $this->text = $text;
        $this->result_path = "";
    }

    public function lobsterate(): void
    {
        $colorArray = array(255, 255, 255);
        $ih = new LImageHandler;
        $imgObj = $ih->load($this->img_path);
        $width = $imgObj->getWidth();
        $height = $imgObj->getHeight();
        $fontSize = $this->getFontSize($width, $height);
        $imgObj->text($this->text, self::FONT_PATH, $fontSize, $colorArray, LImageHandler::CORNER_CENTER_BOTTOM, 0, 50);
        $f_array = explode("/", $this->img_path);
        $filename = end($f_array);
        if(!is_dir("result")) {
            mkdir("result");
        }
        $this->result_path = "result/{$filename}";
        echo $filename;
        $imgObj->save($this->result_path);
    }

    public function getResultPath(): string
    {
        return $this->result_path;
    }

    private function getFontSize(int $width, int $height): int
    {
        // TODO: определение размера шрифта в зависимости от размера картинки
        return 45;
    }
}