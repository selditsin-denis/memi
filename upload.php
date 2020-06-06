<?php
header("Content-Type: application/json");

$uploaded = array();
$result = '';
$dirname = 'uploads/'.time();

if(!is_dir('uploads'))
    mkdir('uploads');

if(!empty($_FILES['file']['name'][0])) {
    foreach($_FILES['file']['name'] as $position => $name) {
        if(move_uploaded_file($_FILES['file']['tmp_name'][$position], 'uploads/'.$name)) {
            $zip = new ZipArchive;
            $res = $zip->open('uploads/'.$name);
            if ($res) {
                $zip->extractTo($dirname);
                $zip->close();
                $result = 'OK';
            } else {
                $result = 'FAILED';
            }
            $uploaded[] = array(
                'name' => $name,
                'file' => $dirname.'/'.$name,
                'result' => $result,
                'dirname' => $dirname
            );
            unlink('uploads/'.$name);
        }
    }
}

echo json_encode($uploaded);
