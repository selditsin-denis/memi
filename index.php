<?php
require_once "vendor/autoload.php";

use Services\Lobsterator;
use Services\Translator;

$url = file_get_contents("ml5/del.html");

$contents = json_decode($url,true);

foreach ($contents as $content)
{
    $img_path = $content['image'];
    $en_text = $content['text'];

    $ru_text = Translator::translate($en_text);
    $lobsterator = new Lobsterator("ml5/".$img_path, $ru_text.")");
    $lobsterator->lobsterate();
    echo $lobsterator->getResultPath();
}
