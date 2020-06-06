<?php
    $dir = $_POST['dirname'];
    $images = ["directory" => $dir, "images" => []];
    foreach (array_slice(scandir($dir), 2) as $img) {
        $images['images'][] = $img;
    }

    echo json_encode($images);