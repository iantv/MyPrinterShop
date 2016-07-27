$('#create_order').click(function(event){
	$.ajax({
		url:"ajax/submit.php",
		type: "POST", 
		data: {
			"order": JSON.stringify(data) },
		success: function(req){
			console.log(req);
		}
	});
});