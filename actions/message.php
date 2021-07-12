<?php 


require 'config.php';

$offer_id = $_POST['offer_id'];

$messanges = [];

$result = pg_query($dbconn, "SELECT * FROM channels");

$channels = pg_fetch_all($result);

// Тип оффера
$result = pg_query($dbconn, "SELECT * FROM offers_data WHERE offer_id = $offer_id");

$types = pg_fetch_all($result);

$types_update = [];

foreach ($types as $key => $value) {
	$types_update[] = $value['channel_id'];
}


$messanges = [];


foreach ($channels as $key => $value) {
	if (isset($_POST['message-'.$value['channel_id']]) && $_POST['message-'.$value['channel_id']] != '') {
		$messanges[$value['channel_id']] = $_POST['message-'.$value['channel_id']];
	}	
}


foreach ($messanges as $key => $messange) {
	if (in_array($key,$types_update)) {
		$result = pg_query($dbconn, "UPDATE offers_data SET offer_data='$messange' WHERE offer_id=$offer_id AND channel_id= $key");
		
	} else {
		$result = pg_query($dbconn, "INSERT INTO offers_data (offer_id, channel_id, offer_data) VALUES ($offer_id, $key, '$messange');");
	}
}
header("Location: ".$host);
