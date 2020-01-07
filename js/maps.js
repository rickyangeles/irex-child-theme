(function($) {

    var global_markers = [];
    var global_infowindows = [];
/*
*  new_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type    function
*  @date    8/11/2013
*  @since   4.3.0
*
*  @param   $el (jQuery element)
*  @return  n/a
*/

lastWindow=null;

function new_map( $el ) {

    // var

    var $markers = $el.find('.marker');


    // vars
    var args = {
        zoom        : 16,
        center      : new google.maps.LatLng(0, 0),
        mapTypeId   : google.maps.MapTypeId.ROADMAP
    };


    // create map
    var map = new google.maps.Map( $el[0], args);


    // add a markers reference
    map.markers = [];


    // add markers
    $markers.each(function(){

        add_marker( $(this), map );

    });


    // center map
    center_map( map );

    // Toggles between infowindows
    for (var i = 0; i < global_markers.length; i++) {
        // Keep value of 'i' in event creation
        (function(i) {
            google.maps.event.addListener(global_markers[i], 'click', function() {
                closeInfowindows();
                global_infowindows[i].open(map, global_markers[i]);
            });
        }(i));
    }


    // return
    return map;

}

/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type    function
*  @date    8/11/2013
*  @since   4.3.0
*
*  @param   $marker (jQuery element)
*  @param   map (Google Map object)
*  @return  n/a
*/

function add_marker( $marker, map ) {
    // var
    var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
    var icon = $marker.attr('data-img');
    // create marker
    var marker = new google.maps.Marker({
        position    : latlng,
        map         : map,
        icon        : icon
    });

    // add to array
    map.markers.push( marker );
    global_markers.push( marker );

    // if marker contains HTML, add it to an infoWindow
    if( $marker.html() )
    {
        // create info window
        var infowindow = new google.maps.InfoWindow({
            content     : $marker.html()
        });

        // PUSH INTO GLOBAL_INFOWINDOWS
        global_infowindows.push( infowindow );

        // show info window when marker is clicked
        // google.maps.event.addListener(marker, 'click', function() {
        //     infowindow.open( map, marker );
        // });
    }

}



/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type    function
*  @date    8/11/2013
*  @since   4.3.0
*
*  @param   map (Google Map object)
*  @return  n/a
*/

function center_map( map ) {

    // vars
    var bounds = new google.maps.LatLngBounds();

    // loop through all markers and create bounds
    $.each( map.markers, function( i, marker ){

        var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

        bounds.extend( latlng );

    });

    // only 1 marker?
    if( map.markers.length == 1 )
    {
        // set center of map
        map.setCenter( bounds.getCenter() );
        map.setZoom( 16 );
    }
    else
    {
        // fit to bounds
        map.fitBounds( bounds );
    }

}

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type    function
*  @date    8/11/2013
*  @since   5.0.0
*
*  @param   n/a
*  @return  n/a
*/
// global var

function closeInfowindows() {
    for (var x = 0; x < global_infowindows.length; x++) {
        global_infowindows[x].close();
    }
}

var map = null;

$(document).ready(function(){

    $('.acf-map').each(function(){
        // create map
        map = new_map( $(this) );
    });

	//zoom
	google.maps.event.addListener( map, 'zoom_changed', function( e ) {
		var zoom = map.getZoom();
		if(zoom!= 5) {
			var bounds = map.getBounds();
			myLatLngss = [];

			$.each( map.markers, function( i, marker ){
				var myLatLng = new google.maps.LatLng(marker.position.lat(), marker.position.lng() );

				if(bounds.contains(myLatLng)===true) {
					myLatLngss.push( myLatLng );
				} else {}
			});

			if(myLatLngss.length > 0) {
				document.cookie = "coordn="+myLatLngss;
				$("#customzm").load(location.href + " #customzm");
			}
		}

	});
	google.maps.event.addListener(map, 'dragend', function() {
		//alert('map dragged');
		var bounds = map.getBounds();

		myLatLngss = [];
		$.each( map.markers, function( i, marker ){

			var myLatLng = new google.maps.LatLng(marker.position.lat(), marker.position.lng() );

			if(bounds.contains(myLatLng)===true) {
				myLatLngss.push( myLatLng );
			} else { }

			if(myLatLngss.length > 0) {
				document.cookie = "coordn="+myLatLngss;
				$("#customzm").load(location.href + " #customzm");
			}
		});
	});

    $(document).on("sf:ajaxfinish", ".searchandfilter", function(){
    	$('.acf-map').each(function(){
            // create map
            map = new_map( $(this) );
        });
    });
});





})(jQuery);
