$(document).ready(function () {
  var ctx = document.getElementById("spider");
  var data = {
    labels: ["English", "Maths", "Physics", "Chemistry", "Biology"],
    datasets: [
      {
        label: "Student A",
        backgroundColor: "rgba(200,0,0,0.2)",
        data: [0.5, 1, 0.3, 1, 0.7],
      },
    ],
  };
  var myRadarChart = new Chart(ctx, {
    type: "radar",
    data: data,
    options: {},
  });
});
