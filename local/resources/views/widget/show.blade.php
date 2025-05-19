@extends('layouts.public')

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
    <div class="grid grid-cols-1 md:grid-cols-3 md:gap-2 w-full h-full p-2 ">
        <div class="rounded-md bg-white p-2 h-screen w-full">
            <div class="flex md:hidden text-3xl font-bold justify-center mt-2">Station: {{$tide->_serial}}</div>
            <div class="font-bold text-xl text-center">{{$tide->_loc}}, {{$tide->_country}}</div>
            <div class="text-md text-gray-500 text-center w-4/5 m-auto" id="CurrentTide">
                Current tide reading at {{$recent->_date}} {{$recent->_time}} <span
                    class="font-bold underline">{{$recent->_tide}} {{$recent->_units}}</span>
            </div>
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
        <div class="col-span-2 grid grid-cols-1 md:flex-row gap-2 w-full">
            <div class="flex flex-col gap-2">
                <div class="hidden md:flex bg-white rounded p-4 h-12 text-lg font-bold">
                    Station: {{$tide->_serial}}</div>
                <div class="grid grid-cols-1 md:grid-cols-2 md:flex-row gap-2 w-full mt-2 md:mt-0">
                    <div class="bg-white rounded p-4 w-full ">
                        <div class="Readings" id="Readings"></div>
                        <div id="CurrentTideTime"></div>
                        <div id="CurrentTideValue"></div>
                        <a class="history text-lg" id="tidehistory" onclick="ShowHistory()">History ▼</a>
                        <canvas class="TideChart" id="TideChart"></canvas>
                        <div class="flex justify-center" id="TideTableContainer">
                            <table id="table_history"></table>
                        </div>
                    </div>
                    <div class="flex flex-col bg-white rounded p-4 w-full ">
                        <span class="Readings" id="Predictions"></span>
                        <a class="history text-lg" id="PredictionsTable" onclick="ShowPrediction()">Predictions ▼</a>
                        <canvas class="TideChart" id="PredictedTideChart"></canvas>
                        <div class="flex justify-center" id="PredictionTableContainer">
                            <table id="table_prediction"></table>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 md:flex-row gap-2 w-full">
                    <div class="flex flex-col bg-white rounded p-4 w-full ">
                        <span class="text-lg cursor-pointer" id="temperature_title" onclick="toggleTemperature()">Temperature ▼</span>
                        <canvas class="TideChart" id="temperature_chart"></canvas>
                        <div class="flex justify-center" id="temperature_table_container">
                            <table id="temperature_table"></table>
                        </div>
                    </div>

                    <div class="flex flex-col bg-white rounded p-4 w-full ">
                        <span class="text-lg cursor-pointer" id="humidity_title"
                              onclick="toggleHumidity()">Humidity ▼</span>
                        <canvas class="TideChart" id="humidity_chart"></canvas>
                        <div class="flex justify-center" id="humidity_table_container">
                            <table id="humidity_table"></table>
                        </div>
                    </div>

                    <div class="flex flex-col bg-white rounded p-4 w-full ">
                        <span class="text-lg cursor-pointer" id="pressure_title"
                              onclick="togglePressure()">Pressure ▼</span>
                        <canvas class="TideChart" id="pressure_chart"></canvas>
                        <div class="flex justify-center" id="pressure_table_container">
                            <table id="pressure_table"></table>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 md:flex-row gap-2 w-full mb-2">

                    <div class="flex flex-col bg-white rounded p-4 w-full ">
                        <span class="text-lg cursor-pointer" id="wind_direction_title" onclick="toggleWindDirection()">Wind Direction ▼</span>
                        <canvas class="TideChart" id="wind_direction_chart"></canvas>
                        <div class="flex justify-center" id="wind_direction_table_container">
                            <table id="wind_direction_table"></table>
                        </div>
                    </div>

                    <div class="flex flex-col bg-white rounded p-4 w-full ">
                        <span class="text-lg cursor-pointer" id="wind_speed_title" onclick="toggleWindSpeed()">Wind Speed ▼</span>
                        <canvas class="TideChart" id="wind_speed_chart"></canvas>
                        <div class="flex justify-center" id="wind_speed_table_container">
                            <table id="wind_speed_table"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="h-4"></div>
@endsection

@section('script')
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-circular-gauge.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/themes/monochrome.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
    <script>
        let sn = '{{$tide->_serial}}';
        let recordedTidesAddress = '{{url('/api/tidesBySerial')}}/{{$tide->_serial}}';

    </script>
    <script src="{{asset('js/home.js')}}"></script>
    <script src="{{asset('js/widget.js')}}"></script>
    <script>
        $(document).ready(function () {
            $.get('{{url('/api/weatherdata/serial/')}}/{{$tide->_serial}}', null, function (data, status) {
                // console.log({data, status});
                if (data && data.items && data.items.length > 0) {
                    $('#temperature').text(`${data.items[0].temperature} °C`);
                    $('#pressure').text(`${data.items[0].pressure} mB`);
                    $('#humidity').text(`${data.items[0].humidity} %`);
                    $('#wind_speed').text(`${data.items[0].wind_speed} kts`);

                    drawWindDirectionChart(data.items[0].wind_direction, data.items[0].wind_speed);
                    drawWindCharts(data.items);
                }
            });
        });
    </script>
@endsection
