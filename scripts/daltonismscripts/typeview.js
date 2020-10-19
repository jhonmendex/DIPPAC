var Deutaronapia = $("#deutaronapia").val();
var deutoronomalia = $("#deutoronomalia").val();
var protanomalia = $("#protanomalia").val();
var protanopia = $("#protanopia").val();
var tritanomalia = $("#tritanomalia").val();
var tritanopia = $("#tritanopia").val();
var normal = $("#normal").val();
var total = parseInt(Deutaronapia) + parseInt(deutoronomalia) + parseInt(protanomalia)
    + parseInt(protanopia) + parseInt(tritanomalia) + parseInt(tritanopia) + parseInt(normal);

var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Deutaronapia', 'Deutoronomalia',
            'Protanomalia', 'Protanopia', 'Trtianomalia', 'Tritanopia', 'Normal'],
        datasets: [{
            label: 'Cantidad',
            data: [Deutaronapia, deutoronomalia, protanomalia,
                protanopia, tritanomalia, tritanopia, normal],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {

        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        title: {
            display: true,
            text: 'Cantidad por tipo'
        }
    }
});
new Chart(document.getElementById("doughnut-chart"), {
    type: 'doughnut',
    data: {
        labels: ['Deutaronapia', 'Deutoronomalia',
            'Protanomalia', 'Protanopia', 'Trtianomalia', 'Tritanopia', 'Normal'],
        datasets: [
            {
                label: "Porcentaje por tipo",
                backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850", "#c20a47", "#2434ed"],
                data: [Math.round((Deutaronapia / total) * 100), Math.round((deutoronomalia / total) * 100),
                Math.round((protanomalia / total) * 100), Math.round((protanopia / total) * 100),
                Math.round((tritanomalia / total) * 100), Math.round((tritanopia / total) * 100),
                Math.round((normal / total) * 100)]
            }
        ]

    },
    options: {
        title: {
            display: true,
            text: 'Porcentaje por tipo'
        }
    }
});