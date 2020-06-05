<?php
header("Content-Type: application/json");
function removeDirectory($dir) {
    if ($objs = glob($dir."/*")) {
        foreach($objs as $obj) {
            is_dir($obj) ? removeDirectory($obj) : unlink($obj);
        }
    }
    rmdir($dir);
}

$uploaded = array();
$result = '';

if(!empty($_FILES['file']['name'][0])) {
    foreach($_FILES['file']['name'] as $position => $name) {
        if(move_uploaded_file($_FILES['file']['tmp_name'][$position], 'uploads/'.$name)) {

            $dirname = explode('.',$name)[0];

            $zip = new ZipArchive;
            $res = $zip->open('uploads/'.$name);
            if(is_dir('uploads/'.$dirname)){
                removeDirectory('uploads/'.$dirname);
            }

            if ($res) {
                $zip->extractTo('ml5/images/dataset');
                $zip->close();
                $result = 'OK';
                createJson('ml5/images/dataset');
            } else {
                $result = 'FAILED';
            }
            $uploaded[] = array(
                'name' => $name,
                'file' => 'uploads/'.$name,
                'result' => $result
            );
            unlink('uploads/'.$name);
        }
    }
}

function createJson(string $dir){
    $json_file = fopen("ml5/assets/data.json", "w");
    $images = ['images' => array_slice(scandir($dir), 2)];
    $result = json_encode($images);
    fwrite($json_file, $result);
    fclose($json_file);
}



echo json_encode($uploaded);
