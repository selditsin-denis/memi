// Выгрузка ImageNet
const classifier = new ml5.ImageClassifier('MobileNet');

let img;
let currentIndex = 0;
let allImages = [];
let texts = []
let display = true;
let displayTime = 1;
let predictions = [];
let data;

function appendImages(dirname) {
  jsonPath = "jsonformer.php";

  let xmlhttp = new XMLHttpRequest();
  let body = 'dirname='+dirname;
  xmlhttp.onreadystatechange = function()
  {
    if (this.readyState === 4 && this.status === 200)
    {
      data = JSON.parse(this.responseText);
      for (j = 0; j< data.images.length; j++){
        imgPath = data.directory+"/"+data.images[j];
        allImages.push(imgPath);
      }
      imgCreate();
    }
  };
  xmlhttp.open("POST", jsonPath, true);
  xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xmlhttp.send(body);
}

function drawNextImage() {
  img.attribute('src', allImages[currentIndex], imageReady);
  img.attribute('hidden', '', imageReady);
}

function setup() {
  noCanvas();
}

function start(dirname) {
  appendImages(dirname);
}

function imgCreate() {
  img = createImg(allImages[0], imageReady);
  img.attribute('hidden', '', imageReady)
}

//Дает прогноз когда картинка загружена
function imageReady() {
  classifier.predict(img.elt, 10, gotResult);
}

function savePredictions() {
  predictionsJSON = {
    "predictions": predictions
  }
  //saveJSON(predictionsJSON, 'predictions.json');
}

function printJson(){
  let result = []
  for (i = 0; i < allImages.length; i++){
    result.push (
        {
          image: allImages[i],
          text: texts[i]
        }
    )
  }
  let json = JSON.stringify(result);
  sendJson(json)
}

function sendJson(json) {

  let body = "json="+json
  let request = new XMLHttpRequest();
  request.open("POST", "worker.php");
  request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  request.onreadystatechange = function () {
    if (request.readyState === 4 && request.status === 200)
      document.getElementById("output").innerHTML=request.responseText;
      select('.progress-bar').attribute('style', 'width: 100%');
    select('#dropzone').html('Готово')
  }
  request.send(body);

}

function removeImage() {
  currentIndex++;
  if (currentIndex <= allImages.length - 1) {
    drawNextImage();
    select('#dropzone').html('Обработка: '+allImages[currentIndex])
    let percent = (currentIndex/allImages.length)*100;
    select('.progress-bar').attribute('style', 'width: '+ percent+'%');
  } else {
    savePredictions();
    printJson();
    select('#dropzone').html('Мемы готовятся к показу')
  }
}

// Когда получаем результат
function gotResult(results) {
  information = {
    "name": allImages[currentIndex],
    "result": results,
  }
  predictions.push(information);
  select('#result').html(results[0].label);
  setTimeout(removeImage, 0);
  texts.push(results[0].label)
}
