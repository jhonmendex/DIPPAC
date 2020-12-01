

const barGraphicScored = (detailsParticipant) => {
    let valueScored = [];
    try {
        valueScored[0] = detailsParticipant.rfn004.score;
    } catch (error) {
        valueScored[0] = 0;
    }
    try {
        valueScored[1] = detailsParticipant.rfn005.correctAnswers;
    } catch (error) {
        valueScored[1] = 0;
    }
    try {
        valueScored[2] = detailsParticipant.rfn006.score;
    } catch (error) {
        valueScored[2] = 0;
    }
    try {
        valueScored[3] = detailsParticipant.rfn007.score;
    } catch (error) {
        valueScored[3] = 0;
    }
    try {
        valueScored[4] = detailsParticipant.rfn008.score;
    } catch (error) {
        valueScored[4] = 0;
    }
    try {
        valueScored[5] = detailsParticipant.rfn009.score;
    } catch (error) {
        valueScored[5] = 0;
    }
    let ctx = document.getElementById("barGraphicScored").getContext("2d");
    if (ctx) {
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Discriominacion-Fonologica', 'Ejecucion-Continua', 'Desicion-Lexica', 'Repeticion de Palabras', 'Consonantes', 'Inconcordancia-Gramatical'],
                datasets: [{
                    label: 'Puntaje Obtenido',
                    data: [valueScored[0],
                        valueScored[1],
                        valueScored[2],
                        valueScored[3],
                        valueScored[4],
                        valueScored[5]
                    ],
                    backgroundColor: [
                        'rgba(80, 236, 171, 0.2)',
                        'rgba(80, 236, 171, 0.2)',
                        'rgba(80, 236, 171, 0.2)',
                        'rgba(80, 236, 171, 0.2)',
                        'rgba(80, 236, 171, 0.2)',
                        'rgba(80, 236, 171, 0.2)',
                    ],
                    borderColor: [
                        'rgba(80, 236, 171, 1)',
                        'rgba(80, 236, 171, 1)',
                        'rgba(80, 236, 171, 1)',
                        'rgba(80, 236, 171, 1)',
                        'rgba(80, 236, 171, 1)',
                        'rgba(80, 236, 171, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        })
    }
}
const barGraphicTime = (detailsParticipant) => {
    let valueScored = [];
    try {
        valueScored[0] = Math.round(detailsParticipant.rfn004.time / 1000);
    } catch (error) {
        valueScored[0] = 0;
    }
    try {
        valueScored[1] = dMath.round(detailsParticipant.rfn005.time / 1000);
    } catch (error) {
        valueScored[1] = 0;
    }
    try {
        valueScored[2] = Math.round(detailsParticipant.rfn006.time / 1000);
    } catch (error) {
        valueScored[2] = 0;
    }
    try {
        valueScored[3] = Math.round(detailsParticipant.rfn007.time / 1000);
    } catch (error) {
        valueScored[3] = 0;
    }
    try {
        valueScored[4] = Math.round(detailsParticipant.rfn008.time / 1000);
    } catch (error) {
        valueScored[4] = 0;
    }
    try {
        valueScored[5] = Math.round(detailsParticipant.rfn009.time / 1000);
    } catch (error) {
        valueScored[5] = 0;
    }
    let ctx = document.getElementById("barGraphicTime").getContext("2d");
    if (ctx) {
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Discriominacion-Fonologica', 'Ejecucion-Continua', 'Desicion-Lexica', 'Repeticion de Palabras', 'Consonantes', 'Inconcordancia-Gramatical'],
                datasets: [{
                    label: 'Tiempo (segundos)',
                    data: [valueScored[0],
                        valueScored[1],
                        valueScored[2],
                        valueScored[3],
                        valueScored[4],
                        valueScored[5]
                    ],
                    backgroundColor: [
                        'rgba(80, 236, 171, 0.2)',
                        'rgba(80, 236, 171, 0.2)',
                        'rgba(80, 236, 171, 0.2)',
                        'rgba(80, 236, 171, 0.2)',
                        'rgba(80, 236, 171, 0.2)',
                        'rgba(80, 236, 171, 0.2)',
                    ],
                    borderColor: [
                        'rgba(80, 236, 171, 1)',
                        'rgba(80, 236, 171, 1)',
                        'rgba(80, 236, 171, 1)',
                        'rgba(80, 236, 171, 1)',
                        'rgba(80, 236, 171, 1)',
                        'rgba(80, 236, 171, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        })
    }
}

const mainDetail = (detailsParticipantJSON) => {

    windowsWith = window.screen.width;
    let sizeImg = document.getElementById("canvas");
    let valueHeight = percentageHeight(sizeImg);
    let valueWidth = percentageWidth(sizeImg);
    let date;
    try {
        date = detailsParticipantJSON.date.date + "/" + (detailsParticipantJSON.date.month + 1) + "/" + (detailsParticipantJSON.date.year + 1900)
    } catch (error) {
        date = "19/11/2020"
    };
    document.getElementById('detailUser').innerHTML = `
    <div class="card-full">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="text-center code">${detailsParticipantJSON.guardianUser}</h2>
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="col-5">
                    <p class="field">Nombre:</p>
                    <p class="value">${detailsParticipantJSON.name}</p>
                </div>
                <div class="col-6">
                    <p class="field">Telefono:</p>
                    <p class="value">${detailsParticipantJSON.telephone}</p>
                </div>
                <div class="col-1">
                    <p class="field">Edad:</p>
                    <p class="value">${detailsParticipantJSON.age}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <p class="field">Correo:</p>
                    <p class="value">${detailsParticipantJSON.email}</p>
                </div>
                <div class="col-5">
                    <p class="field">Grado:</p>
                    <p class="value">${detailsParticipantJSON.course}</p>
                </div>
                <div class="col-2">
                    <p class="field">Fecha:</p>
                    <p class="value">${date}</p>
                </div>
            </div>
        </div>
    </div>`

    const html = `
    <h2 class="text-center code">Puntaje Pruebas</h2>
    <canvas id="barGraphicScored" width="${windowsWith}" height="300"></canvas>
    <h2 class="text-center code">Tiempo usado en la prueba en segundos</h2>
    <canvas id="barGraphicTime" width="${windowsWith}" height="300"></canvas>
    `
    document.getElementById('main').insertAdjacentHTML('beforeend', html);
    document.getElementById('canvas').innerHTML = `<canvas id="mi_grafica" width="${sizeImg.clientWidth}" height="${sizeImg.clientHeight}"></canvas>`;
    console.log(sizeImg.clientWidth);
    console.log(sizeImg.clientHeight);
    let ctx = document.getElementById("mi_grafica").getContext("2d");
    let porcentageUsedWidth = (valueWidth * 0.58736059479553903345724907063197);
    let positioninitialX = valueWidth - porcentageUsedWidth;
    valueX = porcentageUsedWidth / 20;
    console.log(detailsParticipantJSON.course);
    var posicionesX = [
        (Math.round(positioninitialX + (valueX))),
        (Math.round(positioninitialX + (valueX * 3))),
        (Math.round(positioninitialX + (valueX * 5))),
        (Math.round(positioninitialX + (valueX * 7))),
        (Math.round(positioninitialX + (valueX * 9))),
        (Math.round(positioninitialX + (valueX * 11))),
        (Math.round(positioninitialX + (valueX * 13))),
        (Math.round(positioninitialX + (valueX * 15))),
        (Math.round(positioninitialX + (valueX * 17))),
        (Math.round(positioninitialX + (valueX * 19))),
    ];
    console.log(posicionesX);
    var positionReal = getRangeValuesSevenAge(detailsParticipantJSON);
    var puntos = [
        [
            [posicionesX[positionReal[0]], (Math.round(5 * valueHeight))],
            [posicionesX[positionReal[1]], (Math.round(12 * valueHeight))],
            [posicionesX[positionReal[2]], (Math.round(15 * valueHeight))],
            [posicionesX[positionReal[3]], (Math.round(17 * valueHeight))],
            [posicionesX[positionReal[4]], (Math.round(23 * valueHeight))],
            [posicionesX[positionReal[5]], (Math.round(25 * valueHeight))],
            [posicionesX[positionReal[6]], (Math.round(29 * valueHeight))],
            [posicionesX[positionReal[7]], (Math.round(35 * valueHeight))],
            [posicionesX[positionReal[8]], (Math.round(39 * valueHeight))]
        ]
    ];
    console.log(puntos);
    window.onload = draw(puntos, ctx);
}

const percentageWidth = (Element) => {
    let valueWidth = Element.clientWidth;
    return valueWidth;
}
const percentageHeight = (Element) => {
    let valueHeight = Element.clientHeight / 40;
    return valueHeight;
}

const draw = (puntos, ctx) => {
    if (ctx) {
        puntos.forEach((punto) => {
            ctx.beginPath();
            ctx.lineWidth = 3;
            ctx.moveTo(punto[0][0], punto[0][1]);
            ctx.strokeStyle = "red";

            for (let i = 1; i < punto.length; ++i) {

                //console.log(punto[i][0] + "__" + punto[i][1])
                ctx.lineTo(punto[i][0], punto[i][1]);
            }
            //ctx.stroke();
            //ctx.arc(punto[1][0], punto[1][1], 3, 0, (Math.PI / 180) * 180, true);
            //for (let i = 1; i < punto.length; ++i) {
            //  ctx.arc(punto[i][0], punto[i][1], 3, 0, (Math.PI / 180) * 180, true);
            //}
            ctx.stroke();
        });
    }
}
const getRangeValuesSevenAge = (detailsParticipant) => {
    //var detailsParticipant = JSON.parse(detailsParticipantJSON);
    let position = new Array(9);
    console.log("La edad es: " + detailsParticipant.age);
    if (detailsParticipant.age >= 6 && detailsParticipant.age <= 7) {
        var RangeValuesSevenAgeRFN004 = [
            [0, 18],
            [19, 19],
            [19, 19],
            [20, 20],
            [20, 20],
            [20, 20],
            [20, 20],
            [20, 20],
            [20, 20],
            [20, 200]
        ];
        var RangeValuesSevenAgeRFN0051 = [
            [0, 15],
            [16, 21],
            [22, 24],
            [25, 27],
            [28, 29],
            [30, 34],
            [35, 37],
            [38, 41],
            [42, 44],
            [45, 200]
        ];
        var RangeValuesSevenAgeRFN0052 = [
            [200, 57],
            [56, 48],
            [47, 39],
            [38, 28],
            [27, 21],
            [20, 13],
            [12, 9],
            [8, 6],
            [5, 3],
            [2, 0]
        ];
        var RangeValuesSevenAgeRFN0053 = [
            [200, 18],
            [17, 11],
            [10, 7],
            [6, 4],
            [3, 2],
            [1, 1],
            [0, 0],
            [0, 0],
            [0, 0],
            [0, 0]
        ];
        var RangeValuesSevenAgeRFN0061 = [
            [200000, 467],
            [466, 335],
            [334, 279],
            [278, 216],
            [215, 196],
            [195, 187],
            [186, 178],
            [177, 157],
            [156, 125],
            [124, 0]
        ];
        var RangeValuesSevenAgeRFN0062 = [
            [2000, 23],
            [22, 8],
            [7, 6],
            [5, 5],
            [5, 5],
            [4, 4],
            [3, 3],
            [2, 2],
            [1, 1],
            [1, 0]
        ];
        var RangeValuesSevenAgeRFN007 = [
            [0, 12],
            [13, 13],
            [14, 14],
            [14, 14],
            [15, 15],
            [15, 15],
            [15, 15],
            [15, 15],
            [15, 15],
            [15, 200]
        ];
        var RangeValuesSevenAgeRFN008 = [
            [0, 3],
            [4, 4],
            [4, 4],
            [4, 4],
            [4, 4],
            [4, 4],
            [4, 4],
            [5, 5],
            [5, 5],
            [6, 100]
        ];
        var RangeValuesSevenAgeRFN009 = [
            [0, 5],
            [6, 6],
            [7, 7],
            [7, 7],
            [8, 8],
            [8, 8],
            [9, 9],
            [10, 10],
            [10, 10],
            [10, 100]
        ];
        for (let i = 0; i < 10; i++) {
            //console.log(RangeValuesSevenAgeRFN004[i][0]);
            try {
                if (detailsParticipant.rfn004.score >= RangeValuesSevenAgeRFN004[i][0] &&
                    detailsParticipant.rfn004.score <= RangeValuesSevenAgeRFN004[i][1]) {
                    position[0] = i;
                }
            } catch (error) {
                position[0] = 0;
            }
            try {
                if (detailsParticipant.rfn005.correctAnswers >= RangeValuesSevenAgeRFN0051[i][0] &&
                    detailsParticipant.rfn005.correctAnswers <= RangeValuesSevenAgeRFN0051[i][1]) {
                    position[1] = i;
                }
            } catch (error) {
                position[1] = 0;
            }

            try {
                if (detailsParticipant.rfn005.omitedAnswers <= RangeValuesSevenAgeRFN0052[i][0] &&
                    detailsParticipant.rfn005.omitedAnswers >= RangeValuesSevenAgeRFN0052[i][1]) {
                    position[2] = i;
                }
            } catch (error) {
                position[2] = 0;
            }
            try {
                if (detailsParticipant.rfn005.wrongAnswers <= RangeValuesSevenAgeRFN0053[i][0] &&
                    detailsParticipant.rfn005.wrongAnswers >= RangeValuesSevenAgeRFN0053[i][1]) {
                    position[3] = i;
                }
            } catch (error) {
                position[3] = 0;
            }
            try {
                if ((detailsParticipant.rfn006.time) / 1000 <= RangeValuesSevenAgeRFN0061[i][0] &&
                    (detailsParticipant.rfn006.time) / 1000 >= RangeValuesSevenAgeRFN0061[i][1]) {
                    position[4] = i;
                }
            } catch (error) {
                position[4] = 0;
            }
            try {
                if (detailsParticipant.rfn006.score <= RangeValuesSevenAgeRFN0062[i][0] &&
                    detailsParticipant.rfn006.score >= RangeValuesSevenAgeRFN0062[i][1]) {
                    position[5] = i;
                }
            } catch (error) {
                position[5] = 0;
            }
            try {
                if (detailsParticipant.rfn007.score >= RangeValuesSevenAgeRFN007[i][0] &&
                    detailsParticipant.rfn007.score <= RangeValuesSevenAgeRFN007[i][1]) {
                    position[6] = i;
                }
            } catch (error) {
                position[6] = 0;
            }
            try {
                if (detailsParticipant.rfn008.score >= RangeValuesSevenAgeRFN008[i][0] &&
                    detailsParticipant.rfn008.score <= RangeValuesSevenAgeRFN008[i][1]) {
                    position[7] = i;
                }
            } catch (error) {
                position[7] = 0;
            }
            try {
                if (detailsParticipant.rfn009.score >= RangeValuesSevenAgeRFN009[i][0] &&
                    detailsParticipant.rfn009.score <= RangeValuesSevenAgeRFN009[i][1]) {
                    position[8] = i;
                }
            } catch (error) {
                position[8] = 0;
            }

        }

    }
    if (detailsParticipant.age == 8) {
        console.log("Entro a los 8 años")
        var RangeValuesEightAgeRFN004 = [
            [0, 18],
            [19, 19],
            [20, 20],
            [20, 20],
            [20, 20],
            [20, 20],
            [20, 20],
            [20, 20],
            [20, 20],
            [20, 200]
        ];
        var RangeValuesEightAgeRFN0051 = [
            [0, 22],
            [23, 28],
            [29, 30],
            [31, 34],
            [35, 35],
            [36, 39],
            [40, 43],
            [44, 49],
            [50, 52],
            [53, 200]
        ];
        var RangeValuesEightAgeRFN0052 = [
            [200, 48],
            [47, 38],
            [37, 29],
            [28, 21],
            [20, 14],
            [13, 9],
            [8, 8],
            [7, 6],
            [5, 4],
            [3, 0]
        ];
        var RangeValuesEightAgeRFN0053 = [
            [200, 17],
            [16, 6],
            [5, 3],
            [2, 2],
            [1, 1],
            [1, 1],
            [1, 1],
            [0, 0],
            [0, 0],
            [0, 0]
        ];
        var RangeValuesEightAgeRFN0061 = [
            [200000, 460],
            [459, 285],
            [284, 215],
            [214, 193],
            [192, 167],
            [166, 160],
            [159, 145],
            [144, 135],
            [134, 121],
            [120, 0]
        ];
        var RangeValuesEightAgeRFN0062 = [
            [2000, 23],
            [22, 8],
            [7, 6],
            [5, 5],
            [5, 5],
            [4, 4],
            [3, 3],
            [2, 2],
            [1, 1],
            [1, 0]
        ];
        var RangeValuesEightAgeRFN007 = [
            [0, 12],
            [13, 13],
            [14, 14],
            [14, 14],
            [15, 15],
            [15, 15],
            [15, 15],
            [15, 15],
            [15, 15],
            [15, 200]
        ];
        var RangeValuesEightAgeRFN008 = [
            [0, 3],
            [4, 4],
            [4, 4],
            [4, 4],
            [4, 4],
            [4, 4],
            [4, 4],
            [5, 5],
            [5, 5],
            [6, 100]
        ];
        var RangeValuesEightAgeRFN009 = [
            [0, 5],
            [6, 6],
            [7, 7],
            [7, 7],
            [8, 8],
            [8, 8],
            [9, 9],
            [10, 10],
            [10, 10],
            [10, 100]
        ];
        for (let i = 0; i < 10; i++) {
            try {
                if (detailsParticipant.rfn004.score >= RangeValuesEightAgeRFN004[i][0] &&
                    detailsParticipant.rfn004.score <= RangeValuesEightAgeRFN004[i][1]) {
                    position[0] = i;
                }
            } catch (error) {
                position[0] = 0;
            }
            try {
                if (detailsParticipant.rfn005.correctAnswers >= RangeValuesEightAgeRFN0051[i][0] &&
                    detailsParticipant.rfn005.correctAnswers <= RangeValuesEightAgeRFN0051[i][1]) {
                    position[1] = i;
                }
            } catch (error) {
                position[1] = 0;
            }
            try {
                if (detailsParticipant.rfn005.omitedAnswers <= RangeValuesEightAgeRFN0052[i][0] &&
                    detailsParticipant.rfn005.omitedAnswers >= RangeValuesEightAgeRFN0052[i][1]) {
                    position[2] = i;
                }
            } catch (error) {
                position[2] = 0;
            }
            try {
                if (detailsParticipant.rfn005.wrongAnswers <= RangeValuesEightAgeRFN0053[i][0] &&
                    detailsParticipant.rfn005.wrongAnswers >= RangeValuesEightAgeRFN0053[i][1]) {
                    position[3] = i;
                }
            } catch (error) {
                position[3] = 0;
            }
            try {
                if ((detailsParticipant.rfn006.time) / 1000 <= RangeValuesEightAgeRFN0061[i][0] &&
                    (detailsParticipant.rfn006.time) / 1000 >= RangeValuesEightAgeRFN0061[i][1]) {
                    position[4] = i;
                }
            } catch (error) {
                position[4] = 0;
            }
            try {
                if (detailsParticipant.rfn006.score <= RangeValuesEightAgeRFN0062[i][0] &&
                    detailsParticipant.rfn006.score >= RangeValuesEightAgeRFN0062[i][1]) {
                    position[5] = i;
                }
            } catch (error) {
                position[5] = 0;
            }
            try {
                if (detailsParticipant.rfn007.score >= RangeValuesEightAgeRFN007[i][0] &&
                    detailsParticipant.rfn007.score <= RangeValuesEightAgeRFN007[i][1]) {
                    position[6] = i;
                }
            } catch (error) {
                position[6] = 0;
            }
            try {
                if (detailsParticipant.rfn008.score >= RangeValuesEightAgeRFN008[i][0] &&
                    detailsParticipant.rfn008.score <= RangeValuesEightAgeRFN008[i][1]) {
                    position[7] = i;
                }
            } catch (error) {
                position[7] = 0;
            }
            try {
                if (detailsParticipant.rfn009.score >= RangeValuesEightAgeRFN009[i][0] &&
                    detailsParticipant.rfn009.score <= RangeValuesEightAgeRFN009[i][1]) {
                    position[8] = i;
                }
            } catch (error) {
                position[8] = 0;
            }
        }
    }
    if (detailsParticipant.age == 9) {
        var RangeValuesNightAgeRFN004 = [
            [0, 18],
            [19, 19],
            [19, 19],
            [20, 20],
            [20, 20],
            [20, 20],
            [20, 20],
            [20, 20],
            [20, 20],
            [20, 200]
        ];
        var RangeValuesNightAgeRFN0051 = [
            [0, 29],
            [30, 35],
            [36, 38],
            [39, 42],
            [43, 44],
            [45, 46],
            [47, 52],
            [53, 57],
            [58, 64],
            [65, 200]
        ];
        var RangeValuesNightAgeRFN0052 = [
            [200, 44],
            [43, 27],
            [26, 20],
            [28, 15],
            [20, 13],
            [13, 11],
            [8, 7],
            [7, 6],
            [5, 5],
            [3, 3]
        ];
        var RangeValuesNightAgeRFN0053 = [
            [200, 13],
            [16, 6],
            [5, 4],
            [3, 2],
            [2, 2],
            [1, 1],
            [1, 1],
            [0, 0],
            [0, 0],
            [0, 0]
        ];
        var RangeValuesNightAgeRFN0061 = [
            [200000, 278],
            [277, 216],
            [215, 184],
            [183, 157],
            [156, 140],
            [139, 127],
            [126, 120],
            [119, 109],
            [108, 100],
            [99, 0]
        ];
        var RangeValuesNightAgeRFN0062 = [
            [2000, 13],
            [12, 6],
            [5, 4],
            [3, 3],
            [2, 2],
            [1, 1],
            [1, 1],
            [0, 0],
            [0, 0],
            [0, 0]
        ];
        var RangeValuesNightAgeRFN007 = [
            [0, 13],
            [14, 14],
            [14, 14],
            [15, 15],
            [15, 15],
            [15, 15],
            [15, 15],
            [15, 15],
            [15, 15],
            [15, 200]
        ];
        var RangeValuesNightAgeRFN008 = [
            [0, 4],
            [4, 4],
            [4, 4],
            [4, 4],
            [4, 4],
            [4, 4],
            [4, 4],
            [5, 5],
            [6, 6],
            [6, 100]
        ];
        var RangeValuesNightAgeRFN009 = [
            [0, 6],
            [7, 7],
            [8, 8],
            [8, 8],
            [9, 9],
            [9, 9],
            [10, 10],
            [10, 10],
            [10, 10],
            [10, 100]
        ];
        for (let i = 0; i < 10; i++) {
            try {
                if (detailsParticipant.rfn004.score >= RangeValuesNightAgeRFN004[i][0] &&
                    detailsParticipant.rfn004.score <= RangeValuesNightAgeRFN004[i][1]) {
                    position[0] = i;
                }
            } catch (error) {
                position[0] = 0;
            }
            try {
                if (detailsParticipant.rfn005.correctAnswers >= RangeValuesNightAgeRFN0051[i][0] &&
                    detailsParticipant.rfn005.correctAnswers <= RangeValuesNightAgeRFN0051[i][1]) {
                    position[1] = i;
                }
            } catch (error) {
                position[1] = 0;
            }
            try {
                if (detailsParticipant.rfn005.omitedAnswers <= RangeValuesNightAgeRFN0052[i][0] &&
                    detailsParticipant.rfn005.omitedAnswers >= RangeValuesNightAgeRFN0052[i][1]) {
                    position[2] = i;
                }
            } catch (error) {
                position[2] = 0;
            }
            try {
                if (detailsParticipant.rfn005.wrongAnswers <= RangeValuesNightAgeRFN0053[i][0] &&
                    detailsParticipant.rfn005.wrongAnswers >= RangeValuesNightAgeRFN0053[i][1]) {
                    position[3] = i;
                }
            } catch (error) {
                position[3] = 0;
            }
            try {
                if ((detailsParticipant.rfn006.time) / 1000 <= RangeValuesNightAgeRFN0061[i][0] &&
                    (detailsParticipant.rfn006.time) / 1000 >= RangeValuesNightAgeRFN0061[i][1]) {
                    position[4] = i;
                }
            } catch (error) {
                position[4] = 0;
            }
            try {
                if (detailsParticipant.rfn006.score <= RangeValuesNightAgeRFN0062[i][0] &&
                    detailsParticipant.rfn006.score >= RangeValuesNightAgeRFN0062[i][1]) {
                    position[5] = i;
                }
            } catch (error) {
                position[5] = 0;
            }
            try {
                if (detailsParticipant.rfn007.score >= RangeValuesNightAgeRFN007[i][0] &&
                    detailsParticipant.rfn007.score <= RangeValuesNightAgeRFN007[i][1]) {
                    position[6] = i;
                }
            } catch (error) {
                position[6] = 0;
            }
            try {
                if (detailsParticipant.rfn008.score >= RangeValuesNightAgeRFN008[i][0] &&
                    detailsParticipant.rfn008.score <= RangeValuesNightAgeRFN008[i][1]) {
                    position[7] = i;
                }
            } catch (error) {
                position[7] = 0;
            }
            try {
                if (detailsParticipant.rfn009.score >= RangeValuesNightAgeRFN009[i][0] &&
                    detailsParticipant.rfn009.score <= RangeValuesNightAgeRFN009[i][1]) {
                    position[8] = i;
                }
            } catch (error) {
                position[8] = 0;
            }
        }
    }
    console.log("posiciones i")
        //for (let v; v < position.length; v++) {
    console.log(position);
    //}
    return position;
}