let lat, lon, nm, tide, time
let predictedTidesAddress;
let readingsCount = 0;
let historyTable, predictionTable;

let PredictedTideReadings = [], PredictedTideTimes = [], PredictedTideDates = [];
Chart.defaults.elements.bar.borderWidth = 10;

$(document).ready(function () {
    document.getElementById("TideTableContainer").style.display = "none";
    document.getElementById("PredictionTableContainer").style.display = "none";
    document.getElementById("temperature_table_container").style.display = "none";
    document.getElementById("humidity_table_container").style.display = "none";
    document.getElementById("pressure_table_container").style.display = "none";
    document.getElementById("wind_direction_table_container").style.display = "none";
    document.getElementById("wind_speed_table_container").style.display = "none";


    setTimeout(function () {
        window.location.reload(true);
    }, 600000);

    GetTideGaugeData();
});

function GetTideGaugeData() {
    $.get(recordedTidesAddress, function (data) {
        if (data) {
            $('#table_history').html('');
            var items = data.items.map((it) => ({
                ...it,
                _serial: data.tideGauge._serial,
                _country: data.tideGauge._country,
                _loc: data.tideGauge._loc,
                _lat: data.tideGauge._lat,
                _lon: data.tideGauge._lon,
            }))
            BuildTideTable(items);
            BuildTideChart(data.items);
            GetPredictedTideGaugeData();
        }
    });
}

function GetPredictedTideGaugeData() {
    predictedTidesAddress =
        "https://www.worldtides.info/api/v3?datum=CD&Heights" +
        "&key=dd85c7e1-09ca-45df-9534-bc2ed8dcc9a7" +
        "&lat=" + lat +
        "&lon=" + lon +
        "&stationDistance=10" +
        "days=7";

    $.get(predictedTidesAddress, function (data, status) {
        if (data) {
            $("#table_prediction").html("");
            BuildPredictionTable(data.heights);
            BuildPredictedChart(data.heights);
            readingsCount = data.length;
        }
    });
}


function BuildTideTable(data) {
    historyTable = new DataTable('#table_history', {
        retrieve: true,
        paging: false,
        search: false,
        columns: [
            {title: 'Date'},
            {title: 'Time'},
            {title: 'Tide (m)'},
        ],
        data: data.map(it => ([it._date, it._time, it._tide + it._units])),
    })
}

function BuildPredictionTable(data) {
    predictionTable = $('#table_prediction').DataTable({
        retrieve: true,
        paging: false,
        search: false,
        columns: [
            {title: 'Date'},
            {title: 'Time'},
            {title: 'Tide (m)'},
        ],
        data: data.map(it => {
            const date = it.date.split('T')[0];

            const time = it.date.split('T')[1].split('+')[0];
            return [date, time, it.height];
        }),
    })
}

function BuildTideChart(data) {
    let ctx = document.getElementById('TideChart');
    window.chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(it => it._time),
            datasets: [
                {
                    label: 'Tide Readings (m)',
                    backgroundColor: 'blue',
                    borderColor: 'white',
                    data: data.map(it => it._tide),
                    fill: true,
                    borderWidth: 1
                }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: nm
            },
            tooltips: {
                mode: 'index',
                intersect: true,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }
        }
    });
}

function BuildPredictedChart(data) {
    data.map((it, id) => {
        let dt = it.date.split("T");
        let tm = dt[1].substring(0, dt[1].indexOf("+"));
        let md = it.date.substring(5, it.date.indexOf("T"))
        let combined = md + " " + tm;

        PredictedTideDates.push(combined);
        PredictedTideTimes.push(tm);
        PredictedTideReadings.push(parseFloat(it.height).toFixed(2));
    });

    let ptx = document.getElementById('PredictedTideChart');

    window.chart = new Chart(ptx, {
        type: 'line',
        data: {
            labels: PredictedTideDates,
            datasets: [
                {
                    label: 'Predicted (m)',
                    backgroundColor: 'lightblue',
                    borderColor: 'grey',
                    data: PredictedTideReadings,
                    fill: true,
                    borderWidth: 1
                }

            ]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: nm
            },
            tooltips: {
                mode: 'index',
                intersect: true,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
        }
    });
}

function ShowHistory() {
    if (document.getElementById("TideTableContainer").style.display == "none") {
        document.getElementById("TideTableContainer").style.display = "block";
        document.getElementById("tidehistory").innerHTML = "History ▲"

    } else {
        document.getElementById("TideTableContainer").style.display = "none";
        document.getElementById("tidehistory").innerHTML = "History ▼";
    }
}

function ShowPrediction() {
    if (document.getElementById("PredictionTableContainer").style.display == "none") {
        document.getElementById("PredictionTableContainer").style.display = "block";
        document.getElementById("PredictionsTable").innerHTML = "Predictions ▲";
    } else {
        document.getElementById("PredictionTableContainer").style.display = "none";
        document.getElementById("PredictionsTable").innerHTML = "Predictions ▼"
    }
    //▲ ▼
}

function drawWindDirectionChart(direction, speed) {
    anychart.onDocumentReady(function () {
        // set chart theme
        anychart.theme('monochrome');
        var gauge = anychart.gauges.circular();
        gauge
            .fill('#fff')
            .stroke(null)
            .padding(0)
            .margin(30)
            .startAngle(0)
            .sweepAngle(360);

        gauge
            .axis()
            .labels()
            .padding(3)
            .position('outside')
            .format('{%Value}\u00B0');

        gauge.data([direction, speed]);

        gauge
            .axis()
            .scale()
            .minimum(0)
            .maximum(360)
            .ticks({interval: 30})
            .minorTicks({interval: 10});

        gauge
            .axis()
            .fill('#7c868e')
            .startAngle(0)
            .sweepAngle(360)
            .width(1)
            .ticks({
                type: 'line',
                fill: '#7c868e',
                length: 4,
                position: 'outside'
            });

        gauge
            .axis(1)
            .fill('#7c868e')
            .startAngle(270)
            .radius(40)
            .sweepAngle(180)
            .width(1)
            .ticks({
                type: 'line',
                fill: '#7c868e',
                length: 4,
                position: 'outside'
            });

        gauge
            .axis(1)
            .labels()
            .padding(3)
            .position('outside')
            .format('{%Value} kts');

        gauge
            .axis(1)
            .scale()
            .minimum(0)
            .maximum(25)
            .ticks({interval: 5})
            .minorTicks({interval: 1});

        gauge.title().padding(0).margin([0, 0, 10, 0]);

        gauge
            .marker()
            .fill('#64b5f6')
            .stroke(null)
            .size('15%')
            .zIndex(120)
            .radius('97%');

        gauge
            .needle()
            .fill('#1976d2')
            .stroke(null)
            .axisIndex(1)
            .startRadius('6%')
            .endRadius('38%')
            .startWidth('2%')
            .middleWidth(null)
            .endWidth('0');

        gauge.cap().radius('4%').fill('#1976d2').enabled(true).stroke(null);

        var bigTooltipTitleSettings = {
            fontFamily: '\'Verdana\', Helvetica, Arial, sans-serif',
            fontWeight: 'normal',
            fontSize: '12px',
            hAlign: 'left',
            fontColor: '#212121'
        };

        gauge
            .label()
            .text(
                '<span style="color: #64B5F6; font-size: 14px">Wind Direction: </span>' +
                '<span style="color: #5AA3DD; font-size: 16px">' +
                direction + ' °' +
                // '\u00B0 (+/- 0.5\u00B0)' +
                '</span><br>' +
                '<span style="color: #1976d2; font-size: 14px">Wind Speed:</span> ' +
                '<span style="color: #166ABD; font-size: 16px">' +
                speed +
                ' kts</span>'
            )
            .useHtml(true)
            .textSettings(bigTooltipTitleSettings);
        gauge
            .label()
            .hAlign('center')
            .anchor('center-top')
            .offsetY(-20)
            .padding(15, 20)
            .background({
                fill: '#fff',
                stroke: {
                    thickness: 1,
                    color: '#E0F0FD'
                }
            });

        // set container id for the chart
        gauge.container('wind_chart');

        // initiate chart drawing
        gauge.draw();
    });
}

function drawWindCharts(items = []) {
    drawTemperatureChartAndTable(items);
    drawHumidityChartAndTable(items);
    drawPressureChartAndTable(items);
    drawWindSpeedChartAndTable(items);
    drawWindDirectionChartAndTable(items);
}

function drawTemperatureChartAndTable(data) {
    let ctx = document.getElementById('temperature_chart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(it => `${it.time.split(',')[0]} ${it.time.split(',')[1]}`),
            datasets: [
                {
                    label: 'Temperature (°C)',
                    backgroundColor: '#B3C100',
                    borderColor: 'grey',
                    data: data.map(it => parseFloat(it.temperature)),
                    fill: true,
                    borderWidth: 1
                }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: nm
            },
            tooltips: {
                mode: 'index',
                intersect: true,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }
        }
    });

    $('#temperature_table').DataTable({
        retrieve: true,
        paging: false,
        search: false,
        columns: [
            {title: 'Date'},
            {title: 'Time'},
            {title: 'Temperature (°C)'},
        ],
        data: data.map(it => {
            const date = it.time.split(',')[0];
            const time = it.time.split(',')[1];
            return [date, time, it.temperature];
        }),
    })
}
function toggleTemperature() {
    if (document.getElementById("temperature_table_container").style.display == "none") {
        document.getElementById("temperature_table_container").style.display = "block";
        document.getElementById("temperature_title").innerHTML = "Temperature ▲";
    } else {
        document.getElementById("temperature_table_container").style.display = "none";
        document.getElementById("temperature_title").innerHTML = "Temperature ▼"
    }
    //▲ ▼
}

function drawHumidityChartAndTable(data) {
    let ctx = document.getElementById('humidity_chart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(it => `${it.time.split(',')[0]} ${it.time.split(',')[1]}`),
            datasets: [
                {
                    label: 'Humidity (%)',
                    backgroundColor: '#488A99',
                    borderColor: 'grey',
                    data: data.map(it => parseFloat(it.humidity)),
                    fill: true,
                    borderWidth: 1
                }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: nm
            },
            tooltips: {
                mode: 'index',
                intersect: true,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }
        }
    });

    $('#humidity_table').DataTable({
        retrieve: true,
        paging: false,
        search: false,
        columns: [
            {title: 'Date'},
            {title: 'Time'},
            {title: 'Humidity (%)'},
        ],
        data: data.map(it => {
            const date = it.time.split(',')[0];
            const time = it.time.split(',')[1];
            return [date, time, it.humidity];
        }),
    })
}
function toggleHumidity() {
    if (document.getElementById("humidity_table_container").style.display == "none") {
        document.getElementById("humidity_table_container").style.display = "block";
        document.getElementById("humidity_title").innerHTML = "Humidity ▲";
    } else {
        document.getElementById("humidity_table_container").style.display = "none";
        document.getElementById("humidity_title").innerHTML = "Humidity ▼"
    }
    //▲ ▼
}

function drawPressureChartAndTable(data) {
    let ctx = document.getElementById('pressure_chart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(it => `${it.time.split(',')[0]} ${it.time.split(',')[1]}`),
            datasets: [
                {
                    label: 'Pressure (mB)',
                    backgroundColor: '#DBAE58',
                    borderColor: 'grey',
                    data: data.map(it => parseFloat(it.pressure)),
                    fill: true,
                    borderWidth: 1
                }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: nm
            },
            tooltips: {
                mode: 'index',
                intersect: true,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }
        }
    });

    $('#pressure_table').DataTable({
        retrieve: true,
        paging: false,
        search: false,
        columns: [
            {title: 'Date'},
            {title: 'Time'},
            {title: 'Pressure (mB)'},
        ],
        data: data.map(it => {
            const date = it.time.split(',')[0];
            const time = it.time.split(',')[1];
            return [date, time, it.pressure];
        }),
    })
}
function togglePressure() {
    if (document.getElementById("pressure_table_container").style.display == "none") {
        document.getElementById("pressure_table_container").style.display = "block";
        document.getElementById("pressure_title").innerHTML = "Pressure ▲";
    } else {
        document.getElementById("pressure_table_container").style.display = "none";
        document.getElementById("pressure_title").innerHTML = "Pressure ▼"
    }
    //▲ ▼
}

function drawWindDirectionChartAndTable(data) {
    let ctx = document.getElementById('wind_direction_chart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(it => `${it.time.split(',')[0]} ${it.time.split(',')[1]}`),
            datasets: [
                {
                    label: 'Wind Direction (°)',
                    backgroundColor: '#6AB187',
                    borderColor: 'grey',
                    data: data.map(it => parseFloat(it.wind_direction)),
                    fill: true,
                    borderWidth: 1
                }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: nm
            },
            tooltips: {
                mode: 'index',
                intersect: true,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }
        }
    });

    $('#wind_direction_table').DataTable({
        retrieve: true,
        paging: false,
        search: false,
        columns: [
            {title: 'Date'},
            {title: 'Time'},
            {title: 'Wind Direction (°)'},
        ],
        data: data.map(it => {
            const date = it.time.split(',')[0];
            const time = it.time.split(',')[1];
            return [date, time, it.humidity];
        }),
    })
}
function toggleWindDirection() {
    if (document.getElementById("wind_direction_table_container").style.display == "none") {
        document.getElementById("wind_direction_table_container").style.display = "block";
        document.getElementById("wind_direction_title").innerHTML = "Humidity ▲";
    } else {
        document.getElementById("wind_direction_table_container").style.display = "none";
        document.getElementById("wind_direction_title").innerHTML = "Humidity ▼"
    }
    //▲ ▼
}

function drawWindSpeedChartAndTable(data) {
    let ctx = document.getElementById('wind_speed_chart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(it => `${it.time.split(',')[0]} ${it.time.split(',')[1]}`),
            datasets: [
                {
                    label: 'Wind Speed (kts)',
                    backgroundColor: 'orange',
                    borderColor: '#4CB5F5,',
                    data: data.map(it => parseFloat(it.wind_speed)),
                    fill: true,
                    borderWidth: 1
                }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: nm
            },
            tooltips: {
                mode: 'index',
                intersect: true,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }
        }
    });

    $('#wind_speed_table').DataTable({
        retrieve: true,
        paging: false,
        search: false,
        columns: [
            {title: 'Date'},
            {title: 'Time'},
            {title: 'Wind Speed (kts)'},
        ],
        data: data.map(it => {
            const date = it.time.split(',')[0];
            const time = it.time.split(',')[1];
            return [date, time, it.wind_speed];
        }),
    })
}
function toggleWindSpeed() {
    if (document.getElementById("wind_speed_table_container").style.display == "none") {
        document.getElementById("wind_speed_table_container").style.display = "block";
        document.getElementById("wind_speed_title").innerHTML = "Wind Speed ▲";
    } else {
        document.getElementById("wind_speed_table_container").style.display = "none";
        document.getElementById("wind_speed_title").innerHTML = "Wind Speed ▼"
    }
    //▲ ▼
}
