/***********************
Eric Urhausen
script.js
************************/

//Hide pages
$("#pop-up-menu").hide();
$("#history-page").hide();
$("#new-cc-page").hide();
$("#formResponse").hide();

//Click events
$("#menu-close").click(function ()
    {        
        $('#pop-up-menu').slideUp();
        $("#show-menu").show();
    });
$("#cancel").click(function ()
    {        
        $('#pop-up-menu').slideUp();
        $("#show-menu").show();
    });
$("#show-menu").click(function ()
    {        
        $('#pop-up-menu').slideDown();
        $(this).hide();
    });
$("#cc-manage").click(function ()
    {        
        $('#manage-page').show();
        $("#history-page").hide();
		$("#new-cc-page").hide();
		$("success-page").hide();
		$("#formResponse").hide();
		$("#cc-manage span").addClass("active");
		$("#cc-history span").removeClass("active");
    });
$("#cc-history").click(function ()
    {        
        $('#history-page').show();
        $("#manage-page").hide();
		$("#new-cc-page").hide();
		$("success-page").hide();
		$("#formResponse").hide();
		$("#cc-history span").addClass("active");
		$("#cc-manage span").removeClass("active");
    });
$("#add-payment").click(function ()
    {        
        $('#new-cc-page').show();
        $("#manage-page").hide();
		$("#history-page").hide();
		$("#cc-history span").removeClass("active");
		$("#cc-manage span").removeClass("active");
    });
$(document).on("click", "#delete", function ()
    {        
    	var removeCard = $(this).parent().parent().parent();
    	var cardId = removeCard[0].id;
    	$.ajax({
	        url: 'manage.php',
	        type:'POST',
	        async: true,
	        data:
	        ({
	        	cardId : cardId,
	        	method : 'delete'
	        }),
	        success: function(msg)
	        {
	        	$('#' + cardId).slideUp(500, function() {
					removeCard.remove();
	    		});
	        }
	    });
	    return false;
	});
$(document).on("click", "#edit", function ()
    {        
    	var removeCard = $(this).parent().parent().parent().parent();
    	var cardId = removeCard[0].id;
    	var month = $(".month" + cardId).val();
    	var year = $(".year" + cardId).val();
    	if ($(this).val() == "Save"){
    		$(this).val("Edit");
			$('.year' + cardId).attr('disabled', 'disabled');
			$('.year' + cardId).attr('class', 'field-input year year'+ cardId +' disabled');
			$('.month' + cardId).attr('disabled', 'disabled');
			$('.month' + cardId).attr('class', 'field-input month month'+ cardId +' disabled');
	    	$.ajax({
		        url: 'manage.php',
		        type:'POST',
		        async: true,
		        data:
		        ({
		        	cardId : cardId,
		        	year : year,
		        	month : month,
		        	method : 'edit'
		        }),
		        success: function(msg)
		        {
		        	$(this).val("Edit");
		        }
		    });
	 	   return false;
		}
		else if ($(this).val() == "Edit"){
			$(this).val("Save");
			$('.year' + cardId).removeAttr('disabled');
			$('.year' + cardId).attr('class', 'field-input year year'+ cardId );
			$('.month' + cardId).removeAttr('disabled');
			$('.month' + cardId).attr('class', 'field-input month month'+ cardId );
			return false;
		}
	});
$(document).on("click", "#default", function ()
	{        
		$('[id^="default"]').show().delay(500);
		$(this).hide();
		
    	var removeCard = $(this).parent().parent().parent().parent();
    	var cardId = removeCard[0].id;
    	$.ajax({
	        url: 'manage.php',
	        type:'POST',
	        async: true,
	        data:
	        ({
	        	cardId : cardId,
	        	method : 'default'
	        }),
	        success: function(msg)
	        {

	        }
	    });
	    return false;
	});
//Create New Payment
$("#myform").submit(function()
{

	var cc_num = $('#cc-num').val();
	var cc_type = $('#cc-type').val();
    var exp_month = $('#exp-month').val();
    var exp_year = $('#exp-year').val();
    
    $.ajax({
        url: 'submit.php',
        type:'POST',
        async: true,
        data:
        ({
        	id : 1,
            cc_num: cc_num,
            cc_type: cc_type,
            exp_month: exp_month,
            exp_year: exp_year
        }),
        success: function(msg)
        {
           	$("#formResponse").show();
        	$("#new-cc-page").hide();
        	$('#cc-num').val('');
        	$('#exp-month').val('');
        	$('#exp-year').val('');
        	$('#val-code').val('');
        	$('#zip-code').val('');
        	//Reset all cards to half opacity
			$('#amex').fadeTo("fast", .5);
			$('#discover').fadeTo("fast", .5);
			$('#jcb').fadeTo("fast", .5);
			$('#mastercard').fadeTo("fast", .5);
			$('#visa').fadeTo("fast", .5);
			$('#platinum').fadeTo("fast", .5);
        	$("#manage-container").append('	<div class="cc-manage-container" id="new"> \
												<form id="myform" action="#" class="inline-form " name="new-panyment-method" onsubmit="new Ajax.Updater("api_results", "submit.php", { parameters:$("#myform").serialize(this) }); return false"> \
													<div class="inner-container"> \
														<div class="manage-field dark"> \
															<input id="manage-cc-type" class="field-input disabled" name="manage-cc-type" value="'+ cc_type +'" required disabled/> \
															<label for="manage-cc-type">Card Type:</label> \
														</div> \
														<div class="manage-field"> \
															<label for="cc-name">Full Name On Card:</label> \
															<input id="cc-name" class="field-input disabled" name="cc-name" value="Leeroy Jenkins-san" required disabled/> \
														</div> \
														<div class="manage-field dark"> \
															<label for="manage-cc-num">Credi Card Number:</label> \
															<input id="manage-cc-num" class="field-input disabled" name="manage-cc-num" value="**** **** ****'+" " + cc_num.substr(cc_num.length - 4) +'" required disabled/> \
														</div> \
														<div class="manage-field"> \
																<label for="exp-cc-month">Expiration Date:</label> \
															<div class"float-right"> \
																<input id="exp-cc-month" class="field-input monthnew disabled" name="exp-cc-month" value="'+ exp_month +'" required disabled/> \
																<input id="exp-cc-year" class="field-input yearnew disabled" name="exp-cc-year" value="'+ exp_year +'" required disabled/> \
															</div> \
														</div> \
														<div class="manage-field dark"> \
															<label for="manage-cc-zip">Zip/Postal Code:</label> \
															<input id="manage-cc-zip" class="field-input disabled" name="manage-cc-zip" value="33415" required disabled/> \
														</div> \
														<input type="submit" id="delete" name="Delete" value="Delete"> \
														<div class="float-right"> \
															<input type="submit" id="edit" name="Edit" value="Edit"> \
															<input type="submit" id="default" name="Set as default" value="Set as default"> \
														</div> \
													</div> \
												</form> \
											</div>');
        }               
    });
    return false;
});


//Find card type and highlight
function GetCard(){
	//Get card number
	var cardNum = $('#cc-num').val();

	//Reset all cards to half opacity
	$('#amex').fadeTo("fast", .5);
	$('#discover').fadeTo("fast", .5);
	$('#jcb').fadeTo("fast", .5);
	$('#mastercard').fadeTo("fast", .5);
	$('#visa').fadeTo("fast", .5);
	$('#platinum').fadeTo("fast", .5);
	
	//amex
	if(cardNum.substring(0,2) == 34 || cardNum.substring(0,2) == 37){
		$('#amex').fadeTo("fast", 1);
		$('#cc-type').val("AMEX");
	}
	//discover
	else if(cardNum.substring(0,4) == 6011 || (cardNum.substring(0,3) >= 644 && cardNum.substring(0,3) <= 649) || cardNum.substring(0,2) == 65){
		$('#discover').fadeTo("fast", 1);
		$('#cc-type').val("Discover");
	}
	//jcb
	else if(cardNum.substring(0,4) >= 3528 && cardNum.substring(0,4) <= 3589){
		$('#jcb').fadeTo("fast", 1);
		$('#cc-type').val("JCB");
	}
	//mastercard
	else if((cardNum.substring(0,6) >= 222100 && cardNum.substring(0,6) <= 272099) || (cardNum.substring(0,2) >= 51 && cardNum.substring(0,2) <= 55)){
		$('#mastercard').fadeTo("fast", 1);
		$('#cc-type').val("Mastercard");
	}
	//visa
	else if(cardNum.substring(0,1) == 4){
		$('#visa').fadeTo("fast", 1);
		$('#cc-type').val("Visa");
	}
	//empty
	else if(cardNum == ''){
		$('#amex').fadeTo("fast", .5);
		$('#discover').fadeTo("fast", .5);
		$('#jcb').fadeTo("fast", .5);
		$('#mastercard').fadeTo("fast", .5);
		$('#visa').fadeTo("fast", .5);
		$('#platinum').fadeTo("fast", .5);
	}
	//platinum
	else{
		$('#platinum').fadeTo("fast", 1);
		$('#cc-type').val("Platinum");
	}
}
