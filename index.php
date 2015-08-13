<?php require 'main.php';?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" href="css/style.css" />
	<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>
</head>
<body>
	<div id="background"></div>
	<button id="show-menu" type="button">Show Menu</button>
	<div id="pop-up-menu">
		<div id="menu-close"></div>
		<div id="header">
			<div id="cc-manage"><span class="active"></span></div>
			<div id="cc-history"><span class=""></span></div>
			<div id="redbux-balance"></div>
		</div>
		<div id="manage-page">
			<h3 class="page-header">Manage Payment Methods</h3>
			<div id="manage-container">
				<?php manage(); ?>
			</div>
			<div id="manage-btn-container">
				<button id="cancel" type="button">Cancel</button>
				<button id="add-payment" type="button">Add Another Payment Method</button>
			</div>
		</div>
		<div id="new-cc-page">
			<h3 class="page-header">Create New a Payment Method.</h3>
			<div class="cc-container">
				<form id="myform" action="#" class="inline-form" name="new-panyment-method" onsubmit='new Ajax.Updater("api_results", "submit.php", { parameters:$("#myform").serialize(this) }); return false'>
					<div class="inner-container">
						<div class="field dark">
							<label class="field-label">Accepted Card Types:</label>
							<input id="cc-type" class="field-input hide" name="cc-type" value="" />
							<div id="cc-img">
								<div id="visa" class="cards-img"></div>
								<div id="mastercard" class="cards-img"></div>
								<div id="amex" class="cards-img"></div>
								<div id="discover" class="cards-img"></div>
								<div id="jcb" class="cards-img"></div>
								<div id="platinum" class="cards-img"></div>
							</div>
						</div>
						<div class="field">
							<label for="cc-num">Credit Card Number:</label>
							<input id="cc-num" class="field-input" name="cc-num" onChange="GetCard();" required />
						</div>
						<div class="field dark">
							<label for="exp-month">Expiration Date:</label>
							<input id="exp-month" class="field-input" placeholder="Month" name="exp-month" required />
							<input id="exp-year" class="field-input" placeholder="Year" name="exp-year" required />
						</div>
						<div class="field">
							<label for="val-code">Validation Code (?):</label>
							<input id="val-code" class="field-input" name="val-code"/>
						</div>
						<div class="field dark-bottom">
							<label for="zip-code">Zip/Postal Code:</label>
							<input id="zip-code" class="field-input" name="zip" required />
						</div>
						<input type="submit" id="create-payment-btn" name="Create Payment Method" value="Create Payment Method">
						<h4 class="terms-text">By Clicking Confirm, you agree to FireFall's Terms &amp; Conditions</h4>
					</div>
				</form>
			</div>
		</div>
		<div id="history-page">
			<?php history(); ?>
		</div>
		<div id="formResponse">Credit card added successfully</div>
	</div>

	<!-- JavaScript at the bottom for fast page loading -->
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/script.js"></script>
</body>
</html>