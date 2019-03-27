<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Hello, world!</title>
	<style>
		/* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
		#map {
			height: 100%;
		}
	</style>
</head>

<body>
	<div class="row">
		<div class="col-md-12">
			<div id="map"></div>
		</div>
	</div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
		integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
	</script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
	</script>

	<script type="text/javascript">
        var pointsJson = '<?php echo $points_json;?>';
        var pointsdetailsJson = '<?php echo $points_details_json;?>';
		var locations = JSON.parse(pointsJson);
        var total_locations = locations.length;
        var pointdetails = JSON.parse(pointsdetailsJson);
        var total_pointdetails = pointdetails.length;

		for (let r = 0; r < total_locations; r++) {
			let currentLocation = locations[r];
			currentLocation.lat = parseFloat(currentLocation.lat);
            currentLocation.lng = parseFloat(currentLocation.lng);
            // currentLocation.pillar_number = parseFloat(currentLocation.pillar_number);
        }
        for(let y = 0; y < total_pointdetails; y++){
            let curentPointDetails = pointdetails[y];
            var contentString = curentPointDetails.pillar_number;
        }
		// console.log(locations);
		function initMap() {
			var map = new google.maps.Map(document.getElementById('map'), {
				zoom: 3,
				center: {
					lat: 0.0182575,
					lng: 37.0720278
				}
			});

			// Create an array of alphabetical characters used to label the markers.
			var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

			// Add some markers to the map.
			// Note: The code uses the JavaScript Array.prototype.map() method to
			// create an array of markers based on a given "locations" array.
            // The map() method here has nothing to do with the Google Maps API.
            
            // var contentString = currentLocation.pillar_number;
            var infowindow = new google.maps.InfoWindow({
                content:"Hello World!"
            });

			var markers = locations.map(function (location, i) {
				return new google.maps.Marker({
					position: location,
					label: labels[i % labels.length]
				});
            });
            google.maps.event.addListener(markers, 'click', function() {
                infowindow.open(map,markers);
            });
            // markers.addEventListener('click', function() {
            //     infowindow.open(map, markers);
            // });

			// Add a marker clusterer to manage the markers.
			var markerCluster = new MarkerClusterer(map, markers, {
				imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
            });
            
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0; i < markers.length; i++) {
                bounds.extend(markers[i].getPosition());
            }

            map.fitBounds(bounds);
		}

	</script>

	<script
		src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
	</script>
	<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqpe5MxT-z7CHNWtJHCDm0cp9Mpiwuk3s&callback=initMap">
	</script>
</body>

</html>
