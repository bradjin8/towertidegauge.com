@extends('layouts.guest')

@section('style')
    <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet"/>
    <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css"/>
    <style>
        .anychart-credits {
            display: none !important;
        }

        body {
            overflow-y: auto;
        }

        #tidehistory, #PredictionsTable {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 w-full h-full p-2 ">
        <div class="rounded-md bg-white p-2 h-screen w-full">
            <div class="font-bold text-2xl text-center">{{$tide->_loc}}, {{$tide->_country}}</div>
            <div class="text-md text-gray-500 text-center" id="CurrentTideTime">Thursday 10 May 2020</div>
            <div
                class="mt-2 text-6xl rounded-lg text-indigo-400 w-full h-3/5">
                <div id="wind_chart" class="max-h-screen h-full"></div>
            </div>
            <div class="flex flex-row justify-around mt-6">
                <div class="flex flex-col items-center">
                    <img src="{{asset('img/temperature.png')}}" class="w-12 h-12" alt="temperature"/>
                    <div class="font-medium text-sm md:text-lg">Temperature</div>
                    <div class="text-sm text-gray-500 md:text-lg" id="temperature"></div>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{asset('img/humidity.png')}}" class="w-12 h-12" alt="temperature"/>
                    <div class="font-medium text-sm md:text-lg">Humidity</div>
                    <div class="text-sm text-gray-500 md:text-lg" id="humidity"></div>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{asset('img/pressure.png')}}" class="w-12 h-12" alt="temperature"/>
                    <div class="font-medium text-sm md:text-lg">Pressure</div>
                    <div class="text-sm text-gray-500 md:text-lg" id="pressure"></div>
                </div>
            </div>
        </div>
        <div class="col-span-2 grid grid-cols-2 md:flex-row gap-2 w-full">
            <div class="bg-white rounded p-4 w-full ">
                <div class="Readings" id="Readings"></div>
                <div id="CurrentTideTime"></div>
                <div id="CurrentTideValue"></div>
                <a class="history" id="tidehistory" onclick="ShowHistory()">History ▼</a>
                <canvas class="TideChart" id="TideChart"></canvas>
                <div class="flex justify-center" id="TideTableContainer">
                    <table id="table_history"></table>
                </div>
            </div>
            <div class="flex flex-col bg-white rounded p-4 w-full ">
                <span class="Readings" id="Predictions"></span>
                <a class="history" id="PredictionsTable" onclick="ShowPrediction()">Predictions ▼</a>
                <canvas class="TideChart" id="PredictedTideChart"></canvas>
                <div class="flex justify-center" id="PredictionTableContainer">
                    <table id="table_prediction"></table>
                </div>
            </div>
        </div>
    </div>
    <div class="h-2"></div>
@endsection

@section('script')
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-circular-gauge.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/themes/monochrome.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
    <script>
        let sn = '{{$tide->_serial}}';
        let recordedTidesAddress = '{{url('/api/tidesBySerial')}}/{{$tide->_serial}}';

    </script>
    <script src="{{asset('js/widget.js')}}"></script>
    <script>
        $(document).ready(function () {
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
                            direction + ' °C' +
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

            $.get('{{url('/api/weatherdata/serial/')}}/{{$tide->_serial}}', null, function (data, status) {
                console.log({data, status});
                if (data && data.items && data.items.length > 0) {
                    $('#temperature').text(`${data.items[0].temperature} °C`);
                    $('#pressure').text(`${data.items[0].pressure} mB`);
                    $('#humidity').text(`${data.items[0].humidity} %`);
                    $('#wind_speed').text(`${data.items[0].wind_speed} kts`);
                    drawWindDirectionChart(data.items[0].wind_direction, data.items[0].wind_speed);
                }
            });
        });
    </script>
@endsection
