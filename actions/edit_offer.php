<?php 
require 'config.php';


$description = $_POST['description'];

$offer_id = $_POST['offer_id'];

if (isset($_POST['active'])) {
	$active = 'true';;
} else {
	$active = 'false';;
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



$result = pg_query($dbconn, "UPDATE offers SET description='$description', is_active=$active, taggs='$tags' WHERE offer_id=$offer_id");




header("Location: ".$host);