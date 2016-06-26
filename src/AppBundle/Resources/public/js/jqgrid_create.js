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
				"Цена"
			],
		colModel: [
			{ name: 'id', width: 0, hidden: true },
			{ name: "Category", width: 150 },
			{ name: "SubCategory", width: 150 },
			{ name: "Name", width: 400 },
			{ name: "Count", width: 100 },
			{ name: "RetailPrice", width: 70 }
		],
		pager: "#pager",
		rownum: 30,
		rowList: [ 30, 50, 100, 200 ],
		sortname: "category",
		sortorder: "subcategory",
		viewrecords: true,
		gridview: true,
		autoencode: true,
		caption: "Прайс-лист"
	});
});