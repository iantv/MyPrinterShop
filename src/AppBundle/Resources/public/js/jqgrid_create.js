var addToBucketFlag = false;

$('#bucket_count').html($.cookie('bucket_count') || 0);
$('#bucket_sum').html($.cookie('bucket_sum') || 0);
//$.cookie('bucket_list', '{}');

$(document).ready(function(){
	$("#list").jqGrid({
		datatype: "local",
		data: data,	
        height: "auto",
			colNames: [
				"id",
				"Категория",
				"Подкатегория",
				"Товар",
				"В наличии",
				"Цена",
				"В корзину"
			],
		colModel: [
			{ name: 'id', width: 50, hidden: false },
			{ name: "Category", width: 150, hidden: true },
			{ name: "SubCategory", width: 150, hidden: true },
			{ name: "Name", width: 400, classes: "product_name_class" },
			{ name: "Count", width: 70, align: "center", classes: "count_of_product_class" },
			{ name: "RetailPrice", width: 120, align: "center", classes: "price_class", formatter: "number"},
			{ name: "ToBucket", width: 150, align: "center", formatter: genToBucketButton}
		],
		pager: "#pager",
		rownum: 30,
		rowList: [ 30, 50, 100, 200 ],
		sortname: "category",
		sortorder: "subcategory",
		viewrecords: true,
		gridview: true,
		autoencode: true,
		/*toppager: true*/
		beforeSelectRow: function(rowid, e){
			if (!addToBucketFlag)
				return;
			/* Add to bucket */
			addToBucketFlag = false;

			var count = $.cookie('bucket_count') || 0;
			count = count*1 + 1;
			$.cookie('bucket_count', count, {path: "/", domain: "127.0.0.1"});
			$('#bucket_count').html(count);
			
			var celValue = $('#list').jqGrid('getCell', rowid, 'RetailPrice');

		    var sum = $.cookie('bucket_sum') || 0;
		    sum = sum*1 + celValue*1;
		    $.cookie('bucket_sum', sum, {path: "/", domain: "127.0.0.1"});
			$('#bucket_sum').html(sum);

			addToBucketList($('#list').jqGrid('getCell', rowid, 'id'));
		}
	});
});

function genToBucketButton(cellvalue, options, rowObject){
	return "<button type='button' class='green_button' onclick='addToBucket()'>КУПИТЬ</button>";
}

function addToBucket(event){
	addToBucketFlag = true;
}

function addToBucketList(productId){
	var bucket_list = $.cookie('bucket_list') || '{}'; //json string
	var products = JSON.parse(bucket_list);
	products[productId] = products[productId] ? products[productId] + 1 : 1;
	$.cookie('bucket_list', JSON.stringify(products), {path: "/", domain: "127.0.0.1"});
}