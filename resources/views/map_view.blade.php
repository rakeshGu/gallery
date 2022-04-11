@extends('layouts.layout')
@section('title','Map')
@section('content') 
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center m-5">View in Map</h2>
        </div>
        <div class="col-md-12">
            <div id="map"></div>
        </div>
    </div>
</div>
@endsection
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBMKGqjpO7UFH6bDyD3WJhbP3EgyazBMY"></script>
<script>
var myCenter = new google.maps.LatLng(<?php echo $imgLat; ?>, <?php echo $imgLng; ?>);
function initialize(){
    var mapProp = {
        center:myCenter,
        zoom:10,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("map"),mapProp);

    var marker = new google.maps.Marker({
        position:myCenter,
        animation:google.maps.Animation.BOUNCE
    });

    marker.setMap(map);
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>