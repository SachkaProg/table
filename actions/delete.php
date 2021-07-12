<?php 


require 'config.php';


$id = $_GET['id'];

$result = pg_query($dbconn, "DELETE FROM offers WHERE offer_id = $id;");


header("Location: ".$host);