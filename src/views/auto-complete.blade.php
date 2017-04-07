var autocomplete = new google.maps.places.Autocomplete(document.getElementById('auto-complete-location-{!! $id !!}'));

autocomplete.bindTo('bounds', map);

var autocompleteInfowindow = new google.maps.InfoWindow();

var autocompleteMarker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, 0)
});

autocomplete.addListener('place_changed', function() {
    autocompleteInfowindow.close();
    autocompleteMarker.setVisible(false);
    var place = autocomplete.getPlace();

    if (!place.geometry) {
        window.alert("No details available for input: '" + place.name + "'");
        return;
    }

    if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
    } else {
        map.setCenter(place.geometry.location);
    }

    autocompleteMarker.setPosition(place.geometry.location);
    autocompleteMarker.setVisible(true);

    var address = '';

    if (place.address_components) {
        address = [
            (place.address_components[0] && place.address_components[0].short_name || ''),
            (place.address_components[1] && place.address_components[1].short_name || ''),
            (place.address_components[2] && place.address_components[2].short_name || '')
        ].join(' ');
    }

    autocompleteInfowindow.setContent('<div id="infowindow-content" style="display: inline;"><img src="' + place.icon + '" width="16" height="16" id="place-icon"><span id="place-name" class="title" style="font-weight: bold;">' + place.name + '</span><br><span id="place-address">' + address + '</span></div>');
    autocompleteInfowindow.open(map, autocompleteMarker);
});