<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>Tide Data</title>
    <link rel="stylesheet" href="{{asset('css/tidegauge.css')}}">
</head>

<body id="mainBody">
<div class="header">
    <div class="header-left">
        <label onclick="BuildTextFile()" class="CurrentLocation" id="CurrentLocation"></label>
    </div>
    <div class="header-right">
        <a href="{{url('')}}"><img src="{{asset('img/tower.png')}}" height=35></a>
    </div>
</div>
<!--
<div class="map" id="map"></div>
-->
<span class="Readings" id="Readings">
        <div id="CurrentTideTime"></div>
        <div id="CurrentTideValue"></div>
        <a class="history" id="tidehistory" onclick="ShowHistory()">History ▼</a>
        <canvas class="TideChart" id="TideChart"></canvas>
        <span id="TideTable"></span>
    </span>
<span class="Readings" id="Predictions">
        <a class="history" id="PredictionsTable" onclick="ShowPrediction()">Predictions ▼</a>
        <canvas class="TideChart" id="PredictedTideChart"></canvas>
        <span id="TidePrediction"></span>
    </span>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{asset('js/tidegauge.js')}}"></script>
</body>
</html>
