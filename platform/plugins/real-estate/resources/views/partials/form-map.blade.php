
        <style>
            #map-canvas{
            height: 500px;
            width: 500px;
            border: 3px solid black;
            }

            #search_input {
            font-size: 18px;
            width: 430px;
            height: 40px;
            margin: 5px;
            padding: 5px;
            box-sizing: border-box;
            }


        </style>

        <input type="text" id="search_input" style="width: 55% !important" name="location" class="form-control" placeholder="Search for a place" />
        <div id="information"></div>
        <div id="map-canvas" style="height: 380px"></div>

        {{-- <div id="map_canvas" style="height: 354px; width:713px;"></div> --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGhGk3DTCkjF1EUxpMm5ypFoQ-ecrS2gY&sensor=false&callback=initMap&v=3.exp&libraries=places"
            defer
            ></script>
        {{-- <script type="script" src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;signed_in=true&amp;libraries=places"></script> --}}
        <script>
            function initMap() { // now it IS a function and it is in global


            // alert();
            // if HTML DOM Element that contains the map is found...
            if (document.getElementById('map-canvas')) {
                var content;
                var latElement;
                var longElement;
                var latitude = 52.525595;
                var longitude = 13.393085;
                var map;
                var marker;
                navigator.geolocation.getCurrentPosition(loadMap);

                function loadMap(location) {
                    if (location.coords) {
                        latitude = location.coords.latitude;
                        longitude = location.coords.longitude;
                    }

                    // Coordinates to center the map
                    var myLatlng = new google.maps.LatLng(latitude, longitude);

                    // Other options for the map, pretty much selfexplanatory
                    var mapOptions = {
                        zoom: 14,
                        center: myLatlng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    // Attach a map to the DOM Element, with the defined settings
                    map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

                    content = document.getElementById('information');
                    latElement = document.getElementById('latitude');
                    longElement = document.getElementById('longitude');
                    google.maps.event.addListener(map, 'click', function(e) {
                    placeMarker(e.latLng);
                    });

                    var input = document.getElementById('search_input');
                    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                    var searchBox = new google.maps.places.SearchBox(input);

                    google.maps.event.addListener(searchBox, 'places_changed', function() {
                    var places = searchBox.getPlaces();
                    placeMarker(places[0].geometry.location);
                    });

                        marker = new google.maps.Marker({
                        map: map
                        });

                        var markers = [];
                    // Listen for the event fired when the user selects a prediction and retrieve
                    // more details for that place.
                    searchBox.addListener('places_changed', function() {
                    var places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    // Clear out the old markers.
                    markers.forEach(function(marker) {
                        marker.setMap(null);
                    });
                    markers = [];

                    // For each place, get the icon, name and location.
                    var bounds = new google.maps.LatLngBounds();
                    places.forEach(function(place) {
                        if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                        }

                        // Create a marker for each place.
                        markers.push(new google.maps.Marker({
                        map: map,
                        title: place.name,
                        position: place.geometry.location
                        }));

                        if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                        } else {
                        bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                    });
                }
            }
            function placeMarker(location) {
                marker.setPosition(location);
                //map.setCenter(location)
                // content.innerHTML = "Lat: " + location.lat() + " / Long: " + location.lng();
                latElement.value=location.lat();
                longElement.value=location.lng();
                google.maps.event.addListener(marker, 'click', function(e) {
                    new google.maps.InfoWindow({
                        content: "Lat: " + location.lat() + " / Long: " + location.lng()
                    }).open(map,marker);
                });
            }
        }

        </script>
