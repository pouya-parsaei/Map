
    const defaultLocation = [29.580, 52.527];
    const defaultZoom = 15;
    var mymap = L.map('mapid').setView(defaultLocation, defaultZoom);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        attribution: 'Pouya <a href="https://github.com/pouya-parsaei">GitHub</a> PouyaMap ',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    }).addTo(mymap);

    document.getElementById('mapid').style.setProperty('height', window.innerHeight + 'px')

    //set view in map
    // mymap.setView([35.697, 51.383], defaultZoom)

    // show and pin markers
    // L.marker(defaultLocation).addTo(mymap).bindPopup("Dolat Blv").openPopup();
    // L.marker([29.589, 52.529]).addTo(mymap).bindPopup("Azar Peyk");
    // mymap.on('popupopen',function(){
    //     alert('PopUp Opened!');
    // });

    //get view Bound information
    // var northLine = mymap.getBounds().getNorth();
    // var westLine = mymap.getBounds().getWest();
    // var southLine = mymap.getBounds().getSouth();
    // var eastLine = mymap.getBounds().getEast();

    // Use Map Events
    mymap.on('zoomend', function() {
        // alert(mymap.getBounds().getCenter());
        // 1 : get bound lines
        // 2 : send bound lines to server
        // 3 : search locations in map windows
        // 4 : display location markers in map
    });

    // Use Map Events
    mymap.on('dblclick', function(event) {
        // alert(event.latlng.lat + " , " + event.latlng.lng);
        // 
        // 1 : add marker in clicked position
        L.marker(event.latlng).addTo(mymap);
        // 2 : open modal (form) to save the clicked location
        $('.modal-overlay').fadeIn(500);
        $('#lat-display').val(event.latlng.lat);
        $('#lng-display').val(event.latlng.lng);
        $('#l-type').val(0);
        $('#l-title').val('');

        // 3 done: fill the form and submit location data to server
        // 4 done: save location in database (status: pending review)
        // 5 : review locations and verify if OK
    });

    //find current location (at first, Use Shekan,ir)
    var current_position, current_accuracy;
    mymap.on('locationfound', function(e) {
        //if position defined, then remove the existing position marker and accuracy circle from
        if (current_position) {
            map.removeLayer(current_position);
            map.removeLayer(current_accuracy);
        }
        var radius = e.accuracy;
        current_position = L.marker(e.latlng).addTo(mymap)
            .bindPopup("دقت تقریبی: " + radius + " متر").openPopup();
        current_accuracy = L.circle(e.latlng, radius).addTo(mymap);
    });
    mymap.on('locationerror', function(e) {
        alert(e.message);
    });
    //wrap map.locate in a function
    function locate() {
        mymap.locate({
            setView: true,
            maxZoom: defaultZoom
        });
    }
    //call locate every 5 seconds... forever
    // setInterval(locate,5000);

    $(document).ready(function(){
        $('form#addLocationForm').submit(function(e){
            e.preventDefault(); //prevent form submiting
            var form = $(this);
            var resultTag = form.find('.ajax-result');
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response){
                    resultTag.html(response);
                }
            });
        })


        $('.modal-overlay .close').click(function(){
            $('.modal-overlay').fadeOut();
        })

    })
