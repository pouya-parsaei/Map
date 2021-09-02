<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>7Map</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

</head>

<body>
    <div class="main">

        <div class="modal-overlay" style="display: none;">
            <div class="modal">
                <span class="close">x</span>
                <h3 class="modal-title">ثبت لوکیشن</h3>
                <div class="modal-content">
                    <form id='addLocationForm' action="<?= site_url('process/addLocation.php') ?>" method="post">
                        <div class="field-row">
                            <div class="field-title">مختصات</div>
                            <div class="field-content">
                                <input type="text" name='lat' id="lat-display" readonly style="width: 160px;text-align: center;">
                                <input type="text" name='lng' id="lng-display" readonly style="width: 160px;text-align: center;">
                            </div>
                        </div>
                        <div class="field-row">
                            <div class="field-title">نام مکان</div>
                            <div class="field-content">
                                <input type="text" name="title" id='l-title' placeholder="مثلا: کافی نت پردیس">
                            </div>
                        </div>
                        <div class="field-row">
                            <div class="field-title">نوع</div>
                            <div class="field-content">

                                <select name="type" id='l-type'>
                                    <?php foreach (locationTypes as $key => $value) : ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="field-row">
                            <div class="field-title">ذخیره نهایی</div>
                            <div class="field-content">
                                <input type="submit" value=" ثبت ">
                            </div>
                        </div>
                        <div class="ajax-result"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="head">
            <div class="search-box">
                <input type="text" id="search" placeholder="دنبال کجا می گردی؟" autocomplete="off">
                <div class="clear"></div>
                <div class="search-results" style="display: none">

                </div>

            </div>
        </div>
        <div class="mapContainer">
            <div id="mapid"></div>
        </div>
        
        <img src="assets/img/current.png" class="currentLoc">
    </div>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script> -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="assets/js/scripts.js"></script>
    <script>
        <?php if ($location) : ?>
            L.marker([<?= $location->lat ?>, <?= $location->lng ?>]).addTo(mymap).bindPopup("<?= $location->title ?>").openPopup();
        <?php endif; ?>

        $(document).ready(function() {
            $('img.currentLoc').click(function() {
                locate();

            });
            $('img.gas-stations').click(function() {
                locate();

            });
            $('#search').keyup(function() {
                const input = $(this);
                const searchresult = $('.search-results');
                searchresult.html('در حال جستجو...')
                $.ajax({
                    url: '<?= BASE_URL . 'process/search.php' ?>',
                    method: 'POST',
                    data: {
                        keyword: input.val()
                    },
                    success: function(response) {
                        searchresult.slideDown().html(response);
                    }
                })
            })
            // Use Map Events
            mymap.on('zoomend', function() {
                // 1 : get bound lines
                var northLine = mymap.getBounds().getNorth();
                var westLine = mymap.getBounds().getWest();
                var southLine = mymap.getBounds().getSouth();
                var eastLine = mymap.getBounds().getEast();
                // 2 : send bound lines to server

                $.ajax({
                    url: 'http://7learn.php/09-7Map/process/showLocationsInWindow.php',
                    method: 'post',
                    data: {
                        north: northLine,
                        west: westLine,
                        south: southLine,
                        east: eastLine,
                    },
                    success: function(response) {
                        // 3 : search locations in map windows (done)
                        // 4 : display location markers in map
                        var returnedLocations = JSON.parse(response);
                        Object.keys(returnedLocations).forEach(function(key, index) {
                            locationInWindow = [this[key].lat, [this[key].lng]];
                            L.marker(locationInWindow).addTo(mymap);
                        }, returnedLocations);
                    }
                });


            });
             mymap.on('moveend', function() {

                // 1 : get bound lines
                var northLine = mymap.getBounds().getNorth();
                var westLine = mymap.getBounds().getWest();
                var southLine = mymap.getBounds().getSouth();
                var eastLine = mymap.getBounds().getEast();
                // 2 : send bound lines to server

                $.ajax({
                    url: 'http://7learn.php/09-7Map/process/showLocationsInWindow.php',
                    method: 'post',
                    data: {
                        north: northLine,
                        west: westLine,
                        south: southLine,
                        east: eastLine,
                    },
                    success: function(response) {
                        // 3 : search locations in map windows (done)
                        // 4 : display location markers in map
                        var returnedLocations = JSON.parse(response);
                        Object.keys(returnedLocations).forEach(function(key, index) {
                            locationInWindow = [this[key].lat, [this[key].lng]];
                            L.marker(locationInWindow).addTo(mymap);
                        }, returnedLocations);
                    }
                });
            }); 
        })
    </script>
</body>


</html>