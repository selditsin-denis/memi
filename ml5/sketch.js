// Выгрузка ImageNet
const classifier = new ml5.ImageClassifier('MobileNet');

let img;
let currentIndex = 0;
let allImages = [];
let texts = []
let display = true;
let displayTime = 1;
let predictions = [];

function appendImages() {
  for (i = 0; i < data.images.length; i++) {
    imgPath = data.images[i];
    allImages.push(getImagePath(imgPath));
  }
}

function preload() {
  data = loadJSON('assets/data.json');
}

function getImagePath(imgPath) {
  fullPath = 'images/dataset/';
  fullPath = fullPath + imgPath;
  return fullPath
}

function drawNextImage() {
  img.attribute('src', allImages[currentIndex], imageReady);
}

function setup() {
  noCanvas();
  appendImages();
  img = createImg(allImages[0], imageReady);
}


//Дает прогноз когда картинка загружена
function imageReady() {
  classifier.predict(img.elt, 10, gotResult);
}

function savePredictions() {
  predictionsJSON = {
    "predictions": predictions
  }
  // saveJSON(predictionsJSON, 'predictions.json');
}

function printJson(){
  let result = []
  for (i = 0; i<allImages.length;i++){
    result.push(
        {
          image: allImages[i],
          text: texts[i]
        }
    )
  }
  var json = JSON.stringify(result);
  document.writeln(json)
}

function removeImage() {
  currentIndex++;
  if (currentIndex <= allImages.length - 1) {
    drawNextImage();
  } else {
    savePredictions();
    printJson();
  }
}

// Когда получаем результат
function gotResult(results) {
  information = {
    "name": allImages[currentIndex],
    "result": results,
  }
  predictions.push(information);

  if (display) {
    select('#result').html(results[0].label);
    setTimeout(removeImage, displayTime);
    texts.push(results[0].label)
  } else {
    removeImage();
  }
}
