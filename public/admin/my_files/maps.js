

function get_user_location(map) {

    navigator.geolocation.getCurrentPosition(function(position) {
        let geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        let infowindow = new google.maps.InfoWindow({
            map: map,
            position: geolocate,
            content:
            '<div class="my_location_div">'+
            '<span style="color: #ff0005; font: 14px; font-weight: bold">Your Location</span>'
            +'</div>'
        });

        map.setCenter(geolocate);
        map.setZoom(19);
    });
}


function inti_map() {
    lat_val  = $('#geo_location_lat').val();
    long_val = $('#geo_location_long').val();
    const map_options = {
        zoom: 12,
        center: {lat: 28.0871, lng: 30.7618},
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    };
    let map = new google.maps.Map(document.getElementById('google_map'), map_options);

    if(lat_val.length === 0 && long_val.length === 0) {
        get_user_location(map);
    }
    else {
        place_name = $('#place_name').val()
        let infowindow = new google.maps.InfoWindow({
            map : map,
            position:{lat: parseFloat(lat_val), lng: parseFloat(long_val)},
            content:
            '<div class="my_location_div">'+
            '<span style="color: #ff0005; font: 14px; font-weight: bold">'+ place_name +' Location</span>'
            +'</div>'
        });
        map.setCenter({lat: parseFloat(lat_val), lng: parseFloat(long_val)});
        map.setZoom(19);
    }

    const marker = new google.maps.Marker({
        map: map,
        title: 'Marker',
    });
    map.addListener("click", (e) => {
        $('#geo_location_lat').val(e.latLng.lat());
        $('#geo_location_long').val(e.latLng.lng());
        marker.setPosition( e.latLng );
        map.setCenter(e.latLng);
    });
}




function search_place_box(){
    // Create the search box and link it to the UI element.
    let input = (document.getElementById('pac-input'));
    let autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener('places_changed', function() {
        let place = autocomplete.getPlace();

        if (!place.geometry) {
            window.alert("Place contains no geometry");
            return;
        }
        // if place has geometry
        if(place.geometry.viewport){
            map.fitBounds(place.geometry.viewport)
        }
        else{

            map.setCenter(place.geometry.location)
            map.setZoom(17)
        }

        marker.setIcon(({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
        }));

        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

        let address = '';
        if(place.address_components){
            address = [
                (place.address_components[0] && place.address_components[0].short_name || '')
                (place.address_components[1] && place.address_components[1].short_name || '')
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }

        console.log(place.formatted_address);
        console.log(place.geometry.location.lat());
        console.log(place.geometry.location.lng());

    });
}


$(document).ready(function () {

    inti_map();
    setTimeout(function () {
        if($('#google_map').find('.dismissButton').length = 1){
            $('#google_map').children('div:nth-of-type(2)').remove();
        }
    },3000);

});





