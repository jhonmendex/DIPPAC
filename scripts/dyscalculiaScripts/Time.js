$(document).ready(function() {

  var time = 0; /* how long the timer runs for */
  var initialOffset = "440";
  var i = 15;
  var interval = setInterval(function () {
    $(".circle_animation").css(
      "stroke-dashoffset",
      initialOffset - i * (initialOffset / time)
    );
    $("h5").text(i + " seg.");
    if (i == time) {
      clearInterval(interval);
      $("#continue").removeClass('disable-links');
      $("#continue")[0].click();
    }
    i--;
  }, 500);

})
