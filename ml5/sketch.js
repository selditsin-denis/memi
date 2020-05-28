const classifier = new ml5.ImageClassifier('MobileNet');

let img;

function setup() {
  noCanvas();
  // Загрузка фотки
  img = createImg('images/doggo.jpg', imageReady);
}

function imageReady() {
  classifier.predict(img.elt, 10, gotResult);
}

function gotResult(results) {
  select('#result').html(results[0].label);
}
