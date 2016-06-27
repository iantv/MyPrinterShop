$(document).ready(function(){
	$("#list").jqGrid({
		datatype: "local",
		data: data,	
		//width: '100%',
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
			{ name: 'id', width: 0, hidden: true },
			{ name: "Category", width: 150, hidden: true },
			{ name: "SubCategory", width: 150, hidden: true },
			{ name: "Name", width: 400, classes: "product_name_class" },
			{ name: "Count", width: 70, align: "center", classes: "count_of_product_class" },
			{ name: "RetailPrice", width: 100, align: "center", classes: "price_class"},
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
		/*caption: "Прайс-лист",*/
	});
});

function genToBucketButton(cellvalue, options, rowObject){
	return "<button type='button' class='buy_button'>КУПИТЬ</button>";
}