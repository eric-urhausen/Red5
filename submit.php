<?php require 'main.php'; 

	$id = $_REQUEST["id"];
	$last_four = substr($_REQUEST["cc_num"],-4,4);
	$card_type = $_REQUEST["cc_type"];
	$month = $_REQUEST["exp_month"];
	$monthNum = date("n", strtotime($month));
	$year = $_REQUEST["exp_year"];

	mysql_query("INSERT INTO payment_profiles (`account_id`, `last_four`, `card_type`, `exp_month`, `exp_year`) VALUES ('$id','$last_four','$card_type','$monthNum','$year')");
?>