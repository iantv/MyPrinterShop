$(document).ready(function(){
	$("#list").jqGrid({
		datatype: "local",
		data: data,	
		height: 420,
			colNames: [
				"id",
				"Категория",
				"Подкатегория",
				"Товар",
				"В наличии",
				"Цена"
			],
		colModel: [
			{ name: 'id', width: 0, hidden: true },
			{ name: "Category", width: 150 },
			{ name: "SubCategory", width: 150 },
			{ name: "Name", width: 400 },
			{ name: "Count", width: 100 },
			{ name: "RetailPrice", width: 100 }
		],
		pager: "#pager",
		rownum: 20,
		rowList: [ 20, 50, 100 ],
		sortname: "category",
		sortorder: "subcategory",
		viewrecords: true,
		gridview: true,
		autoencode: true,
		caption: "Прайс-лист"
	});
});