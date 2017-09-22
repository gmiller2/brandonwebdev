<?php

$server = 'localhost';
$userName = 'root';
$password = 'XXXXXXXXX';
$databaseName = 'epsilont_mbc';

$con = mysql_connect($server, $userName, $password) or die('Error connecting to server');

mysql_select_db($databaseName, $con);

$query = mysql_query("select
	class.name as 'Class Name',
	round((count(*)/class.capacity)*100) as 'Percent Full'
	from class
	inner join register on (class.id = register.class1_id)
	or  (class.id = register.class2_id)
	or (class.id = register.class3_id)
	or (class.id = register.class4_id)
	inner join student on register.student_id = student.id
group by class.name");

$table = array();
$table['cols'] = array(
	/* each column gets its own array
	 * syntax of the arrays is:
	 * label => column label
	 * type => data type of column (string, number, date, datetime, boolean)
	 */
    array('label' => 'Class Name', 'type' => 'string'),
		array('label' => 'Percent Full', 'type' => 'number')
);

$rows = array();
while($r = mysql_fetch_assoc($query)) {
    $temp = array();
	// each column needs to have data inserted via the $temp array
	$temp[] = array('v' => $r['Class Name']);
	$temp[] = array('v' => $r['Percent Full']);

	// insert the temp array into $rows
    $rows[] = array('c' => $temp);
}

// populate the table with rows of data
$table['rows'] = $rows;

// encode the table as JSON
$jsonTable = json_encode($table);

// set up header; first two prevent IE from caching queries
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

// return the JSON data
echo $jsonTable;
?>
