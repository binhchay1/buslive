@extends('layouts.admin')

@section('content')

<div class="alert alert-danger">
<h1>Tính năng đang được phát triển!</h1>
</div>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Quản lí vị trí xe</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.9&sensor=false" type="text/javascript"></script>
        <script type="text/javascript">
        // check DOM Ready
        $(document).ready(function() {
            // execute
            (function() {
                // map options
                var options = {
                    zoom: 9,
                    center: new google.maps.LatLng(22.102521, 105.849998), // centered VN
                    mapTypeId: google.maps.MapTypeId.roadmap,
                    mapTypeControl: false
                };

                // init map
                var map = new google.maps.Map(document.getElementById('map_canvas'), options);

                // Ha Giang and Ha Noi sample Lat / Lng
                var southWest = new google.maps.LatLng(22.803696407221466, 104.98804344503165);  
                var northEast = new google.maps.LatLng(21.028023688228952, 105.8328430797276);
                var lngSpan = northEast.lng() - southWest.lng();
                var latSpan = northEast.lat() - southWest.lat();

                // set multiple marker
                var listCar = ["xe 1 ","xe 2","xe 3","xe 4","xe 5","xe 6"]; //set list of cars wil be random on map from db
                var data = @json($data);

                for (var i = 0; i < data.length; i++) {
                    // init markers
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(southWest.lat() + latSpan * Math.random(), southWest.lng() + lngSpan * Math.random()),
                        map: map,
                        title: 'Xem xe '
                    });

                    // process multiple info windows
                    (function(marker, i) {
                        // add click event
                        google.maps.event.addListener(marker, 'click', function() {
                            infowindow = new google.maps.InfoWindow({
                                content: data[i].name
                            });
                            infowindow.open(map, marker);
                        });
                    })(marker, i);
                }
            })();
        });
        </script>   
    </head>
    <body>
        <div id="map_canvas" style="width: 1600px; height:700px; margin-top: 2%; margin-left: 1%"></div>
    </body>
</html>
@endsection