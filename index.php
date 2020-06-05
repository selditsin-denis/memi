<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.6.0/p5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.6.0/addons/p5.dom.min.js"></script>
    <script src="https://unpkg.com/ml5@0.0.3/dist/ml5.js"></script>

</head>

<body>
<!--создаем json с именами картинок-->
<div class="container">
    <div class="dropzone" id="dropzone">Перетащите файлы сюда</div>
    <div class="progress" id="progress" style="display: none;">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div id="output"></div>
    <p><span id="result" hidden></span></p><script src="ml5/sketch.js"></script>
</div>




<script>
    (function() {
        var dropzone = document.getElementById("dropzone");
        dropzone.ondrop = function(e) {
            this.className = 'dropzone';
            this.innerHTML = 'Загрузка файлов';
            e.preventDefault();
            upload(e.dataTransfer.files);
            var progress = document.getElementById("progress");
            var progressbar = document.getElementById("progress-bar");
            progress.style.display = "";
            progressbar.style.width = "2%";
        };

        var displayUploads = function(data) {
            for(x = 0; x < data.length; x++) {
                anchor = document.createElement('li');
                anchor.innerHTML = data[x].name;
            }
            if(data[0].result === "OK"){
                console.log("okeke")
                start();
                this.innerHTML = 'Загрузка файлов';
            }
        };

        var upload = function(files) {
            var formData = new FormData(),
                xhr = new XMLHttpRequest(),
                x;

            for(x = 0; x < files.length; x++) {
                formData.append('file[]', files[x]);
            }

            xhr.onload = function() {
                console.log(this.responseText)
                var data = JSON.parse(this.responseText);
                displayUploads(data);
            };

            xhr.open('post', 'upload.php');
            xhr.send(formData);
        };

        dropzone.ondragover = function() {
            this.className = 'dropzone dragover';
            this.innerHTML = 'Отпустите мышку';
            return false;
        };

        dropzone.ondragleave = function() {
            this.className = 'dropzone';
            this.innerHTML = 'Перетащите файлы сюда';
            return false;
        };

    }());
</script>
</body>
</html>
