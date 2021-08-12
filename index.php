<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>7Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" />
    <!-- <link rel="stylesheet" href="assets/css/leaflet.css" /> -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
    <!-- <script src="assets/js/leaflet.js"></script> -->
</head>

<body>
    <div class="main">
        <div class="head">
            <input type="text" id="search" placeholder="دنبال کجا میگردی؟">
        </div>
        <div class="mapContainer">
            <div id="mapid"></div>
        </div>
    </div>
    <script>
        var mymap = L.map('mapid').setView([29.580,52.527], 15);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: 'Pouya <a href="https://github.com/pouya-parsaei">GitHub</a> PouyaMap ',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);

         document.getElementById('mapid').style.setProperty('height',window.innerHeight+'px') 
    </script>
</body>

</html>