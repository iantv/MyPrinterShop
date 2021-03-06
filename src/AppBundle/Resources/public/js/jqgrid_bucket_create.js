$(document).ready(function(){
	$("#bucket_list").jqGrid({
		datatype: "local",
		data: data,	
        height: "auto",
			colNames: [
				"id",
				"Товар",
				"Кол-во",
				"Цена",
				"Стоимость",
				""
			],
		colModel: [
			{ name: 'id', width: 50, hidden: false },
			{ name: "Name", width: 400, classes: "product_name_class" },
			{ name: "Count", width: 100, align: "center", classes: "count_of_product_class", formatter: genInputElement },
			{ name: "RetailPrice", width: 120, align: "center", classes: "price_class", formatter: "number"},
			{ name: "Sum", width: 150, align: "center", classes: "price_class", formatter: "number"},
			{ name: "Delete", width: 100, alogn: "center", formatter: genDeleteButton }
		],
		pager: "#pager",
		rownum: 30,
		rowList: [ 30, 50, 100, 200 ],
		sortname: "category",
		sortorder: "subcategory",
		viewrecords: true,
		gridview: true,
		autoencode: true
	});
});

function genInputElement(cellvalue, options, rowObject){
	return "<input id='editingInput_" + options['rowId'] +
		"' class='count_of_product_class' step='1' min='0' type='number' value='" + 
		cellvalue + "' onchange='updateData(this)'/>";
}

function updateData(input){
	var buttonId = $(input).attr('id');
	var rowid = buttonId.substr(buttonId.indexOf("_") + 1)*1;
	updateBucketList(rowid, input.value);
}

function clear_bucket(){
	$.removeCookie('bucket_list', {path: "/", domain: "127.0.0.1"});
	$.removeCookie('bucket_count', {path: "/", domain: "127.0.0.1"});
	$.removeCookie('bucket_sum', {path: "/", domain: "127.0.0.1"});

	$('#bucket_sum').html(0);
	$('.bucket_count').html(0);
	location.reload();
}

function updateBucketInfoByBucketList(products_json){
	var sum = 0, count = 0;
	var res;
	$.each(products_json, function(key, val){
		count += val*1 || 0;
	});

	$.cookie('bucket_count', count, {path: "/", domain: "127.0.0.1"});
	$('.bucket_count').html(count);
}

function genDeleteButton(cellvalue, options, rowObject){
	return "<button id='deleteFromBucketBtn_" +
		options['rowId'] +
		"' class='neutral_button square_button' onclick='deleteProductFromBucket(this)'><font size='5'>x</font></button>";
}


function deleteProductFromBucket(button){
	var buttonId = $(button).attr('id');
	var rowid = buttonId.substr(buttonId.indexOf("_") + 1)*1;
	deleteProductFromBucketList(rowid);
}

var clearedBucket = false;
function deleteProductFromBucketList(rowid){
	updateBucketList(rowid, undefined);
	if (!clearedBucket){
		var productId = $('#bucket_list').jqGrid('getCell',rowid, 'id');
		$('#bucket_list').jqGrid('delRowData', rowid);
	}
	deleteProductFlag = false;
	clearedBucket = false;
}

function updateBucketList(rowid, newval){
	var bucket_list = $.cookie('bucket_list') || '{}',
		products = JSON.parse(bucket_list),
		productId = $('#bucket_list').jqGrid('getCell', rowid, 'id');
	var prev_sum = products[productId]*$('#bucket_list').jqGrid('getCell', rowid, 'RetailPrice');
	products[productId] = newval;

	$.cookie('bucket_list', JSON.stringify(products), {path: "/", domain: "127.0.0.1"});

	updateBucketInfoByBucketList(products);
	 
	var cur_sum = newval*$('#bucket_list').jqGrid('getCell', rowid, 'RetailPrice') || 0,
		sum = $.cookie('bucket_sum')*1 - prev_sum*1 + cur_sum*1 || 0;
	if (!sum){
		clear_bucket();
		clearedBucket = true;
		return;
	}
	$('#bucket_list').jqGrid('setCell', rowid, 'Sum', cur_sum);
	$.cookie('bucket_sum', sum);
	$('#bucket_sum').html(sum);
	$('#total_sum').html(sum);
}