<?php 
require 'config.php';


$description = $_POST['description'];

if (isset($_POST['active'])) {
	$active = 1;
} else {
	$active = 0;
}


$tags_request = [];
// Каналы
$result = pg_query($dbconn, "SELECT * FROM tags");

$tags = pg_fetch_all($result);

foreach ($tags as $key => $value) {
	if (isset($_POST['tags-'.$value['tagid']])) {
		$tags_request[] = $value['tagid'];
	} 
}

$tags = json_encode($tags_request);

// Добавляем оффера
$result = pg_query('SELECT MAX(offer_id) from offers');
$maxArr = pg_fetch_row($result);
$max = $maxArr[0] + 1;

$result = pg_query($dbconn, "INSERT INTO offers 
VALUES ($max, '$description', '$active','$tags');");


header("Location: ".$host);