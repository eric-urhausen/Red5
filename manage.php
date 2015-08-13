<?php require 'main.php'; 

	$id = $_REQUEST["cardId"];
	$method = $_REQUEST["method"];
	$month = $_REQUEST["month"];
	$monthNum = date("n", strtotime($month));
	$year = $_REQUEST["year"];

	if ($id == 'new'){
		$result = mysql_query("SELECT MAX(id) AS id from payment_profiles WHERE account_id = 1");
		while($row = mysql_fetch_array($result)) {
			$id = $row["id"];
		}
	}

	if ($method == 'default'){
		mysql_query("UPDATE payment_profiles SET is_default = 0");
		mysql_query("UPDATE payment_profiles SET is_default = 1 WHERE account_id = 1 AND id = '".$id."'");
	}
	elseif ($method == 'delete'){
		mysql_query("DELETE FROM payment_profiles WHERE account_id = 1 AND id = '".$id."'");
	}
	elseif ($method == 'edit'){
		mysql_query("UPDATE payment_profiles SET exp_month = '".$monthNum."', exp_year = '".$year."' WHERE account_id = 1 AND id = '".$id."'");
	}
?>