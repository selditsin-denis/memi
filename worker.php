<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Main</title>
</head>
<body>
    <?php
    require_once "vendor/autoload.php";

    use Services\Lobsterator;
    use Services\Translator;
    use Services\VkPublisher;

    $json = $_POST['json'];

    $contents = json_decode($json,true);
    echo '<div class="row">';
    foreach ($contents as $content)
    {
        $img_path = $content['image'];
        $en_text = $content['text'];

        $ru_text = Translator::translate($en_text);
        $result_path = Lobsterator::lobsterate($img_path, $ru_text);
//        VkPublisher::publish($result_path);
        echo '<div class="col-lg-3 col-md-4 col-6">';
        echo '<img src="'.$result_path.'" class="img-fluid"></div>';
    }
     echo "</div>";
    ?>
</body>
</html>

