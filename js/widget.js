let readings;
let lat, lon, nm, tide, units, time
let predictedTidesAddress;
let readingsCount = 0;
let historyTable, predictionTable;

let TideHistory = "";
let PredictedTideReadings = [], PredictedTideTimes = [], PredictedTideDates = [];
Chart.defaults.elements.bar.borderWidth = 10;

$(document).ready(function () {
    document.getElementById("TideTableContainer").style.display = "none";
    document.getElementById("PredictionTableContainer").style.display = "none";

    setTimeout(function () {
        window.location.reload(true);
    }, 600000);

    GetTideGaugeData();
});

function BuildTextFile() {
    let dataString = "DATE,TIME,TIDE\n";
    dataString = dataString.concat(TideHistory)
    saveFile(readings)
}

async function saveFile(text) {

    let tidesoutput = [];
    const opts = {
        types: [
            {
                description: ".csv file",
                accept: {"text/plain": [".csv"]},
            },
        ],
    };
    let output = "_header,_serial,_country,_loc,_lat,_lon,_date,_time,_tide,_units\n";
    try {
        for (let index = 0; index < text.length; index++) {
            const element = text[index];

            element["_units"] = element["_units"].charAt(0);

            output += "$TIDE," +
                element["_serial"] + "," +
                element["_country"] + "," +
                element["_loc"] + "," +
                element["_lat"] + "," +
                element["_lon"] + "," +
                element["_date"] + "," +
                element["_time"] + "," +
                element["_tide"] + "," +
                element["_units"] + "\n";
        }

        // create a new handle
        const newHandle = await window.showSaveFilePicker(opts);
        // create a FileSystemWritableFileStream to write to
        const writableStream = await newHandle.createWritable();
        // write our file
        await writableStream.write(output);
        // close the file and write the contents to disk.
        await writableStream.close();
    } catch (err) {
        console.error(err.name, err.message);
    }
}

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
            {title: 'Tide'},
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
            {title: 'Tide'},
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
                    label: 'Tide Readings',
                    backgroundColor: 'blue',
                    borderColor: 'black',
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
                    label: 'Predicted',
                    backgroundColor: 'lightblue',
                    borderColor: 'black',
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
