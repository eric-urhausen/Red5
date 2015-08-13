<?php
//Variables for connecting to your database.
//These variable values come from your hosting account.

	mysql_connect('localhost','test-eric','r3dRover!') or die(mysql_error());
	mysql_select_db('test-industry') or die(mysql_error());

function history(){

	$query = "	SELECT k.id, 
				k.payment_profile_id AS profile,
				k.currency_type AS currency,
				k.amount AS amount,
				k.created_at AS date,
				uk.name AS package_name,
				uk.award_size AS size
				FROM charges k
				LEFT JOIN packages uk on k.package_id = uk.id
				WHERE payment_profile_id=1";

	$result = mysql_query($query);
	$count = 1;
	if ($result) {
		echo '<table>
				<thead>
					<tr class="table-head">
						<th class="package-header right-border">PACKAGE NAME</th>
						<th class="size-header right-border">SIZE</th>
						<th class="cost-header right-border">COST</th>
						<th>DATE</th>
					</tr>
				</thead>';

		while($row = mysql_fetch_array($result)) {
			$package_name = str_replace("Booster","",$row["package_name"]);
			$amount = '$'.bcdiv($row["amount"],100,2);
			$date = new DateTime($row["date"]);
			$created_at = $date->format('g:i A - n/j/y');
			$size = $row["size"];
			

			if($count % 2 == 0){
				echo "<tr>";
			}
			else{
				echo "<tr class='dark'>";
			}
			echo 	"<td class='right-border'>$package_name</td>
					<td class='right-border'>$size</td>
					<td class='right-border'>$amount</td>
					<td>$created_at</td>
				</tr>";

			$count++;
		}
		while ($count < 17){
			if($count % 2 == 0){
				echo "<tr>";
			}
			else{
				echo '<tr class="dark">';
			}
			echo 	'<td class="right-border"></td>
					<td class="right-border"></td>
					<td class="right-border"></td>
					<td></td>
				</tr>';
				$count++;
		}
		echo '</table>';
	}		
} 

function manage(){

	$query = "	SELECT k.account_id AS acct_id,
				k.id AS id,
				k.last_four AS Last,
				k.card_type AS Type,
				k.exp_month AS ExpMonth,
				k.exp_year AS ExpYear,
				k.is_default AS IsDefault,
				uk.email AS Email
				FROM payment_profiles k
				LEFT JOIN accounts uk on k.account_id = uk.id
				WHERE account_id=1
				ORDER BY id";

	$result = mysql_query($query);
	if ($result) {
		while($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			$last_four = $row["Last"];
			$card_type = $row["Type"];
			$exp_month = $row["ExpMonth"];
			$monthName = date("M", mktime(0, 0, 0, $exp_month, 10));
			$exp_year = $row["ExpYear"];
			$IsDefault = $row["IsDefault"];
			echo 	'<div class="cc-manage-container" id="'.$id.'">
						<form id="manageForm" action="#" class="inline-form" name="manage-payments" onsubmit="new Ajax.Updater("api_results", "manage.php", { parameters:$("#manageForm").serialize(this) }); return false">
							<div class="inner-container">
								<div class="manage-field dark">
									<input id="manage-cc-type" class="field-input disabled" name="manage-cc-type" value="'.$card_type.'" required disabled/>
									<label for="manage-cc-type">Card Type:</label>
								</div>
								<div class="manage-field">
									<label for="cc-name">Full Name On Card:</label>
									<input id="cc-name" class="field-input disabled" name="cc-name" value="Leeroy Jenkins-san" required disabled/>
								</div>
								<div class="manage-field dark">
									<label for="manage-cc-num">Credi Card Number:</label>
									<input id="manage-cc-num" class="field-input disabled" name="manage-cc-num" value="**** **** ****'." ".$last_four.'" required disabled/>
								</div>
								<div class="manage-field">
										<label for="exp-cc-month">Expiration Date:</label>
									<div class="float-right">
										<input id="exp-cc-month" class="field-input month month'.$id.' disabled" name="exp-cc-month" value="'.$monthName.'" required disabled/>									
										<input id="exp-cc-year" class="field-input  year year'.$id.' disabled" name="exp-cc-year" value="'.$exp_year.'" required disabled/>
									</div>
								</div>
								<div class="manage-field dark">
									<label for="manage-cc-zip">Zip/Postal Code:</label>
									<input id="manage-cc-zip" class="field-input disabled" name="manage-cc-zip" value="33415" required disabled/>
								</div>
								<input type="submit" id="delete" name="Delete" value="Delete">
								<div class="float-right">
									<input type="submit" id="edit" name="Edit" value="Edit">';
							if($IsDefault != 1){
								echo '<input type="submit" id="default" name="Set as default" value="Set as default">';
							}
							else{
								echo '<input type="submit" id="default" name="Set as default" value="Set as default" style="display:none;">';
							}
						echo	'</div>
							</div>
						</form>
					</div>';
		}
	}
}
?>