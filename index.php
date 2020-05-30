<!doctype html>
<html>
<head>
    <meta charset="UTF-8">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.6.0/p5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.6.0/addons/p5.dom.min.js"></script>
    <script src="https://unpkg.com/ml5@0.0.3/dist/ml5.js"></script>

</head>

<body>
<!--создаем json с именами картинок-->
<?php
    $json_file = fopen("ml5/assets/data.json", "w");
    $images = ['images' => array_slice(scandir("ml5/images/dataset"), 2)];
    $result = json_encode($images);
    fwrite($json_file, $result);
    fclose($json_file);
?>


<div id="output"></div>
<p><span id="result">...</span></p>
<script src="ml5/sketch.js"></script>

</body>

</html>
