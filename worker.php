<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner" style="height: 400px;">
        <?php
        require_once "vendor/autoload.php";

        use Services\Lobsterator;
        use Services\Translator;
        use Services\VkPublisher;

        $json = $_POST['json'];

        $contents = json_decode($json,true);
        $k=0;
        foreach ($contents as $content)
        {
            $k++;
            $img_path = $content['image'];
            $en_text = $content['text'];

            $ru_text = Translator::translate($en_text);
            $result_path = Lobsterator::lobsterate($img_path, $ru_text);
//  VkPublisher::publish($result_path);
            if($k == 1)
                echo '<div class="carousel-item active">';
            else
                echo '<div class="carousel-item">';
            echo '<img src="'.$result_path.'" class="d-block"></div>';
        }
        ?>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


