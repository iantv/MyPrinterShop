<?php
if(isset($_POST) && !empty($_POST['order'])) {    
	$link = mysql_connect("127.0.0.1", "root", "") or die("Не удалось соединиться...");
	echo "Соединение успешно установлено.";
	mysql_select_db("goods") or die("Не удалось выбрать базу данных");


	echo $_POST['order'];
}
?>