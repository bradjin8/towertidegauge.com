@extends('layouts.public')

@section('content')
    <div class="map" id="map"></div>
@endsection

@section('script')
    <script src="{{asset('js/home.js')}}"></script>
@endsection
