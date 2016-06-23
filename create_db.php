<?php
	$con = mysql_connect('localhost', 'root','') or die('Could not connect: ' . mysql_error());
    mysql_select_db("goods", $con);

    echo "Connected to MySQL...\n";
	echo "Begin to read data from json file\n";
	$string = file_get_contents("src/AppBundle/Resources/public/js/data.json");
	$data = json_decode($string, true);

	$Products = $data['Products'];
	/*$Category = $data['Products']['Category'];
	$Subategory = $data['Products']['SubCategory'];
	$Name = $data['Products']['Name'];
	$Count = $data['Products']['Count'];
	$RetailPrice = $data['Products']['RetailPrice'];*/
	echo "End reading data from json file\n";

//	echo $Name;
	//$em = $this->getDoctrine()->getManager();
	//$sql = "INSERT INTO Category(Name) VALUES('',)" 
	/*$sql = "INSERT INTO tbl_emp(empid, empname, gender, age, streetaddress, city, state, postalcode, designation, department)
    VALUES('$id', '$name', '$gender', '$age', '$streetaddress', '$city', '$state', '$postalcode', '$designation', '$department')";
    if(!mysql_query($sql,$con))
    {
        die('Error : ' . mysql_error());
    }*/
?>