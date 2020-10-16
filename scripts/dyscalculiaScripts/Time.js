function Timer(inputTime) {
  var time = 0; /* how long the timer runs for */
  var initialOffset = "1000";
  var i = inputTime;
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
  }, 1000);

}
