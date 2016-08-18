var deleteProductFlagFromDB = false;

$(document).ready(function(){
	var lastSel;
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
				"В корзину", 
				"Удалить"
			],
		colModel: [
			{ name: 'id', width: 50, hidden: false, editable:false },
			{ name: "Category", width: 150, hidden: true, editable:true },
			{ name: "SubCategory", width: 150, hidden: true, editable:true },
			{ name: "Name", width: 300, classes: "product_name_class", editable:true, edittype:'text' },
			{ name: "Count", width: 70, align: "center", classes: "count_of_product_class", editable:true },
			{ name: "RetailPrice", width: 120, align: "center", classes: "price_class", formatter: "number", editable:true},
			{ name: "ToBucket", width: 180, align: "center", formatter: genToBucketButton, hidden: toBuy, editable:false },
			{ name: "Delete", width: 100, align: "center", formatter: genDeleteProductButton, hidden: toDelete, editable:false }
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
/*		beforeSelectRow: function(rowid, e){
			if (deleteProductFlagFromDB){
				var productId = $('#list').jqGrid('getCell',rowid, 'id');
				$('#list').jqGrid('delRowData', rowid);
				deleteProductFlagFromDB = false;
			}
		},*/
		ondblClickRow: function(id){
			if (!toEdit)
				return;
	    	if(id && id!==lastSel){ 
	        	jQuery('#list').restoreRow(lastSel);
	        	lastSel=id; 
	     	}
	     	jQuery('#list').editRow(id, true); 
		}
	});
});


function genToBucketButton(cellvalue, options, rowObject){
	var products = getJSONProductsFromBucketList();
	var buttonName = products[rowObject['id']] ? 'В корзине (' + products[rowObject['id']] + ')' : 'КУПИТЬ';
	return "<button class='pozitive_button' id='addToBucketBtn_" + options['rowId'] +
			"' onclick='addToBucket(this)'><font size='2'>" + 
			buttonName + "</font></button>";
}

function addToBucket(button){
	var buttonId = $(button).attr('id');
	var rowid = buttonId.substr(buttonId.indexOf("_") + 1)*1;
	
	var count = $.cookie('bucket_count') || 0;
	count = count*1 + 1;
	$.cookie('bucket_count', count, {path: "/", domain: "127.0.0.1"});
	$('.bucket_count').html(count);
	
	var celValue = $('#list').jqGrid('getCell', rowid, 'RetailPrice');

    var sum = $.cookie('bucket_sum') || 0;
    sum = sum*1 + celValue*1;
    $.cookie('bucket_sum', sum, {path: "/", domain: "127.0.0.1"});
	$('#bucket_sum').html(sum);

	addToBucketList($('#list').jqGrid('getCell', rowid, 'id'));

	$(button).html('В корзине (' +  getProductCountFromBucketListByRowId(rowid) + ')');
}

function genDeleteProductButton(){
	return "<div class='negative_button' onclick='deleteProductFromDB(this)'>X</div>";
}

function deleteProductFromDB(button){
	deleteProductFlagFromDB = true;
}

function addToBucketList(productId){
	var products = getJSONProductsFromBucketList();
	products[productId] = (products[productId] ? (products[productId] + 1) : 1);
	$.cookie('bucket_list', JSON.stringify(products), {path: "/", domain: "127.0.0.1"});
	//console.log($.cookie('bucket_list'))
}

function getJSONProductsFromBucketList(){
	return JSON.parse($.cookie('bucket_list') || '{}');
}

function getProductCountFromBucketListByRowId(rowid){
	var id = $('#list').jqGrid('getCell', rowid, 'id');
	return getJSONProductsFromBucketList()[id];
}