var Vdk = new google.maps.LatLng(43.117,131.9);
var mapOptions = {
	center: Vdk,
	zoom: 11,
	mapTypeId: google.maps.MapTypeId.ROADMAP
};
var map = [];
var markers = [];

var mapOrderId = 0;
var index = 0;

function init(){
	if (!mapOrderId) return;
	index++;
	$('#googleMap' + mapOrderId).css('display', 'block');
	map[index] = new google.maps.Map(document.getElementById('googleMap' + mapOrderId), mapOptions);	
	
	var endDeliveryPoint = JSON.parse($('#endDeliveryPoint' + mapOrderId).html());
	var currentDeliveryPoint = JSON.parse($('#currentDeliveryPoint' + mapOrderId).html());
	var deliveryState = $('#deliveryState' + mapOrderId).html();
	var deliveryDate = $('#deliveryDate' + mapOrderId).html();
	
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
	});
	markers[2*index + 1].setMap(map[index]);	
}

google.maps.event.addDomListener(window, 'load', init);	

function showOrderOnMap(orderId){
	mapOrderId = orderId;
	init();
	$('#showOrderOnMapBtn_' + orderId).css('display', 'none');
	$('#hideOrderOnMapBtn_' + orderId).css('display', 'inline-block');
}

function hideOrderOnMap(orderId){
	$('#googleMap' + mapOrderId).css('display', 'none');
	$('#hideOrderOnMapBtn_' + orderId).css('display', 'none');
	$('#showOrderOnMapBtn_' + orderId).css('display', 'inline-block');
}