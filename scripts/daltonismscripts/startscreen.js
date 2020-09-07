
var contador = 0;
var deunapiacontador = 0;
var protnapiaContador = 0;
var tritanomaliaContador = 0;
var tritanopiaContador = 0;
var deumaliaContador = 0;
var protanomaliaContador = 0;
var normalContador = 0;
var positionsButtons = {
  "positions": [
    { "top": "35%", "left": "6%" },
    { "top": "35%", "left": "50%" },
    { "top": "35%", "left": "80%" },
    { "top": "70%", "left": "6%" },
    { "top": "70%", "left": "50%" },
    { "top": "70%", "left": "80%" },
    { "top": "50%", "left": "28%" },
  ]
}
var imagesdeunapiaButton = {
  "Imagenes": [
    { "url": "url(css/daltonismcss/images/Deutaronapia/Pajaro.png)" },
    { "url": "url(css/daltonismcss/images/Deutaronapia/Serpiente.png)" }
  ]
}

function endGame(x) {
  if (x == 20) {
    console.log("fin del juego");
    window.open("index.php?controlador=Daltonism&accion=endGameScreen", "_self");
  };

}

$(function () {
  $("#startbutton").on('click', function (event) {
    window.open('index.php?controlador=Daltonism&accion=gameScreen', '_blank', "fullscreen=yes");
  });

});


$(function () {

  var deunapiaButton = document.getElementById("deunapiaButton");
  var protnapiaButton = document.getElementById("protnapiaButton");
  var tritanopiaButton = document.getElementById("tritanopiaButton");
  var deumaliaButton = document.getElementById("deumaliaButton");
  var tritanomaliaButton = document.getElementById("tritanomaliaButton");
  var protanomaliaButton = document.getElementById("protanomaliaButton");
  var normalButton = document.getElementById("normalButton");

  function randomPosition() {
    var myArray = ['0', '1', '2', '3', '4', '5', '6'];
    var i, j, k;
    for (i = myArray.length; i; i--) {
      j = Math.floor(Math.random() * i);
      k = myArray[i - 1];
      myArray[i - 1] = myArray[j];
      myArray[j] = k;
    };
    deunapiaButton.style.top = positionsButtons.positions[myArray[0]].top;
    deunapiaButton.style.left = positionsButtons.positions[myArray[0]].left;
    protnapiaButton.style.top = positionsButtons.positions[myArray[1]].top;
    protnapiaButton.style.left = positionsButtons.positions[myArray[1]].left;
    tritanopiaButton.style.top = positionsButtons.positions[myArray[2]].top;
    tritanopiaButton.style.left = positionsButtons.positions[myArray[2]].left;
    deumaliaButton.style.top = positionsButtons.positions[myArray[3]].top;
    deumaliaButton.style.left = positionsButtons.positions[myArray[3]].left;
    tritanomaliaButton.style.top = positionsButtons.positions[myArray[4]].top;
    tritanomaliaButton.style.left = positionsButtons.positions[myArray[4]].left;
    protanomaliaButton.style.top = positionsButtons.positions[myArray[5]].top;
    protanomaliaButton.style.left = positionsButtons.positions[myArray[5]].left;
    normalButton.style.top = positionsButtons.positions[myArray[6]].top;
    normalButton.style.left = positionsButtons.positions[myArray[6]].left;

  };

  $("#deunapiaButton").on('click', function (event) {
    //deunapiaButton.style.backgroundImage = imagesdeunapiaButton.Imagenes[contador].url;
    contador = contador + 1;
    deunapiacontador = deunapiacontador + 1;
    console.log("El contador es :" + " " + contador);
    console.log("El contador deunapia es :" + " " + deunapiacontador);
    endGame(contador);
    randomPosition();

  });
  $("#protnapiaButton").on('click', function (event) {
    contador = contador + 1;
    protnapiaContador = protnapiaContador + 1;
    console.log("El contador es :" + " " + contador);
    console.log("El contador protnapia es :" + " " + protnapiaContador);

  });
  $("#tritanopiaButton").on('click', function (event) {
    contador = contador + 1;
    tritanopiaContador = tritanopiaContador + 1;
    console.log("El contador es :" + " " + contador);
    console.log("El contador tritanopia es :" + " " + tritanopiaContador);
  });
  $("#deumaliaButton").on('click', function (event) {
    contador = contador + 1;
    deumaliaContador = deumaliaContador + 1;
    console.log("El contador es :" + " " + contador);
    console.log("El contador deumalia es :" + " " + deumaliaContador);
  });
  $("#tritanomaliaButton").on('click', function (event) {
    contador = contador + 1;
    tritanomaliaContador = tritanomaliaContador + 1;
    console.log("El contador es :" + " " + contador);
    console.log("El contador tritanomalia es :" + " " + tritanomaliaContador);
  });
  $("#protanomaliaButton").on('click', function (event) {
    contador = contador + 1;
    protanomaliaContador = protanomaliaContador + 1;
    console.log("El contador es :" + " " + contador);
    console.log("El contador protanomalia es :" + " " + protanomaliaContador);
  });
  $("#normalButton").on('click', function (event) {
    contador = contador + 1;
    normalContador = normalContador + 1;
    console.log("El contador es :" + " " + contador);
    console.log("El contador nromal es :" + " " + normalContador);
  });


});










