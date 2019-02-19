/**
 * Created by Junaid Rahman on 07-09-2016.
 */

(function ($) {
    jQuery.fn.yiiMapKit = function (options) {
        var inputLatitude = options.latitudeFieldId,
            inputLongitude = options.longitudeFieldId,
            map_canvas = options.mapName,
            searchTextField = options.searchTextField,
            image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png';

        var methods = {
            init: function () {
                var lat = $('#' + inputLatitude).val(),
                    lng = $('#' + inputLongitude).val();

                if (!lat && !lng) {
                    lat = 28.7041;
                    lng = 77.1025;
                }
                //var lat contains the value enterd in the latitude input field
                //var lng contains the value enterd in the longitude input field

                var latlng = new google.maps.LatLng(lat, lng);

                //zoomControl: true,
                //zoomControlOptions: google.maps.ZoomControlStyle.LARGE,
                var mapOptions = {
                        center: new google.maps.LatLng(lat, lng),
                        zoom: 9,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        panControl: true,
                        panControlOptions: {
                            position: google.maps.ControlPosition.TOP_RIGHT
                        },
                        zoomControl: true,
                        zoomControlOptions: {
                            style: google.maps.ZoomControlStyle.LARGE,
                            position: google.maps.ControlPosition.TOP_left
                        }
                    },
                    map = new google.maps.Map(document.getElementById(map_canvas), mapOptions),
                    marker = new google.maps.Marker({
                        position: latlng,
                        map: map,
                        draggable: true,
                        icon: image
                    });
                var input = document.getElementById(searchTextField);
                $.ajax({
                    url: "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + lat + "," + lng + "&key=AIzaSyBcXUZ8SohRQzKnY4iYaa5_B2ix0b_OY9g",
                    type: "POST",
                    dataType: "json",
                    success: function (result) {
                        switch (result) {
                            case true:
                                input.value = result["results"][0].formatted_address;
                                break;
                            default://alert(JSON.stringify(result["results"][0]));
                                input.value = result["results"][0].formatted_address;
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(thrownError);
                    }
                });
                input.addEventListener('keydown', function (ev) {
                    var keycode = (ev.keyCode ? ev.keyCode : ev.which);
                    if (keycode == '13') {
                        ev.preventDefault();
                    }
                }, false);
                var autocomplete = new google.maps.places.Autocomplete(input, {
                    types: ["geocode"]
                });
                autocomplete.bindTo('bounds', map);
                var infowindow = new google.maps.InfoWindow();
                google.maps.event.addListener(autocomplete, 'place_changed', function (event) {
                    infowindow.close();
                    var place = autocomplete.getPlace();
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }
                    moveMarker(place.name, place.geometry.location);
                    $('#' + inputLatitude).val(place.geometry.location.lat());
                    $('#' + inputLongitude).val(place.geometry.location.lng());
                });
                google.maps.event.addListener(map, 'click', function (event) {
                    $('#' + inputLatitude).val(event.latLng.lat());
                    $('#' + inputLongitude).val(event.latLng.lng());
                    infowindow.close();
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({
                        "latLng": event.latLng
                    }, function (results, status) {
                        console.log(results, status);
                        if (status == google.maps.GeocoderStatus.OK) {
                            console.log(results);
                            var lat = results[0].geometry.location.lat(),
                                lng = results[0].geometry.location.lng(),
                                placeName = results[0].address_components[0].long_name,
                                latlng = new google.maps.LatLng(lat, lng);
                            moveMarker(placeName, latlng);
                            $("#" + searchTextField).val(results[0].formatted_address);
                        }
                    });
                });
                google.maps.event.addListener(marker, 'click', function (event) {
                    $('#' + inputLatitude).val(event.latLng.lat());
                    $('#' + inputLongitude).val(event.latLng.lng());
                    infowindow.close();
                });
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    $('#' + inputLatitude).val(event.latLng.lat());
                    $('#' + inputLongitude).val(event.latLng.lng());
                    infowindow.close();
                });
                $('#' + inputLatitude).bind('input', function () {
                    methods.init();
                    infowindow.close();
                });
                $('#' + inputLongitude).bind('input', function () {
                    methods.init();
                    infowindow.close();
                });
                function moveMarker(placeName, latlng) {
                    marker.setIcon(image);
                    marker.setPosition(latlng);
                    infowindow.setContent(placeName);
                    //infowindow.open(map, marker);
                }
            }
        };
        methods.init.apply(this);
        return this;
    };

})(jQuery);

