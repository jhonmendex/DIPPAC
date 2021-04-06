var Deutaronapia6 = $("#deutaronapia6").val();
var deutoronomalia6 = $("#deutoronomalia6").val();
var protanomalia6 = $("#protanomalia6").val();
var protanopia6 = $("#protanopia6").val();
var tritanomalia6 = $("#tritanomalia6").val();
var tritanopia6 = $("#tritanopia6").val();
var normal6 = $("#normal6").val();
var Deutaronapia7 = $("#deutaronapia7").val();
var deutoronomalia7 = $("#deutoronomalia7").val();
var protanomalia7 = $("#protanomalia7").val();
var protanopia7 = $("#protanopia7").val();
var tritanomalia7 = $("#tritanomalia7").val();
var tritanopia7 = $("#tritanopia7").val();
var normal7 = $("#normal7").val();
var Deutaronapia8 = $("#deutaronapia8").val();
var deutoronomalia8 = $("#deutoronomalia8").val();
var protanomalia8 = $("#protanomalia8").val();
var protanopia8 = $("#protanopia8").val();
var tritanomalia8 = $("#tritanomalia8").val();
var tritanopia8 = $("#tritanopia8").val();
var normal8 = $("#normal8").val();
var Deutaronapia9 = $("#deutaronapia9").val();
var deutoronomalia9 = $("#deutoronomalia9").val();
var protanomalia9 = $("#protanomalia9").val();
var protanopia9 = $("#protanopia9").val();
var tritanomalia9 = $("#tritanomalia9").val();
var tritanopia9 = $("#tritanopia9").val();
var normal9 = $("#normal9").val();

console.log(normal6);



new Chart(document.getElementById("bar-chart-grouped"), {
    type: 'bar',
    data: {
        labels: ["6 años", "7 años", "8 años", "9 años"],
        datasets: [
            {
                label: "Deutaronapia",
                backgroundColor: "#3e95cd",
                data: [Deutaronapia6, Deutaronapia7, Deutaronapia8, Deutaronapia9]
            }, {
                label: "Deutoronomalia",
                backgroundColor: "#8e5ea2",
                data: [deutoronomalia6, deutoronomalia7, deutoronomalia8, deutoronomalia9]
            },
            {
                label: "Protanomalia",
                backgroundColor: "#ebc034",
                data: [protanomalia6, protanomalia7, protanomalia8, protanomalia9]
            }, {
                label: "Protanopia",
                backgroundColor: "#32c27c",
                data: [protanopia6, protanopia7, protanopia8, protanopia9]
            },
            {
                label: "Tritanomalia",
                backgroundColor: "#2434ed",
                data: [tritanomalia6, tritanomalia7, tritanomalia8, tritanomalia9]
            }, {
                label: "Tritanopia",
                backgroundColor: "#c20a47",
                data: [tritanopia6, tritanopia7, tritanopia8, tritanopia9]
            },
            {
                label: "Normal",
                backgroundColor: "#4aed93",
                data: [normal6, normal7, normal8, normal9]
            }
        ]
    },
    options: {
        title: {
            display: true,
            text: 'Datos por edades'
        }
    }
});