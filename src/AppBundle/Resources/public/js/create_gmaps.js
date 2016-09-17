function initialize() {
	var Vdk = new google.maps.LatLng(43.117,131.9);
	var mapOptions = {
		center: Vdk,
		zoom: 12,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = [];
	var markers = [];

	$('.gmap').each(function(index){
		
		map[index] = new google.maps.Map(document.getElementById('googleMap' + $(this).attr('id').substr(13)), mapOptions);	
		
		var endDeliveryPoint = JSON.parse($('#endDeliveryPoint').html());
		var currentDeliveryPoint = JSON.parse($('#currentDeliveryPoint').html());
		var deliveryState = $('#deliveryState').html();
		var deliveryDate = $('#deliveryDate').html();
		
		/*	!!!DO LEGEND NEAR EVERY MAP!!!

		var infoWindow = new google.maps.InfoWindow({
			content: 'Пункт выдачи: <br>' + endDeliveryPoint['address']
		});*/

		/*var infoWindow = new google.maps.InfoWindow({
			content: ': <br>' + currentDeliveryPoint['address'] 
		});*/
		
		markers[2*index] = new google.maps.Marker({
			position: new google.maps.LatLng(endDeliveryPoint['nothLatitude'], endDeliveryPoint['eastLongitude']),
			title:'Click to zoom',
			icon: endDeliveryMarker
		});
		markers[2*index].setMap(map[index]);

		markers[2*index + 1] = new google.maps.Marker({
			position: new google.maps.LatLng(currentDeliveryPoint['nothLatitude'], currentDeliveryPoint['eastLongitude']),
			title:'Click to zoom',
			icon: curDeliveryMarker,
			//animation:google.maps.Animation.BOUNCE
		});
		markers[2*index + 1].setMap(map[index]);

		//infoWindow.open(map[index], markers[2*index]);
	});
}
google.maps.event.addDomListener(window, 'load', initialize);